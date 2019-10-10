<?php 
/**
* 
*/
class CasedeController extends CI_Controller
{
	private $diad;
	public function __construct()
	{
		parent::__construct();
		$this->load->model('RegistrosCasede_model');
		$this->load->library('Nativesession');
		$this->load->helper('url');
		$this->load->library('opciones');
		$this->load->model('Regcasede_model');
		$this->diad=((date('Y-m-d')=='2019-11-14') or(date('Y-m-d')=='2019-14-15'));
	}

    public function marcarAsistenciaQ(){
        if($this->diad){
            $idInscrito=$this->input->post('inscrito');
            try{
                echo $this->RegistrosCasede_model->insertarAsistencia($idInscrito);
                $this->Regcasede_model->insert_new_reg($this->nativesession->get('acceso'), 'casede_inscritos', 'asist', null);
            }catch(Exception $e){
                $this->Regcasede_model->insert_new_reg($this->nativesession->get('acceso'), 'casede_inscritos', $e->getMessage(),null);
                echo 0;
            }
            
        }else{
            echo '0';
        }
        
    }
    //insertarAsistencia_seg
    public function marcarAsistenciaD(){
        if($this->diad){
            $idInscrito=$this->input->post('inscrito');
            try{
                echo $this->RegistrosCasede_model->insertarAsistencia_seg($idInscrito);
                $this->Regcasede_model->insert_new_reg($this->nativesession->get('acceso'), 'casede_inscritos', 'insert', 'na');
            }catch(Exception $e){
                $this->Regcasede_model->insert_new_reg($this->nativesession->get('acceso'), 'casede_inscritos', $e->getMessage(),'na');
                echo $e->getMessage();
                echo 0;
            }
            
        }else{
            echo '0';
        }
    }
    
	public function listarComoDatatable(){
	    $endia=((date('Y-m-d')=='2018-11-14') or(date('Y-m-d')=='2018-11-16'));
	    $dia=explode('-',date('Y-m-d'))[2];
		$rspta=$this->RegistrosCasede_model->listar();
		$data = Array();
	    $i=0;
	    foreach ($rspta as $value) {
	            $data[] = array(
                "0" => $i=$i+1,
	            "1" => $value["nombres_apellidos"],
	            "2" => $value["dni"],
	            "3" => $value["edad"],
	            "4" => $value["email"],
	            "5" => $value["centro_trabajo"],
	            "6" => $value["profesion"],
	            "7" => $value["telefono"],
	            "8" => $value["grado_academico"],
	            "9" => $value["motivo"],
	            "10" => $value["fecha_inscripcion"],
	            "11" => (!(!($value["marca_asistencia"])&&$this->diad&&$dia=='14')?($value["marca_asistencia"]?$value["marca_asistencia"]:"<button class='btn btn-warning' disabled>No disponible</button>"):"<button class='btn btn-primary' onclick='marcaruno(".$value["id_participante"].")'>Asistencia Jueves</button>"),
	            "12" => (!(!($value["marca_asistencia_seg"])&&$this->diad&&$dia=='15')?($value["marca_asistencia_seg"]?$value["marca_asistencia_seg"]:"<button class='btn btn-warning' disabled>No disponible</button>"):"<button class='btn btn-primary' onclick='marcardos(".$value["id_participante"].")' >Asistencia Viernes</button>")
	            //"13"=>$value["idmd5Badge"]
	        );
	     }        
	    $results = array(
	        "sEcho" => 1, //Informacion para datatables
	        "iTotalRecords" => count($data), //enviamos el total de registros al datatables
	        "iTotalDisplayRecords" => count($data), //enviamos total de registros a visualizar
			"aaData" => $data
		);
	    echo json_encode($results);
	}

    public function index(){
        $admitido=(($this->nativesession->get('tipo')=='casede')||($this->nativesession->get('tipo')=='casedeanf'));
    	///PARA QUE SE PUEDA INICIAR SESSION EN EL PERFIL SE TIENE QUE SER DE TIPO 'CASEDE'
    	if ($admitido) {
			$identidad["rutaimagen"]="/dist/img/avatar5.png";
			$identidad["nombres"]=$this->nativesession->get('acceso');
			$opciones["rutaimagen"]=$identidad["rutaimagen"];
			$opciones["menu"]=$this->opciones->casede();
			$data['cabecera']=$this->load->view('adminlte/linksHead','',TRUE);
			$data['footer']=$this->load->view('adminlte/scriptsFooter','',TRUE);
			$data["mainSidebar"]=$this->load->view('adminlte/main-sideBar',$opciones,TRUE);
			$data['mainHeader']=$this->load->view('adminlte/mainHeader',array("identity"=>$identidad),TRUE);
			$this->load->view('dashboard_casede',$data);
		}else
		{
			redirect('administracion/login');
		}

    }
    
    function prueba(){
        echo intval((date('Y-m-d')=='2018-11-15') or(date('Y-m-d')=='2018-11-16'));
	    echo date('Y-m-d');
	    echo date_default_timezone_get();
	    echo explode('-',date('Y-m-d'))[2];
	}
	
	function registroasistencia(){
	    $nombres_ap=$this->input->post('nombres_ap');
	    $dni=$this->input->post('dni');
	    $edad=$this->input->post('edad');
	    $email=$this->input->post('email');
	    $centro_laboral=$this->input->post('centro_laboral');
	    $profesion=$this->input->post('profesion');
	    $celular=$this->input->post('celular');
	    $grado_academico=$this->input->post('grado_academico');
	    $motivo=$this->input->post('consulta');
	    if($this->nativesession->get('tipo')=='casedeanf'){
	        try{
	            $this->RegistrosCasede_model->registroConAsistencia($nombres_ap,$dni,$edad,$email,$centro_laboral,$profesion,$celular,$grado_academico,$motivo);
	        }catch(Exception $e){
	            echo $e->getMessage();
	        }
	    }
	}
}
