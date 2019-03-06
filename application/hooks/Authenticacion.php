<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Authenticacion
{
    private $ci;
    public function __construct()
    {
		$this->ci = &get_instance();
        !$this->ci->load->library('Nativesession') ? $this->ci->load->library('Nativesession') : false;
        !$this->ci->load->helper('url') ? $this->ci->load->helper('url') : false;
    }

    public function check_login()
    {
			/*
		$havesession=((!$this->ci->nativesession->get('id')) == false);
		if($this->ci->uri->segment(1)=="administracion"){
			if($this->is_loged()){
				
			}else{
				redirect(base_url("administracion/login"));
			}
		}*/
	}
	private function is_loged(){
		return ($this->ci->nativesession->get("estado")=="logeado");
	}
}

