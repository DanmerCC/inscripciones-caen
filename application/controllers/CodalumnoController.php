<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CodalumnoController extends MY_Controller {

	protected $has_create_cod_alumno;

	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('Nativesession');
		$this->load->model('Codalumno_model');
		$this->load->model('Auth_Permisions');
		$this->has_create_cod_alumno=$this->Auth_Permisions->can('has_create_cod_alumno');
	}


	public function create(){

		if(!$this->has_create_cod_alumno){
			return $this->jsonUnauthorized([
				"message"=>"No tienes permiso para crear codigos de alumno",
				"status"=>false
			]);
		}

		$ALUMNO_ID_NOT_CLEAN  = 1;

		$id_request = $this->input->post('ids');
		$ids  = explode(",",$id_request);
		
		if($this->Codalumno_model->all_is_valid($ids)){

			$result = $this->Codalumno_model->crear($ids);
			return $this->jsonResponse([
				"message"=>"Se registraron {$result} codigos",
				"status"=>true
			]);

		}else{
			
			return $this->jsonResponse([
				"message"=>"Existe un alumno que ya tienen  codigo",
				"code"=>$ALUMNO_ID_NOT_CLEAN,
				"status"=>false
			],400);
		}
	}

}
