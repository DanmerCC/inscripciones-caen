<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FilesController extends CI_Controller {

    public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('Nativesession');
		$this->load->library('Mihelper');
    }
    
    public function get_file_view_as_data(){
		$segmentOfTypeFile=$this->uri->segment(4);
		//$segmentOfNumberDni=$this->uri->segment(5);
		$segmentIdOfAlumno=$this->uri->segment(5);
		$data="";
		$pathFile="";

		$this->load->model('Alumno_model');
		$result=resultToArray($this->Alumno_model->all($segmentIdOfAlumno));
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
}
