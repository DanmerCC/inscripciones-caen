<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Solicitud extends CI_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('Nativesession');
		$this->load->library('Mihelper');
		$this->load->helper('url');
		$this->load->model('Solicitud_model');
	}

	public function index(){
		header('Content-Type: application/json');
		header("Access-Control-Allow-Origin: *");
		echo json_encode($this->mihelper->resultToArray($this->Solicitud_model->getAll()));
	}
}