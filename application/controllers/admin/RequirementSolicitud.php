<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

require_once ("interfaces/Idata_controller.php");

class RequirementSolicitud extends MY_Controller  implements Idata_controller
{
	
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
		$solicitud_id=$this->input->post('solicitud_id');
		$requirement_id=$this->input->post('requirement_id');
		$this->Requirement_model->addSolicitud($solicitud_id,$requirement_id);
	}

	public function update(){
		
	}

	public function edit($requirement_id=-1){
		
	}

	public function delete(){
		
	}
}