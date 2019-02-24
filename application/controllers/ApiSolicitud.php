<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class ApiSolicitud extends CI_Controller
{
	private $table='solicitud';

	private $id='idSolcitud';
	private $programa='programa';
	private $alumno='alumno';
	private $tipo_financiamiento='tipo_financiamiento';
	private $fecha_registro='fecha_registro';
	private $fecha_modificado='fehca_mod';
	private $estado='estado';
	private $marca_pago='marcaPago';
	private $comentario='comentario';

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Nativesession');
		$this->load->helper('url');
	}

	public function get_estado(){
		$value=$this->input->post('token');


	}


	public function verify_token(){
		$token=$this->input->post('token');
		if(!isset($token)){
			show_404();
			die();
		}

		
	}
	
}
