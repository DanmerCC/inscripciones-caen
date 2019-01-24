<?php 

class Pais_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('mihelper');
	}


	function all(){

		$query='SELECT nombre FROM pais';

		return resultToArray($this->db->query($query)); 
	}


}