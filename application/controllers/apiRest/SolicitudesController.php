<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SolicitudesController extends MY_Controller {


	public function __construct(){
        parent::__construct();
		$this->load->model('Solicitud_model');
		$this->load->model('EstadoFinanzasSolicitud_model');
		$this->load->model('FinObservacionesSolicitud_model');
		$this->load->helper('mihelper');
		$this->load->helper('env');
	}
	
	public function get(){
		if($this->verify_token()){
			return $this->response("No authorizado",401);
		}
		
		return $this->response($this->mihelper->resultToArray($this->Solicitud_model->getAll()));
	}

	function updatestate(){

		$ins_id = $this->uri->segment(4);
		$json_request_body = json_decode(file_get_contents('php://input'));
		$state_id  = (int)$json_request_body->state_id;
		$comment = $json_request_body->comment??"";
		$token = $json_request_body->TOKEN;

		$permits_array = [
			$this->EstadoFinanzasSolicitud_model->OBSERVADO,
			$this->EstadoFinanzasSolicitud_model->VALIDADO_AUTOMATIC
		];

		if(!($ins_id && $state_id)){
			return $this->response(["status"=>false,"message"=>"falta parametros"],403);
		}

		if(!in_array($state_id,$permits_array)){
			return $this->response(["status"=>false,"message"=>"estado no permitido","sdasd"=>$permits_array]);
		}

		/*if($state_id==$this->EstadoFinanzasSolicitud_model->OBSERVADO){
			if($comment){
				return $this->response(["status"=>false,"message"=>"estado no permitido"]);
			}
		}*/

		if($this->Apitoken_model->exist($token)){
			$token  = $this->Apitoken_model->use($token);
			$result=$this->Solicitud_model->setEstadoFinanzas($ins_id,$state_id);
			if($state_id==$this->EstadoFinanzasSolicitud_model->OBSERVADO){
				$result2=$this->FinObservacionesSolicitud_model->create($ins_id,env('BOT_USER_ID',NULL),$comment);
			}

			return $this->response([
				"result"=>true,
				"message"=>"Correctamente cargado"
			]);
		}else{
			return $this->response([
				"result"=>false,
				"message"=>"No authorizado"
			],200);
		}
	}
}
