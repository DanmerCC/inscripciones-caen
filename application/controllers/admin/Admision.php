<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Admision extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('Nativesession');
		$this->load->library('Mihelper');
		$this->load->library('opciones');
		$this->load->helper('url');
		$this->load->model('Inscripcion_model');
		$this->load->model('Permiso_model');
		$this->load->model('Actasadmision_model');
		$this->load->model('Admision_model');
		$this->load->model('Auth_Permisions');
		$this->hascreateacta=$this->Auth_Permisions->can('add_acta_admision');
		$this->hascreateadmision=$this->Auth_Permisions->can('add_admisions_alumnos');
	}

	public function create(){

		$inscripcion_id = $this->input->post('inscripcion_id');
		$id_curso = $this->input->post('id_curso');
		$alumno_id = $this->input->post('alumno_id');


		$haspermission = $this->hascreateacta && $this->hascreateadmision;
		$data_is_complete = (count($inscripcion_id) == count($id_curso) && count($id_curso) == count($alumno_id));
		//cambiar
		if(!$haspermission){
			return $this->jsonUnauthorized(["message"=>"No tienes los permisos necesarios"]);
		}

		if(!$data_is_complete){
			return $this->response("Los datos no pueden ser procesados");
		}

		$admisions = [];

		$id_acta = $this->Actasadmision_model->create('file-admd');

		foreach ($inscripcion_id as $key => $value) {

			array_push($admisions,$this->Admision_model->getArrayObject($alumno_id[$key],$inscripcion_id[$key],$id_curso[$key],$id_acta));
		}

		try{

			$regist_success = $this->Admision_model->bulk($admisions);

			return $this->response([
				"message"=>"se registraron ".$regist_success." admisiones",
				"success"=>true,
				"data"=>[
					"actaadmision"=>$id_acta,
					"url"=>$this->urlActa($id_acta)
				]
			]);

		}catch (Exception $e){

			return $this->response($e->getMessage(),500);
		}
		

		exit;
		
	}

	public function urlActa($id_acta){
		return base_url()."administracion/acta/view/".$id_acta;
	}


	public function show($id_acta){

		$acta  = $this->Actasadmision_model->find($id_acta)[0];
		$file = $this->Actasadmision_model->getPath().$acta->filename;
		header('Content-type: application/pdf');
		header('Content-Disposition: inline; filename="'.$acta->filename.'"');
		readfile($file);
	}

	public  function byinscripcion($id_inscription){

		$acta  = $this->Admision_model->by_inscription($id_inscription);

		return $this->response(json_encode($acta));
	}

	public function details($id_acta){

		//$admisions  = $this->Admision_model->by_acta($id_acta);

		//$this->load->model('Auth_Permisions');

		if ($this->nativesession->get('tipo')=='admin') {
			$identidad["rutaimagen"]="/dist/img/avatar5.png";
			$identidad["nombres"]=$this->nativesession->get('acceso');
			$opciones["rutaimagen"]=$identidad["rutaimagen"];
			$opciones["menu"]=$this->opciones->segun($this->Permiso_model->lista($this->nativesession->get('idUsuario')),'Inscripcion');
			$data['cabecera']=$this->load->view('adminlte/linksHead','',TRUE);
			$data['footer']=$this->load->view('adminlte/scriptsFooter','',TRUE);
			$data["mainSidebar"]=$this->load->view('adminlte/main-sideBar',$opciones,TRUE);
			$data['mainHeader']=$this->load->view('adminlte/mainHeader',array("identity"=>$identidad),TRUE);
			//$data['estados_finanzas']=$this->estado_finanzas;
			$data['estados_admision']=$this->EstadoAdmisionInscripcion_model->all();
			$data['can_change_to_admision']=$this->Auth_Permisions->can('change_inscription_to_admision');
			$data['admisions']= $this->Admision_model->by_acta($id_acta);
			$data['id_acta']= $id_acta;

			$this->load->view('dashboard_admision',$data);
		}else
		{
			redirect('administracion/login');
		}

	}
	
}
