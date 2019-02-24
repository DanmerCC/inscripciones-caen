<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class AuthoritiesUser_model extends CI_Model
{

	private $id_table='authorities_user';
	private $user_id='user_id';
	private $authorities_id='authorities_id';

	function __construct()
	{
		parent::__construct();
		$this->load->helper('mihelper');
	}


	function findByUser($user_id){
		$this->db->select();
		$this->db->from($this->table);
		$this->db->where($this->user_id,$user_id);
		return $this->get();
	}
}
