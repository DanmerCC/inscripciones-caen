<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Programa extends CI_Controller
{
	
	public function __construct()
	{

		parent::__construct();
		$this->load->library('Nativesession');
		$this->load->helper('mihelper');
		$this->load->helper('url');
	}

	public function index()
	{
		header('Content-Type: application/json');
		$this->load->model('Programa_model');
		$programa=$this->Programa_model->all();
		$result=resultToArray($programa);
		echo json_encode($result,JSON_UNESCAPED_UNICODE);
	}
} 