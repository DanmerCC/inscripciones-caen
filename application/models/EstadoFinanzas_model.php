<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class EstadoFinanzas_model extends CI_Model
{
	public $table='estado_finanzas';

	public function __construct()
	{
		parent::__construct();
	}

	function all(){
		$result=$this->db->select()->from($this->table)->get();
		return $result->result_array();
	}
}
