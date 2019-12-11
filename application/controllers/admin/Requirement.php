<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

require_once ("interfaces/Idata_controller.php");

class Requirement extends MY_Controller  implements Idata_controller
{

	private $canCreate=false;
	private $canDelete=false;

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
		$this->load->model('Auth_Permisions');
		$this->canCreate=$this->Auth_Permisions->can('create_desct_requirement');
		$this->canChange=$this->Auth_Permisions->can('change_desct_requirement');
		$this->canDelete=$this->Auth_Permisions->can('delete_desct_requirement');
	}

    public function dataTable(){
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
	    echo json_encode($results);
    }

    public function index(){
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
		}
	}
	
	public function save(){
		$this->validatePermision($this->canCreate);
		$name = $this->input->post('name');
		$res = $this->Requirement_model->registrar($name);
		if($res){
			$this->structuredResponse(array('message'=>""),200);
		}else{
			$this->structuredResponse(array('message'=>"Ocurrio un error interno"),500);
		}
	}

	public function update(){
		$this->validatePermision($this->canUpdate);
		$name = $this->input->post('name');
		$requirement_id = $this->input->post('requirement_id');
		$data=[];
		$data["name"]=$name;
		$res = $this->Requirement_model->update($requirement_id,$data);
		if($res){
			$this->structuredResponse(array('message'=>""),200);
		}else{
			$this->structuredResponse(array('message'=>"No se actualizo"),200);
		}
	}

	public function edit($requirement_id=-1){
		$res = $this->Requirement_model->getOne($requirement_id);
		if($res){
			$this->structuredResponse($res,200);
		}else{
			$this->structuredResponse(array('message'=>"Ocurrio un error interno"),500);
		}
	}

	public function delete(){
		$this->validatePermision($this->canDelete);
		$requirement_id = $this->input->post('id');
		$res = $this->Requirement_model->delete($requirement_id);
		if($res){
			$this->structuredResponse($res,200);
		}else{
			$this->structuredResponse(array('message'=>"Ocurrio un error interno"),500);
		}
	}

	public function bySolicitud($id){
		$requirements=$this->Requirement_model->bySolicitud($id);
		$this->structuredResponse($requirements);
	}

	public function byDiscount($id){
		$requirements=$this->Requirement_model->byDiscount($id);
		$this->structuredResponse($requirements);
	}

	public function byDiscountRestante($id){
		$requirements=$this->Requirement_model->byDiscount($id);
		$requirement_ids = c_extract($requirements,'id');
		$new_requirements=$this->Requirement_model->byDiscountRestante($requirement_ids);
		$data = array(
			"requirement"=>$requirements,
			"new_requirement"=>$new_requirements
		);
		$this->structuredResponse($data);
	}


}
