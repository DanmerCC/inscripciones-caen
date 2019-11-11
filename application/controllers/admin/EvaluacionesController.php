<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class EvaluacionesController extends MY_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->library('Nativesession');
		$this->load->library('Mihelper');
		$this->load->library('opciones');
		$this->load->helper('url');
		$this->load->model('Evaluacion_model');
		$this->load->model('Permiso_model');
		$this->load->model('Evaluacion_model');
	}

	function index(){
	if ($this->nativesession->get('tipo')=='admin') {
			$identidad["rutaimagen"]="/dist/img/avatar5.png";
			$identidad["nombres"]=$this->nativesession->get('acceso');
			$opciones["rutaimagen"]=$identidad["rutaimagen"];
			$opciones["menu"]=$this->opciones->segun($this->Permiso_model->lista($this->nativesession->get('idUsuario')),'Evaluaciones');
			$data['cabecera']=$this->load->view('adminlte/linksHead','',TRUE);
			$data['footer']=$this->load->view('adminlte/scriptsFooter','',TRUE);
			$data["mainSidebar"]=$this->load->view('adminlte/main-sideBar',$opciones,TRUE);
			$data['mainHeader']=$this->load->view('adminlte/mainHeader',array("identity"=>$identidad),TRUE);
			$this->load->view('dashboard_evaluaciones',$data);
		}else
		{
			redirect('administracion/login');
		}
	}
	public function datatable(){
		$search=$this->input->post("search[]");
		$start=$this->input->post('start');
		$length=$this->input->post('length');
		$activeSearch=!(strlen($search["value"])==0);
		if(strlen($search["value"])>0){
			$rspta = $this->Evaluacion_model->getAllEvaluacionesAndFindTextPage($start,$length,$search["value"]);
		}else{
			$rspta = $this->Evaluacion_model->getAllInscritosPage($start,$length);
		}
		$cantidad=$this->Evaluacion_model->count();
	   //vamos a declarar un array
	   $data = Array();
	   $i=$start;


	   foreach ($rspta as $value) {
		$i++;
		$haveFileCv=file_exists(CC_BASE_PATH."/files/cvs/".$value["documento"].".pdf");
		$haveFileDni=file_exists(CC_BASE_PATH."/files/dni/".$value["documento"].".pdf");
		$haveFileDj=file_exists(CC_BASE_PATH."/files/djs/".$value["documento"].".pdf");
		$haveFileBach=file_exists(CC_BASE_PATH."/files/bachiller/".$value["documento"].".pdf");
		$haveFileMaes=file_exists(CC_BASE_PATH."/files/maestria/".$value["documento"].".pdf");
		$haveFileDoct=file_exists(CC_BASE_PATH."/files/doctorado/".$value["documento"].".pdf");

		$checkCv=($value["check_cv_pdf"])?"<i class='fa fa-check' aria-hidden='true'></i>":"";
		$checkDni=($value["check_dni_pdf"])?"<i class='fa fa-check' aria-hidden='true'></i>":"";
		$checkDj=($value["check_dj_pdf"])?"<i class='fa fa-check' aria-hidden='true'></i>":"";
		$checkBachiller=($value["check_bach_pdf"])?"<i class='fa fa-check' aria-hidden='true'></i>":"";
		$checkMaestria=($value["check_maes_pdf"])?"<i class='fa fa-check' aria-hidden='true'></i>":"";
		$checkDoctorado=($value["check_doct_pdf"])?"<i class='fa fa-check' aria-hidden='true'></i>":"";

	           $data[] = array(
				"0" => $activeSearch?"-":(($cantidad-$i)+1),
	           "1" => $value["grado_profesion"],
	           "2" => $value["nombres"],
	           "3" => $value["apellido_paterno"],
	           "4" => $value["apellido_materno"],
	           "5" => $value["lugar_trabajo"],
							"6" => $value["celular"]." \n ".$value["telefono_casa"],
							"7" => $value["email"],
							"8" => (($haveFileCv)?"<a href='".base_url()."admin/view/pdf/cv/".$value["id_alumno"]."' target='_blank'><button class='btn btn-primary'><strong>Abrir".$checkCv."</strong></button></a>":"<button class='btn btn-light btn-sm'>No subido</button>"),
							"9" => (($haveFileDni)?"<a href='".base_url()."admin/view/pdf/dni/".$value["id_alumno"]."' target='_blank'><button class='btn btn-primary'><strong>Abrir".$checkDni."</strong></button></a>":"<button class='btn btn-light btn-sm'>No subido</button>"),
							"10" => (($haveFileDj)?"<a href='".base_url()."admin/view/pdf/dj/".$value["id_alumno"]."' target='_blank'><button class='btn btn-primary'><strong>Abrir".$checkDj."</strong></button></a>":"<button class='btn btn-light btn-sm'>No subido</button>"),
							"11" => (($haveFileBach)?"<a href='".base_url()."admin/view/pdf/bach/".$value["id_alumno"]."' target='_blank'><button class='btn btn-primary'><strong>Abrir".$checkBachiller."</strong></button></a>":"<button class='btn btn-light btn-sm'>No subido</button>"),
							"12" => (($haveFileMaes)?"<a href='".base_url()."admin/view/pdf/maes/".$value["id_alumno"]."' target='_blank'><button class='btn btn-primary'><strong>Abrir".$checkMaestria."</strong></button></a>":"<button class='btn btn-light btn-sm'>No subido</button>"),
							"13" => (($haveFileDoct)?"<a href='".base_url()."admin/view/pdf/doct/".$value["id_alumno"]."' target='_blank'><button class='btn btn-primary'><strong>Abrir".$checkDoctorado."</strong></button></a>":"<button class='btn btn-light btn-sm'>No subido</button>"),
							);
	    }        
	   $results = array(
	       "sEcho" => $this->input->post('sEcho'), //Informacion para datatables
	       "iTotalRecords" => $cantidad, //enviamos el total de registros al datatables
	       "iTotalDisplayRecords" => $cantidad, //enviamos total de registros a visualizar
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
		$this->load->view("pdf/onlyviewpdf",array('data'=>$data,'text'=>var_dump($parturl)));
	}


	/**End class */
	
}
