<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class TokenManager_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('mihelper');
	}


	function getNewToken($username,$password){
		
	}
}
