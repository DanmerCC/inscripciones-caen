<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Panel extends CI_Controller
{
	
	public function __construct()

	{
		parent::__construct();
		$this->load->library('Nativesession');
		$this->load->library('Opciones');
		$this->load->helper('url');
		$this->load->model('Permiso_model');
		$this->load->model('Inscripcion_model');
	}
	public function index(){

		if ($this->nativesession->get('tipo')=='admin') {
			$identidad["rutaimagen"]="/dist/img/avatar5.png";
			$identidad["nombres"]="Nombre de prueba para administracion";
			$opciones["rutaimagen"]=$identidad["rutaimagen"];
			$opciones["menu"]=$opciones["menu"]=$this->opciones->segun($this->Permiso_model->lista($this->nativesession->get('idUsuario')),'Alumnos');
			$data['cabecera']=$this->load->view('adminlte/linksHead','',TRUE);
			$data['footer']=$this->load->view('adminlte/scriptsFooter','',TRUE);
			$data["mainSidebar"]=$this->load->view('adminlte/main-sideBar',$opciones,TRUE);
			$data['mainHeader']=$this->load->view('adminlte/mainHeader',array("identity"=>$identidad),TRUE);
			$this->load->view('dashboard',$data);
		}else
		{
			redirect('administracion/login');
		}
		
	}

	public function home(){
		if ($this->nativesession->get('tipo')=='admin') {
			$identidad["rutaimagen"]="/dist/img/avatar5.png";
			$identidad["nombres"]="Nombre de prueba para administracion";
			$opciones["rutaimagen"]=$identidad["rutaimagen"];
			$opciones["menu"]=$opciones["menu"]=$this->opciones->segun($this->Permiso_model->lista($this->nativesession->get('idUsuario')),'');
			$data['cabecera']=$this->load->view('adminlte/linksHead','',TRUE);
			$data['footer']=$this->load->view('adminlte/scriptsFooter','',TRUE);
			$data["mainSidebar"]=$this->load->view('adminlte/main-sideBar',$opciones,TRUE);
			$data['mainHeader']=$this->load->view('adminlte/mainHeader',array("identity"=>$identidad),TRUE);

			$data['resume_data'] = $this->Inscripcion_model->resumen();
			$data['debug'] = $this->db->last_query();

			$programas = [];
			$temp_ids= [];

			foreach ($data['resume_data'] as $resume) {
				$tempid = $resume->id_curso;
				$findprogramas=null;
				if(!in_array($tempid,$temp_ids)){
					$findprogramas['id_curso'] = $tempid;
					$findprogramas['nombre_programa'] = $resume->nombre_programa;
				}
				array_push($programas,$findprogramas);

			}
			
			$data['resume_programas'] = $programas;

			$this->load->view('dashboard',$data);
		}else
		{
			redirect('administracion/login');
		}
	}

	public function login(){
		$data['cabecera'] = $this->load->view('adminlte/linksHead',NULL,TRUE);
		$data['footer'] = $this->load->view('adminlte/scriptsFooter',NULL,TRUE);
		$data['action'] ="/administracion/validacion";
		$data['title'] ="CAEN ADMIN";
		$data['activeRegist'] =false;

		$this->load->view('login',$data);
	}
	public function validacion(){
		$user=$this->input->post('usuario');
		$password=$this->input->post('password');

		$this->db->select('id,acceso,password,alumno,tipo');
		$this->db->from('usuario');
		$this->db->where('usuario.acceso',$user);
		$this->db->where('usuario.tipo !=',"alumno");
		$result = $this->db->get();

		//$result=$this->db->query('SELECT alumno.documento,id,acceso,password,alumno from usuario left join alumno on usuario.alumno = alumno.id_alumno')->get();
		if ($result->num_rows() == 1) {
			if(password_verify($password,$result->result()[0]->password)){
				
				/*Estableciendo variables de session*/
				$this->nativesession->set('idUsuario',$result->result()[0]->id);
				$this->nativesession->set('acceso',$result->result()[0]->acceso);
				$this->nativesession->set('tipo',$result->result()[0]->tipo);
				$this->nativesession->set('estado','logeado');
				$casedes=(($result->result()[0]->tipo=='casede')||($result->result()[0]->tipo=='casedeanf'));
				if($casedes){
				    //desocmentar para desbloquear
				    redirect(base_url().'administracion/vista/casede', 'refresh');
				    ///Bloqueo
				    //redirect(base_url().'administracion/login', 'refresh');
				    //end bloqueo
				}else if($result->result()[0]->tipo=='admin'){
				    redirect(base_url().'administracion/home', 'refresh');
				}
				
			}else{
				echo "<script>".
			              "alert('Datos incorrectos');".
			              "window.location.assign('".base_url("/administracion/login")."')".
			          "</script>";
		          //header("Refresh: 5; url=".base_rul()."login");
        		redirect(base_url().'administracion/login', 'refresh');
			}
        }else{
        	//$this->session->set_flashdata('correcto', 'Datos incorrectos');
        	//lista general
        	redirect(base_url().'administracion/login', 'refresh');
        	//echo var_dump($result);
        }

	}

    public function cerrarSession(){
        $this->nativesession->destroy();
		redirect(base_url().'administracion/login','refresh');
    }


	public function matriculas(){
			if ($this->nativesession->get('tipo')=='admin') {
			$identidad["rutaimagen"]="/dist/img/avatar5.png";
			$identidad["nombres"]="Nombre de prueba para administracion";
			$opciones["rutaimagen"]=$identidad["rutaimagen"];
				$opciones["menu"]=[
					[
					"text"=>"Alumnos",
					"submenu"=>[
							[
								"text"=>"Solicitantes",
								"atributos"=>"id='solicitantes'"
							]
						]
					],
					[
					"text"=>"Matriculas",
					"submenu"=>[
							[
								"text"=>"General",
								"atributos"=>"id='aSolicitudes' data-toggle='collapse' data-parent='#accordion' href='#collapse8'"
							],
							[
								"text"=>"Nueva matricula",
								"atributos"=>"id='' data-toggle='collapse' data-parent='#accordion' href='#collapse8'"
							],
						]
					],
					[
					"text"=>"Programas",
					"submenu"=>[
							[
								"text"=>"Todos",
								"atributos"=>"id='programas' data-toggle='collapse' data-parent='#accordion' href='#collapse8'"
							],
							[
								"text"=>"Nuevo",
								"atributos"=>"id='formNuevoPro' data-toggle='collapse' data-parent='#accordion' href='#collapse8'"
							]
						]
					],
					[
					"text"=>"Beneficios",
					"submenu"=>[
							[
								"text"=>"Informacion Personal",
								"atributos"=>"id='' data-toggle='collapse' data-parent='#accordion' href='#collapse8'"
							]
						]
					],
				];
			$data['cabecera']=$this->load->view('adminlte/linksHead','',TRUE);
			$data['footer']=$this->load->view('adminlte/scriptsFooter','',TRUE);
			$data["mainSidebar"]=$this->load->view('adminlte/main-sideBar',$opciones,TRUE);
			$data['mainHeader']=$this->load->view('adminlte/mainHeader',array("identity"=>$identidad),TRUE);
			$this->load->view('dashboard',$data);
		}else
		{
			redirect('administracion/login');
		}
	}

}
