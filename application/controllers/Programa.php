<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 
/**
 * 
 */
class Programa extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->library('Nativesession');
		$this->load->library('Mihelper');
		$this->load->helper('url');
		$this->load->model('Programa_model');
		$this->load->library("Mihelper");
		$this->load->library('opciones');
		$this->load->model('Permiso_model');
	}

    public function allActives($tipo_id=null){
		header('Content-Type: application/json');
		$this->load->model('Programa_model');
		if(isset($tipo_id)){
			$programas=$this->Programa_model->allActivesByType($tipo_id);
		}else{
			$programas=$this->Programa_model->allActives();
		}
		

			$result=[];
			$i=0;

			foreach ($programas->result_array() as $row){
				$result[$i]=$row;
				$i++;
			}

			echo json_encode($result,JSON_UNESCAPED_UNICODE);
		
    }

	public function getTypes(){
		header('Content-Type: application/json');
		$this->load->model('Programa_model');
		$tipos=$this->Programa_model->getAllTipos();

			$result=[];
			$i=0;

			foreach ($tipos->result_array() as $row){
				$result[$i]=$row;
				$i++;
			}

		echo json_encode($result,JSON_UNESCAPED_UNICODE);
	}
    

}