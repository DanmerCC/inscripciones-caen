<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {



	public function index()
	{
		$this->load->helper('url');

		$data['cabecera'] = $this->load->view('adminlte/linksHead',NULL,TRUE);
		$data['footer'] = $this->load->view('adminlte/scriptsFooter',NULL,TRUE);
		$data['action'] = "postulante/verificacion";
		$this->load->view('login',$data);
	}

}
