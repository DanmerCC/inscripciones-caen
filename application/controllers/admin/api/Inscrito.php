<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Inscrito extends CI_Controller
{
	
	public function __construct()

	{
		parent::__construct();
		$this->load->library('Nativesession');
		$this->load->helper('url');
		$this->load->model('Solicitud_model');
	}

	public function index(){
		$this->Solicitud_model->getAll();
	}
}