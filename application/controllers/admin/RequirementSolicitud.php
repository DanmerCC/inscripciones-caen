<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

require_once ("interfaces/Idata_controller.php");

class RequirementSolicitud extends MY_Controller  implements Idata_controller
{

	private $canUpdateRequirement=false;
	function __construct()
	{
		parent::__construct();
		$this->load->library('Nativesession');
		$this->load->library('Mihelper');
		$this->load->helper('url');
		$this->load->model('Requirement_model');
		$this->load->helper('mihelper');
		$this->load->library('opciones');
		$this->load->model('Permiso_model');
		$this->load->model('Solicitud_model');
		$this->load->model('User_model');
		$this->load->model('Permiso_model');
		$this->canUpdateRequirement=$this->Auth_Permisions->can('change_desct_requirement');
	}

    public function dataTable(){
		/*
		$rspta = $this->Requirement_model->all();
	    //vamos a declarar un array
	    $data = Array();
	    header("Content-type: application/json");
	    $i=0;
	    foreach ($rspta as $value) {
	            $data[] = array(
				"0" => '<button class="btn btn-warning" onclick="mostrarFormPro(' .$value["id"]. ')"><i class= "fa fa-pencil"></i></button>
						<button class="btn btn-danger" onclick="eliminar(' .$value["id"]. ')"><i class= "fa fa-trash"></i></button>',
	            "1" => $value["name"],
	        );
	     }        
	    $results = array(
	        "sEcho" => 1, //Informacion para datatables
	        "iTotalRecords" => count($data), //enviamos el total de registros al datatables
	        "iTotalDisplayRecords" => count($data), //enviamos total de registros a visualizar
	        "aaData" => $data);
	    echo json_encode($results);*/
    }

    public function index(){
		/*
    	if ($this->nativesession->get('tipo')=='admin') {
			$identidad["rutaimagen"]="/dist/img/avatar5.png";
			$identidad["nombres"]=$this->nativesession->get('acceso');
			$opciones["rutaimagen"]=$identidad["rutaimagen"];
			$opciones["menu"]=$opciones["menu"]=$this->opciones->segun($this->Permiso_model->lista($this->nativesession->get('idUsuario')),'Beneficios');

			$data['cabecera']=$this->load->view('adminlte/linksHead','',TRUE);
			$data['footer']=$this->load->view('adminlte/scriptsFooter','',TRUE);
			$data["mainSidebar"]=$this->load->view('adminlte/main-sideBar',$opciones,TRUE);
			$data['mainHeader']=$this->load->view('adminlte/mainHeader',array("identity"=>$identidad),TRUE);
			$this->load->view('dashboard_requirement',$data);
		}else
		{
			redirect('administracion/login');
		}*/
	}
	
	public function save(){

		$this->validatePermision($this->canUpdateRequirement);

		$id=$this->input->post('id');
		if(!$this->issetRequestInputs('post',['solicitud_id','requirement_id'])){
			$this->structuredResponse(array('message'=>'Se esperaba mas argumentos'),200);
		}

		$solicitud_id=$this->input->post('solicitud_id');
		$requirement_id=$this->input->post('requirement_id');
		$result=null;
		if($this->isAlumno()){
			//$usuario=$this->User_model->byAlumno($this->nativesession->get('idAlumno'));
			$usuario=$this->User_model->byAlumno($id);
			$solicitudesByAlumn=$this->Solicitud_model->getByAlumno($usuario['alumno']);
			$ids_solicitudes=c_extract($solicitudesByAlumn,'idSolicitud');
			if(in_array($solicitud_id,$ids_solicitudes)){
				$result=$this->Requirement_model->addInSolicitudPivot($solicitud_id,$requirement_id);
				$this->structuredResponse(array("message"=>"se actualizo el registro"),200);
			}else{
				throw new Exception("Se intento registrar una solicitud no autorizadas");
			}
		}

		var_dump($this->isAlumno());
		exit;

		$this->structuredResponse("No tienes permiso para agregar el registro",401);
		
		
	}

	public function update(){
		
	}

	public function edit($requirement_id=-1){
		
	}

	public function delete(){
		
	}

	public function isAlumno(){
		return $this->nativesession->get('tipo')=="alumno";
	}

	public function byIsAvaliableByAlumno($idAlumno){
		//$this->;
	}

}
