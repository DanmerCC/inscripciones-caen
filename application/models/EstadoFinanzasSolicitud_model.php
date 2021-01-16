<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class EstadoFinanzasSolicitud_model extends CI_Model
{
	public $table='estado_finanzas_solicitud';

	public $PENDIENTE=1;
	public $OBSERVADO=3;
	public $VALIDADO=2;
	public $VALIDADO_AUTOMATIC = 4;
	
	public function __construct()
	{
		parent::__construct();
	}

	function all(){
		$result=$this
		->db
		->select()
		->from($this->table)
		->where_not_in('id',[$this->VALIDADO_AUTOMATIC])
		->get();
		return $result->result_array();
	}
}
