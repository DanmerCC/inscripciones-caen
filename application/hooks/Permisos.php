<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Permisos
{
	private $ci;
	private $section_route;

	public function __construct(){
		$this->ci = &get_instance();
		$this->ci->load->library('Nativesession');
	}

	public function verificar(){
			echo var_dump($this->ci->uri->segment(1));
			exit;
	}

	//Exactly url exception
	public function uriExceptions(){
		return [
			'/login',
			'/administracion/login',
			'/registro',
			'/public/api/programas'
		];
	}

	public function have_not_session(){
		return $this->ci->nativesession->get('idUsuario')==NULL;
	}

}
