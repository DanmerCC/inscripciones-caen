<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Files_Controller extends MY_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('Alumno_model');
		$this->load->model('Solicitud_model');
		
    }
    
	public function getFile(){
		$this->verify_token();
		$segmentOfTypeFile=$this->uri->segment(4);
		//$segmentOfNumberDni=$this->uri->segment(5);
		$id=$this->uri->segment(5);
		$data="";
		$pathFile="";

		
		$result;
		$idNameAndRegist=NULL;

		switch ($segmentOfTypeFile) {
			case 'cv':
				$result=resultToArray($this->Alumno_model->all($id))[0];
				$pathFile=CC_BASE_PATH."/files/cvs/".$result["documento"].".pdf";
				
				$idNameAndRegist=$result["id_alumno"];
				break;
			case 'dj':
				$result=resultToArray($this->Alumno_model->all($id))[0];
				$pathFile=CC_BASE_PATH."/files/djs/".$result["documento"].".pdf";
				
				$idNameAndRegist=$result["id_alumno"];
				break;
			case 'dni':
				$result=resultToArray($this->Alumno_model->all($id))[0];
				$pathFile=CC_BASE_PATH."/files/dni/".$result["documento"].".pdf";
				
				$idNameAndRegist=$result["id_alumno"];
				break;
			case 'bach':
				$result=resultToArray($this->Alumno_model->all($id))[0];
				$pathFile=CC_BASE_PATH."/files/bachiller/".$result["documento"].".pdf";
				
				$idNameAndRegist=$result["id_alumno"];
				break;
			case 'maes':
				$result=resultToArray($this->Alumno_model->all($id))[0];
				$pathFile=CC_BASE_PATH."/files/maestria/".$result["documento"].".pdf";
				
				$idNameAndRegist=$result["id_alumno"];
				break;
			case 'doct':
				$result=resultToArray($this->Alumno_model->all($id))[0];
				$pathFile=CC_BASE_PATH."/files/doctorado/".$result["documento"].".pdf";
				
				$idNameAndRegist=$result["id_alumno"];
				break;
			case 'sins':
				$result=resultToArray($this->Alumno_model->all($id))[0];
				$pathFile=CC_BASE_PATH."/files/sInscripcion/".$result["documento"].".pdf";
				
				$idNameAndRegist=$result["id_alumno"];
				break;
			case 'hdatos':
				$pathFile=CC_BASE_PATH."/files/hojadatos/".$id.".pdf";
				$result=$this->Solicitud_model->getAllColumnsById($id);
				$idNameAndRegist=$result["idSolicitud"];
				break;
			case 'solad':
				$pathFile=CC_BASE_PATH."/files/sol-ad/".$id.".pdf";
				$result=$this->Solicitud_model->getAllColumnsById($id);
				$idNameAndRegist=$result["idSolicitud"];
				break;
			case 'pinvs':
				$pathFile=CC_BASE_PATH."/files/proinves/".$id.".pdf";
				$result=$this->Solicitud_model->getAllColumnsById($id);
				$idNameAndRegist=$result["idSolicitud"];
				break;
			default:
				$pathFile="";
				show_404();
				die();
				break;
		}

		if((!($pathFile==""))&&(file_exists($pathFile))){
			$data=base64_encode(file_get_contents($pathFile,true));
			$this->load->view("pdf/onlyviewpdf",array('data'=>$data));///Load view pdf for admin marks
		}else{
			show_error("Error al buscar un archivo",404);
		}
	}
}
