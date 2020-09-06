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

		$errors = [];

		if(!$this->has_create_cod_alumno){
			return $this->jsonUnauthorized([
				"message"=>"No tienes permiso para crear codigos de alumno",
				"status"=>false
			]);
		}

		$ALUMNO_ID_NOT_CLEAN  = 1;

		$id_request = $this->input->post('std_cods');

		if($id_request==""){
			return $this->jsonResponse([
				"message"=>"Debes seleccionar algun registro",
				"status"=>false
			]);
		}
		try {
			$list  = explode(";",$id_request);
			$data = [];

			for ($i=0; $i < count($list); $i++) {

				$parts = explode(",",$list[$i]);

				$element = [
					"id_alumno"=>$parts[0],
					"cod_student_admin"=>$parts[1]
				];
				array_push($data,$element);
			}
		}catch(Exception $e){
			return $this->jsonResponse([
				"message"=>"Error al procesar el formato",
				"code"=>400,
				"status"=>false
			],400);
		}
		
		if($this->Codalumno_model->all_is_valid(array_column($data,'id_alumno'))){

			$result = $this->Codalumno_model->crear($data);
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

	public function maxCode(){
		$maxCode = $this->Codalumno_model->maxCodeAmdin();
		$this->jsonResponse([
			"data"=>$maxCode,
			"status"=>true
		]);
	}

}
