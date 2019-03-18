<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class LoginHook
{
	private $ci;
	private $section_route;
    public function __construct()
    {
		$this->ci = &get_instance();
		$this->ci->load->library('Nativesession');
	}

	public function check_login()
    {
		for ($i=0; $i < count($this->section_route) ; $i++) { 
			if(!in_array($_SERVER["REQUEST_URI"],$this->section_route[$i]->uriExceptions())){
				if($this->have_not_session() && $this->section_route[$i]->loged_required){
					if($this->section_route[$i]->redirect()){
						break;
					};
				}
			}
		}
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
