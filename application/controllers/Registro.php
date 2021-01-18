<?php
defined('BASEPATH') or exit('No direct script access allowed');

require('./vendor/autoload.php');
class Registro extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
		$this->load->library('Nativesession');
		$this->load->helper('mihelper');
		$this->load->helper('env');
		$this->load->model('Programa_model');
		$this->load->model('Notificacion_model');
		$this->load->model('Deudores_model');
		$this->load->model('EstadoFinanzasSolicitud_model');
		$this->load->model('FinObservacionesSolicitud_model');
    }

    public function index()
    {
        $tipos=$this->Programa_model->types();
        if(isset($_GET["dp"])){
            $programa_defecto=$this->Programa_model->findById($_GET["dp"]);
            
            $id_programa_defecto=$programa_defecto["id_curso"];
            $typo_defecto=$programa_defecto["idTipo_curso"];

            if($programa_defecto["estado"]==="0"){
                $id_programa_defecto=null;
                $typo_defecto=null;
            }
        }else{
            $id_programa_defecto=null;
            $typo_defecto=null;
        }
        $data['cabecera'] = $this->load->view('adminlte/linksHead', '', true);
        $data['footer']   = $this->load->view('adminlte/scriptsFooter', '', true);
        $data['defaultIdProgram']=$id_programa_defecto;
        $data['defaultIdProgramType']=$typo_defecto;
        $data['tipos']=$tipos;
        $this->load->view('register', $data);
    }

    public function guardar()
    {
    		$id_usuario_dni = trim($this->input->post('id'));//el id por defecto sera el dni pero puede ser cambiado  cualquier otro

	        $nombre           = trim($this->input->post('nombre'));
	        $apellido_paterno = trim($this->input->post('apellido_paterno'));
	        $apellido_materno = trim($this->input->post('apellido_materno'));
	        $password         = $this->input->post('password');
            $email            = trim($this->input->post('email'));
			$celphone         = trim($this->input->post('celphone'));
            $programa_id      =$this->input->post('programa_id');
            $tipoFinan          =$this->input->post('tipoFinan');

            if($this->isNotSetArray([$id_usuario_dni,$email,$programa_id,$tipoFinan,$celphone])){
                $data["heading"]="Ah ocurrido un error ";
                $data["message"]="Su cuenta  no se registro intentelo nuevamente";
                $data["seconds"]="4";
                $data["url"]="/postulante";
                echo $this->load->view('errors/custom/flash_msg',$data,TRUE);
                echo "Error se detecto un valor nulo";
                die();
            }
        $ql = $this->db->select('documento')->from('alumno')->where('documento',$id_usuario_dni)->or_where('email',$email)->get();
        if ($ql->num_rows() > 0) {
			$alumno=$ql->result_array()[0];
            $data["heading"]=" YA ESTA REGISTRADO";
            $data["message"]="<h1><strong>Ya existe </strong> un registro con el mismo numero de Numero de documento o correo electronico</h1> intentelo nuevamente";
			$data["seconds"]="5";
			$data["url"]="/login?user=".$alumno["documento"];
        	echo $this->load->view('errors/custom/flash_msg',$data,TRUE);
			die();
        } else {

            /*Captura de errores para primer registro*/
			$this->load->model('Alumno_model');
			$alumno = $this->Alumno_model->registrar($apellido_paterno, $apellido_materno, $nombre, $id_usuario_dni,$email,$celphone);
            $this->load->model('User_model');
            
            //Agrega una solicitud
            

            if($this->User_model->registrar($id_usuario_dni, $email, $password, $alumno)){
                $nuevo_alumno=$this->Alumno_model->find($alumno);
                $nuevo_usuario=$this->User_model->byAlumno($nuevo_alumno["id_alumno"]);
                $this->nativesession->regenerateId();
                $this->nativesession->set('idAlumno',$nuevo_alumno["id_alumno"]);
                $this->nativesession->set('idUsuario',$nuevo_usuario["id"]);
                $this->nativesession->set('dni',$nuevo_alumno["documento"]);
                $this->nativesession->set('estado','logeado');
				$this->nativesession->set('tipo',$nuevo_alumno["tipo"]);

				$estado_finan_id = null;
				
                if($this->Alumno_model->nuevaSolicitud($programa_id, $alumno, $tipoFinan,$estado_finan_id)){
					$id_solicitud = $this->db->insert_id();

					if(env('PAGOS_ACTIVE_DEBTORS_EP',false)){
						try {
							$tokencallback = $this->Apitoken_model->create();
							$this->Deudores_model->runCallbackValidate($id_solicitud,$tokencallback);
						} catch (\Exception $e) {
							
							log_message('info', $e->getMessage());
						}
						
					}

                   $programa_result=$this->Programa_model->findWithFullname($programa_id);
                    $this->Notificacion_model->create(array(
						'action_id'=>10,//create solicitud
						'mensaje'=>'El alumno '.
						$nuevo_alumno["nombres"].
						" </br> ".$nuevo_alumno["apellido_paterno"].
						" ".$nuevo_alumno["apellido_materno"]."</br>".
						" se registro y a solicitado </br> ".
						" su incripcion a </br> ".
						$programa_result["fullname"],
						'tipo_usuario_id'=>2//admin
					));
                    $data["heading"]="Se registro correctamente";
                    $data["message"]="Su cuenta  $id_usuario_dni a sido registrada correctamente";
                    $data["seconds"]="5";
					$data["url"]="/postulante";
					$this->session->set_flashdata('question_sol_id', $id_solicitud);    
                }
                
                $this->load->view('errors/custom/flash_msg',$data);
            }else{
                $data["heading"]="Ah ocurrido un error ";
                $data["message"]="Su cuenta no se registro intentelo nuevamente";
                $data["seconds"]="4";
                $data["url"]="/postulante";
                $this->load->view('errors/custom/flash_msg',$data);
            }
            
        }


    }

    private function isNotSetArray($array,$operator='and'){
        $result=false;
        for ($i=0; $i < count($array); $i++) { 
           if((!isset($array[$i]))||($array[$i]=="")||($array[$i]==NULL)){
               $result=true;
               //echo var_dump($array[$i]);
               //exit;
               break;
           }
        }
        return $result;
	}
	
	private function genericRequest($url,$body,$headers=[],$method='GET'){
		
		$cu=curl_init($url);
		if ($cu === false) {
			throw new Exception('failed to initialize');
		}
		if($method=='POST'){
			curl_setopt($cu, CURLOPT_POST, true);
		}
		curl_setopt($cu, CURLOPT_POSTFIELDS, json_encode($body));
		curl_setopt($cu, CURLOPT_VERBOSE, true);
		curl_setopt($cu, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($cu, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($cu);

		if ($result === false) {
			throw new Exception(curl_error($cu), curl_errno($cu));
		}
		curl_close($cu);
		
		return $result;
	}
	public function registrotest(){

		/*$this->load->model('Apitoken_model');
		$resultado = $this->Apitoken_model->create();*/
		echo var_dump(base_url().env('BOT_PATH_BACK'));
		//$this->Apitoken_model->use($resultado);
		exit;
		return "-";
	}

    

}
