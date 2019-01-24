<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ApiPais extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('Nativesession');
		$this->load->model('Pais_model');
	}


	public function listar(){
		echo json_encode($this->Pais_model->all());
	}

}