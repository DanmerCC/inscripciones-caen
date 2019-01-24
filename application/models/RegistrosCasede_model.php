<?php


class RegistrosCasede_model extends CI_Model {

	private $table='participante';
	private $DB2;
	function __construct(){
		parent::__construct();
		$this->DB2 = $this->load->database('dbcasede', TRUE);
		$this->load->helper('mihelper');
	}


	function listar(){

		$this->DB2->select();
		$this->DB2->from($this->table);
		$query = $this->DB2->get();
		return resultToArray($query);
		
	}


}
