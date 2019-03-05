<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FilesController extends CI_Controller {

    public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('Nativesession');
		$this->load->library('Mihelper');
		$this->load->model('Solicitud_model');
    }
    
    public function get_file_view_as_data(){
		$segmentOfTypeFile=$this->uri->segment(4);
		//$segmentOfNumberDni=$this->uri->segment(5);
		$id=$this->uri->segment(5);
		$data="";
		$pathFile="";

		$this->load->model('Alumno_model');
		$result=resultToArray($this->Alumno_model->all($id));
		//first element
		
		if(count($result)==1){
			$alumno=$result[0];
		}else{
			show_404();
			die();
		}
		
		if(!$alumno){
			show_404();
			die();
		}

		switch ($segmentOfTypeFile) {
			case 'cv':
				$pathFile=CC_BASE_PATH."/files/cvs/".$alumno["documento"].".pdf";
				break;
			case 'dj':
				$pathFile=CC_BASE_PATH."/files/djs/".$alumno["documento"].".pdf";
				break;
			case 'dni':
				$pathFile=CC_BASE_PATH."/files/dni/".$alumno["documento"].".pdf";
				break;
			case 'bach':
				$pathFile=CC_BASE_PATH."/files/bachiller/".$alumno["documento"].".pdf";
				break;
			case 'maes':
				$pathFile=CC_BASE_PATH."/files/maestria/".$alumno["documento"].".pdf";
				break;
			case 'doct':
				$pathFile=CC_BASE_PATH."/files/doctorado/".$alumno["documento"].".pdf";
				break;
			case 'sins':
				$pathFile=CC_BASE_PATH."/files/sInscripcion/".$alumno["documento"].".pdf";
				break;
			case 'hdatos':
				$pathFile=CC_BASE_PATH."/files/hdatos/".$id.".pdf";
				break;
			default:
				$pathFile="";
				show_404();
				die();
				break;
		}

		if($this->nativesession->get('tipo')=='admin'){

			if((($pathFile!=""))&&(file_exists($pathFile))){
				$data=base64_encode(file_get_contents($pathFile,true));
				$this->load->view("pdf/viewpdf",array('data'=>$data,'idAlumno'=>$alumno["id_alumno"],'typeFile'=>$segmentOfTypeFile));///Load view pdf of only watch
			}else{
				show_404();
			}
		}elseif($this->nativesession->get('tipo')=='alumno'){
			if($alumno["documento"]==$this->nativesession->get('dni')){
				if((!($pathFile==""))&&(file_exists($pathFile))){
					$data=base64_encode(file_get_contents($pathFile,true));
					$this->load->view("pdf/onlyviewpdf",array('data'=>$data));///Load view pdf for admin marks
				}else{
					show_404();
				}
			}
		}else{
			show_404();
		}
	}
	
	function mark_file_good($id_alumno){

	}

	public function get_fileSolicitud_view_as_data(){
		$segmentOfTypeFile=$this->uri->segment(4);
		//$segmentOfNumberDni=$this->uri->segment(5);
		$id=$this->uri->segment(5);
		$data="";
		$pathFile="";

		switch ($segmentOfTypeFile) {
			case 'hdatos':
				$pathFile=CC_BASE_PATH."/files/hojadatos/".$id.".pdf";
				break;
			default:
				$pathFile="";
				show_404();
				die();
				break;
		}

		if($this->nativesession->get('tipo')=='admin'){
				show_404();
		}elseif($this->nativesession->get('tipo')=='alumno'){
			if($this->Solicitud_model->existByIdAndAlumno($id,$this->nativesession->get('idAlumno'))){
				if((!($pathFile==""))&&(file_exists($pathFile))){
					$data=base64_encode(file_get_contents($pathFile,true));
					$this->load->view("pdf/onlyviewpdf",array('data'=>$data));///Load view pdf for admin marks
				}else{
					show_404();
				}
			}
		}else{
			show_404();
		}
		
	}

	public function info($fileName){
		$this->load->model('Alumno_model'); 
		$alumno=$this->Alumno_model->findById($this->nativesession->get('idAlumno'))[0];
		$deletable=false;
		
		$resultModel;
		$resultModel["name"]=NULL;
		$resultModel["urlDeleting"]="#";
		$resultModel["removable"]=false;
		$resultModel["properties"]=[];
		$resultModel["identifier"]=[];

		switch ($fileName) {
			case 'cv':
				$pathFile=CC_BASE_PATH."/files/cvs/".$alumno["documento"].".pdf";
				
				$resultModel["name"]=$this->nativesession->get('idAlumno');
				$resultModel["urlDeleting"]="pathDelete/".$this->nativesession->get('idAlumno');
				$resultModel["removable"]=((!isset($alumno["check_cv_pdf"]))&&(file_exists($pathFile)));
				$resultModel["properties"]=[];
				$resultModel["identifier"]='cv';
				break;
			case 'dj':
				$pathFile=CC_BASE_PATH."/files/djs/".$alumno["documento"].".pdf";
				
				$resultModel["name"]=$this->nativesession->get('idAlumno');
				$resultModel["urlDeleting"]="pathDelete/".$this->nativesession->get('idAlumno');
				$resultModel["removable"]=((!isset($alumno["check_dj_pdf"]))&&(file_exists($pathFile)));
				$resultModel["properties"]=[];
				$resultModel["identifier"]='dj';
				break;
			case 'dni':
				$pathFile=CC_BASE_PATH."/files/dni/".$alumno["documento"].".pdf";
				
				$resultModel["name"]=$this->nativesession->get('idAlumno');
				$resultModel["urlDeleting"]="pathDelete/".$this->nativesession->get('idAlumno');
				$resultModel["removable"]=((!isset($alumno["check_dni_pdf"]))&&(file_exists($pathFile)));
				$resultModel["properties"]=[];
				$resultModel["identifier"]='dni';
				break;
			case 'bach':
				$pathFile=CC_BASE_PATH."/files/bachiller/".$alumno["documento"].".pdf";
				
				$resultModel["name"]=$this->nativesession->get('idAlumno');
				$resultModel["urlDeleting"]="pathDelete/".$this->nativesession->get('idAlumno');
				$resultModel["removable"]=((!isset($alumno["check_bach_pdf"]))&&(file_exists($pathFile)));
				$resultModel["properties"]=[];
				$resultModel["identifier"]='bach';
				break;
			case 'maes':
				$pathFile=CC_BASE_PATH."/files/maestria/".$alumno["documento"].".pdf";
				
				$resultModel["name"]=$this->nativesession->get('idAlumno');
				$resultModel["urlDeleting"]="pathDelete/".$this->nativesession->get('idAlumno');
				$resultModel["removable"]=((!isset($alumno["check_maes_pdf"]))&&(file_exists($pathFile)));
				$resultModel["properties"]=[];
				$resultModel["identifier"]='maes';
				break;
			case 'doct':
				$pathFile=CC_BASE_PATH."/files/doctorado/".$alumno["documento"].".pdf";
				
				$resultModel["name"]=$this->nativesession->get('idAlumno');
				$resultModel["urlDeleting"]="pathDelete/".$this->nativesession->get('idAlumno');
				$resultModel["removable"]=((!isset($alumno["check_doct_pdf"]))&&(file_exists($pathFile)));
				$resultModel["properties"]=[];
				$resultModel["identifier"]='doct';
				break;
			case 'sins':
				$pathFile=CC_BASE_PATH."/files/sInscripcion/".$alumno["documento"].".pdf";
				
				$resultModel["name"]=$this->nativesession->get('idAlumno');
				$resultModel["urlDeleting"]="pathDelete/".$this->nativesession->get('idAlumno');
				$resultModel["removable"]=((!isset($alumno["check_sins_pdf"]))&&(file_exists($pathFile)));
				$resultModel["properties"]=[];
				$resultModel["identifier"]='sins';
				break;
			case 'hdatos':
				$id=$this->input->post('id');
				$pathFile=CC_BASE_PATH."/files/hojadatos/".$id.".pdf";
				
				$resultModel["name"]=$this->nativesession->get('idAlumno');
				$resultModel["urlDeleting"]="pathDelete/".$this->nativesession->get('idAlumno');
				$resultModel["removable"]=(file_exists($pathFile));
				$resultModel["properties"]=[""];
				$resultModel["identifier"]='hdatos';
				break;
			default:
				$pathFile="";
				show_404();
				die();
				break;
		}


		
		echo json_encode($resultModel);
	}




}
