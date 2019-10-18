<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class FinanzasTipoAuthorization_model extends CI_Model
{
	private $table='fin_tipo_authorizacion';
	private $nombre='nombre';
	private $descripcion='descripcion';

	function __construct()
	{
		parent::__construct();
	}

	function all(){
		$this->db->select()->from($this->table);
		return $this->db->get()->result_array();
	}
}
