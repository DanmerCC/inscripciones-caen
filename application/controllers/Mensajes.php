<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Mensajes extends CI_Controller
{
	
	public function __construct()
	{

		parent::__construct();
		$this->load->library('Nativesession');
		$this->load->helper('url');
	}

	public function index()
	{

		$mensajes = $this->session->flashdata('mensajes');
		$this->load->view('errors/custom/flash_msg',$mensajes);
	}



} 
