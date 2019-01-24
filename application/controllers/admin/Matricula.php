<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Matricula extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->library('Nativesession');
		$this->load->library('Mihelper');
		$this->load->helper('url');
		$this->load->model('Matricula_model');
		$this->load->library('opciones');
		$this->load->model('Permiso_model');
	}

	function index(){
	if ($this->nativesession->get('tipo')=='admin') {
			$identidad["rutaimagen"]="/dist/img/avatar5.png";
			$identidad["nombres"]=$this->nativesession->get('acceso');
			$opciones["rutaimagen"]=$identidad["rutaimagen"];
			$opciones["menu"]=$opciones["menu"]=$this->opciones->segun($this->Permiso_model->lista($this->nativesession->get('idUsuario')),'Matriculas');
			$data['cabecera']=$this->load->view('adminlte/linksHead','',TRUE);
			$data['footer']=$this->load->view('adminlte/scriptsFooter','',TRUE);
			$data["mainSidebar"]=$this->load->view('adminlte/main-sideBar',$opciones,TRUE);
			$data['mainHeader']=$this->load->view('adminlte/mainHeader',array("identity"=>$identidad),TRUE);
			$this->load->view('dashboard_matricula',$data);
		}else
		{
			redirect('administracion/login');
		}
	}
	public function dataTable(){
		$rspta = $this->Matricula_model->all();
	    //vamos a declarar un array
	    $data = Array();
	    $i=0;


	    foreach ($rspta as $value) {
	            $data[] = array(
	            "0" => '<button class="btn btn-warning" onclick="mostrarFormPro(' .$value["id_matricula"]. ')"><i class= "fa fa-file-o"></i></button>',
	            "1" => $value["documento"],
	            "2" => $value["nombres"],
	            "3" => $value["apellido_paterno"]." ".$value["apellido_materno"],
	            "4" => "programa",
	            "5" => $value["fecha_pago"],
	            "6" => $value["fecha_creador"]
	        );
	     }        
	    $results = array(
	        "sEcho" => 1, //Informacion para datatables
	        "iTotalRecords" => count($data), //enviamos el total de registros al datatables
	        "iTotalDisplayRecords" => count($data), //enviamos total de registros a visualizar
	        "aaData" => $data);
	    echo json_encode($results);
	}
	
}