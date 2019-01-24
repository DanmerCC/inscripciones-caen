<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Alumno extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->library('Nativesession');
		$this->load->library('Mihelper');
		$this->load->library('opciones');
		$this->load->helper('url');
		$this->load->model('Alumno_model');
		$this->load->model('Permiso_model');
	}

	function index(){
	if ($this->nativesession->get('tipo')=='admin') {
			$identidad["rutaimagen"]="/dist/img/avatar5.png";
			$identidad["nombres"]=$this->nativesession->get('acceso');
			$opciones["rutaimagen"]=$identidad["rutaimagen"];
			$opciones["menu"]=$opciones["menu"]=$this->opciones->segun($this->Permiso_model->lista($this->nativesession->get('idUsuario')),'Alumnos');
			$data['cabecera']=$this->load->view('adminlte/linksHead','',TRUE);
			$data['footer']=$this->load->view('adminlte/scriptsFooter','',TRUE);
			$data["mainSidebar"]=$this->load->view('adminlte/main-sideBar',$opciones,TRUE);
			$data['mainHeader']=$this->load->view('adminlte/mainHeader',array("identity"=>$identidad),TRUE);
			$this->load->view('dashboard_alumnos',$data);
		}else
		{
			redirect('administracion/login');
		}
	}
	public function datatable(){
	$rspta = $this->Alumno_model->getAllInscritos();
	   //vamos a declarar un array
	   $data = Array();
	   $i=0;


	   foreach ($rspta as $value) {
	           $data[] = array(
	           "0" => $value["grado_profesion"],
	           "1" => $value["nombres"],
	           "2" => $value["apellido_paterno"],
	           "3" => $value["apellido_materno"],
	           "4" => $value["lugar_trabajo"],
	           "5" => $value["celular"]." \n ".$value["telefono_casa"],
			   "6" => $value["email"],
			   "7"=> (file_exists(CC_BASE_PATH."/files/cvs/".$value["documento"].".pdf")?"<a href='".base_url()."/admin/view/pdf/cv/".$value["documento"]."' target='_blank'><button class='btn btn-primary'><strong>Abrir</strong></button></a>":"<button class='btn btn-light'>No subido</button>"),
			   "8"=> (file_exists(CC_BASE_PATH."/files/dni/".$value["documento"].".pdf")?"<a href='".base_url()."/admin/view/pdf/dni/".$value["documento"]."' target='_blank'><button class='btn btn-primary'><strong>Abrir</strong></button></a>":"<button class='btn btn-light'>No subido</button>"),
			   "9"=> (file_exists(CC_BASE_PATH."/files/djs/".$value["documento"].".pdf")?"<a href='".base_url()."/admin/view/pdf/dj/".$value["documento"]."' target='_blank'><button class='btn btn-primary'><strong>Abrir</strong></button></a>":"<button class='btn btn-light'>No subido</button>")
	       );
	    }        
	   $results = array(
	       "sEcho" => 1, //Informacion para datatables
	       "iTotalRecords" => count($data), //enviamos el total de registros al datatables
	       "iTotalDisplayRecords" => count($data), //enviamos total de registros a visualizar
	       "aaData" => $data);
	   echo json_encode($results);
	}


	public function viewPdfDocument(){
		//$data='data:application/pdf, '.base64_encode(file_get_contents(CC_BASE_PATH."/files/cvs/"."47327529".".pdf",true));
		//echo "";
		$parturl=$this->uri->segment(4);
		$data=base64_encode(file_get_contents(CC_BASE_PATH."/files/cvs/"."47327529".".pdf",true));
		echo var_dump($parturl);
		//echo var_dump($data);
		$this->load->view("viewpdf",array('data'=>$data,'text'=>var_dump($parturl)));
	}
	
}