<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class FinanzasTipoAuthorization_model extends CI_Model
{
	private $table='fin_tipo_authorizacion';
	private $id='id';
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
	public function getOrFail($id){
		$this->db->select()->from($this->table)->where($this->id,$id);
		$result=$this->db->get();
		if($result->num_rows()==1){
			return $result->result_array()[0];
		}else{
			throw new Exception ("Tipo de Authorizacion no encontrada en ".self::class." ".__FUNCTION__ );
		}
	}
}
