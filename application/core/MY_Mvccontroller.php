<?php 

defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class MY_Mvccontroller extends CI_Controller
{
    function __construct()
	{
		parent::__construct();
		$this->load->library('Nativesession');
    }
    
	public function verify_login_or_fail(){
		if($this->nativesession->get("estado")!="logeado"){
			show_404();
			exit;
		}
	}
}
