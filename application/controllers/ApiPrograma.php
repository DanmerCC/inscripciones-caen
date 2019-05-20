<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class ApiPrograma extends CI_Controller
{
	
	public function __construct()
	{

		parent::__construct();
		$this->load->library('Nativesession');
		$this->load->helper('url');
	}

	public function index()
	{
		if($this->nativesession->get("estado")=="logeado"){


			$this->load->model('Programa_model');

			$programa=$this->Programa_model->allActives();

				$result=[];
				$i=0;

				foreach ($programa->result_array() as $row){
		            $result[$i]=$row;
		            $i++;
        		}

        		echo json_encode($result,JSON_UNESCAPED_UNICODE);
		}else{
			
			echo "error";
		}

	}

	public function all(){
		$this->verify_login_or_fail();
		$this->load->model('Programa_model');
		$programa=$this->Programa_model->all();

			$result=[];
			$i=0;

			foreach ($programa->result_array() as $row){
				$result[$i]=$row;
				$i++;
			}

		echo json_encode($result,JSON_UNESCAPED_UNICODE);
	}


	public function tipos()
	{
		if($this->nativesession->get("estado")=="logeado"){

			$this->load->model('Programa_model');
			$tipos=$this->Programa_model->getAllTipos();


				$result=[];
				$i=0;

				foreach ($tipos->result_array() as $row){
		            $result[$i]=$row;
		            $i++;
        		}


        		echo json_encode($result,JSON_UNESCAPED_UNICODE);
		}else{
			
			echo "error";
		}

	}


	public function verify_login_or_fail(){
		if($this->nativesession->get("estado")!="logeado"){
			show_404();
			exit;
		}
	}


} 