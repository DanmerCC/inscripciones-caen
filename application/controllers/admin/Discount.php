<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

require_once ("interfaces/Idata_controller.php");

class Discount extends MY_Controller  implements Idata_controller
{
	private $canCreate=false;
	private $canUpdate=false;
	private $canDelete=false;

	function __construct()
	{
		parent::__construct();
		$this->load->library('Nativesession');
		$this->load->library('Mihelper');
		$this->load->helper('url');
		$this->load->model('Discount_model');
		$this->load->helper('mihelper');
		$this->load->library('opciones');
		$this->load->model('Permiso_model');
		$this->canCreate=$this->Auth_Permisions->can('create_desct_discount');
		$this->canChange=$this->Auth_Permisions->can('change_desct_discount');
		$this->canDelete=$this->Auth_Permisions->can('delete_desct_discount');
	}

    public function dataTable(){
		$rspta = $this->Discount_model->all();
	    //vamos a declarar un array
	    $data = Array();
	    header("Content-type: application/json");
	    $i=0;
	    foreach ($rspta as $value) {
	            $data[] = array(
				"0" => '<button class="btn btn-warning" onclick="mostrarFormPro(' .$value["id"]. ')"><i class= "fa fa-pencil"></i></button>
						<button class="btn btn-danger" onclick="eliminar(' .$value["id"]. ')"><i class= "fa fa-trash"></i></button>
						<button class="btn btn-info" title="Ver programas" onclick="verProgramas('.$value["id"].',\''.$value["name"].'\')"><i class= "fa fa-eye"></i></button>
						<button class="btn btn-success" title="Ver requisitos" onclick="agregarRequisitos('.$value["id"].',\''.$value["name"].'\')"><i class= "fa fa-plus"></i></button>',
	            "1" => $value["name"],
	            "2" => $value["description"],
	            "3" => $value["percentage"]." %"
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
			$this->load->view('dashboard_discount',$data);
		}else
		{
			redirect('administracion/login');
		}
	}
	
	public function save(){
		$this->validatePermision($this->canCreate);
		$name = $this->input->post('name');
		$description = $this->input->post('description');
		$percentage = $this->input->post('percentage');
		$res = $this->Discount_model->registrar($name,$description,$percentage);
		if($res){
			$this->structuredResponse(array('message'=>""),200);
		}else{
			$this->structuredResponse(array('message'=>"Ocurrio un error interno"),500);
		}
	}

	public function update(){
		$this->validatePermision($this->canUpdate);
		$data=[];
		$data["name"] = $this->input->post('name');
		$data["description"] = $this->input->post('description');
		$data["percentage"] = $this->input->post('percentage');
		$id=$this->input->post('discount_id');
		$status=$this->Discount_model->update($id,$data);
		if($status){
			return $this->structuredResponse(array('message'=>""),200);
		}else{
			return $this->structuredResponse(array('message'=>"No se actualizo ningun campo"),200);
		}
		
	}

	public function edit($discount_id=-1){
		$res = $this->Discount_model->getOne($discount_id);
		if($res){
			$this->structuredResponse($res,200);
		}else{
			$this->structuredResponse(array('message'=>"Ocurrio un error interno"),500);
		}
	}

	public function delete(){
		$this->validatePermision($this->canDelete);
		$discount_id = $this->input->post('id');
		$res = $this->Discount_model->delete($discount_id);
		if($res){
			$this->structuredResponse($res,200);
		}else{
			$this->structuredResponse(array('message'=>"Ocurrio un error interno"),500);
		}
	}

	public function bySolicitud($id){
		$this->load->model('Solicitud_model');
		$this->load->model('Programa_model');
		$solicitud=$this->Solicitud_model->getOrFail($id);
		$programa=$this->Programa_model->getOneOrFail($solicitud["programa"]);
		$discounts=$this->Discount_model->byCurso($programa["id_curso"]);
		$this->structuredResponse($discounts);
	}
}
