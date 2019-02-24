<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Authorities_model extends CI_Model
{
	private $table='authorities';

	private $id='id_authorities';
	private $nombre='name_authorities';

	public $authorities_table='authorities_table';

	function __construct()
	{
		parent::__construct();
		$this->load->helper('mihelper');
	}


	function findById($id){
		$this->db->select();
		$this->db->from($this->table);
		$this->db->where($this->id,$id);
		$query=$this->db->get();
		return $query->row();
	}
}
