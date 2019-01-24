<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FilesController extends CI_Controller {

    public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('Nativesession');
    }
    
    public function get_file_view_as_data(){
		$segmentOfTypeFile=$this->uri->segment(4);
        $segmentOfNumberDni=$this->uri->segment(5);
		$data="";
		$pathFile="";

		switch ($segmentOfTypeFile) {
			case 'cv':
				$pathFile=CC_BASE_PATH."/files/cvs/".$segmentOfNumberDni.".pdf";
				break;
			case 'dj':
				$pathFile=CC_BASE_PATH."/files/djs/".$segmentOfNumberDni.".pdf";
				break;
			case 'dni':
				$pathFile=CC_BASE_PATH."/files/dni/".$segmentOfNumberDni.".pdf";
				break;
			default:
				$pathFile="";
				break;
		}

		if($this->nativesession->get('tipo')=='admin'){

			if((($pathFile!=""))&&(file_exists($pathFile))){
				$data=base64_encode(file_get_contents($pathFile,true));
			}else{
				show_404();
			}
		}elseif($this->nativesession->get('tipo')=='alumno'){
			if($segmentOfNumberDni==$this->nativesession->get('dni')){
				if((!($pathFile==""))&&(file_exists($pathFile))){
					$data=base64_encode(file_get_contents($pathFile,true));
				}else{
					show_404();
				}
			}
		}else{
			show_404();
		}

		

		$this->load->view("viewpdf",array('data'=>$data));
	}
	
}