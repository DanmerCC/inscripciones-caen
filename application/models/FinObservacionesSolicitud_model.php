<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class FinObservacionesSolicitud_model extends MY_Model
{
	private $id='id';
	private $table='fin_observaciones_solicitud';
	private $solicitud_id='solicitud_id';
	private $usuario_id='usuario_id';
	private $comentario='comentario';

	function __construct()
	{
		parent::__construct();
	}

	public function ultimo($id_solicitud){
		$this->db->select()->from($this->table)->where($this->solicitud_id,$id_solicitud)->limit(1)->order_by($this->id,'DESC');
		$result=$this->db->get();
		if($result->num_rows()==1){
			return $result->result_array()[0];
		}else{
			return "";
		}
	}

	public function create($solicitud_id,$usuario_id,$comentario){
		$data=[
			$this->solicitud_id=>$solicitud_id,
			$this->usuario_id=>$usuario_id,
			$this->comentario=>$comentario
		];
		$this->db->insert($this->table,$data);
		return $this->db->affected_rows()==1;
	}

	public function update($message_id,$solicitud_id,$usuario_id,$comentario){
		$data=[
			$this->solicitud_id=>$solicitud_id,
			$this->usuario_id=>$usuario_id,
			$this->comentario=>$comentario
		];
		$this->db->where($this->id,$message_id)->update($this->table,$data);
	}

}
