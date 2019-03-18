<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class PermisionHook
{
    private $ci;
    public function __construct()
    {
			$this->ci = &get_instance();
			!$this->ci->load->library('Nativesession') ? $this->ci->load->library('Nativesession') : false;
			!$this->ci->load->helper('url') ? $this->ci->load->helper('url') : false;
			$this->ci->load->model('Permiso_model');
    }

	public function verify()
    {	

			//echo "Segundo hook";
			//die();
			//exit;
	}

	
}

