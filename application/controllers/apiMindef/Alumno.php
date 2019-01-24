<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Alumno extends CI_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('Nativesession');
		$this->load->helper('url');
		$this->load->model('Alumno_model');
		$this->load->helper('mihelper');
	}

	public function index(){
		header('Content-Type: application/json');
		$result=resultToArray($this->Alumno_model->getAll());
		echo json_encode($result,JSON_UNESCAPED_UNICODE);
	}
}