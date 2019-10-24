<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class EstadoAdmisionInscripcion_model extends CI_Model
{
	public $table='estado_admisions';

	public $PENDIENTE=1;//POR DEFECTO
	public $ADMITIDO=2;

	private $load_in_memory=[];
	
	public function __construct()
	{
		parent::__construct();
		$this->load_in_memory=$this->getAllFromDataBase();
	}

	function all(){
		return $this->load_in_memory;
	}

	function getAllFromDataBase(){
		$result=$this->db->select()->from($this->table)->get();
		return $result->result_array();
	}
}
