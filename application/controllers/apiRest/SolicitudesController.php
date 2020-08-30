<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SolicitudesController extends MY_Controller {


	public function __construct(){
        parent::__construct();
		$this->load->model('Solicitud_model');
		$this->load->helper('mihelper');
	}
	
	public function get(){
		if($this->verify_token()){
			return $this->response("No authorizado",401);
		}
		
		return $this->response($this->mihelper->resultToArray($this->Solicitud_model->getAll()));
	}
}
