<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class FinObservaciones_model extends MY_Model
{
	private $id='id';
	private $table='fin_observaciones';
	private $inscripcion_id='inscripcion_id';
	private $usuario_id='usuario_id';
	private $comentario='comentario';

	function __construct()
	{
		parent::__construct();
	}

	public function ultimo($id_inscripcion){
		$this->db->select()->from($this->table)->where($this->inscripcion_id,$id_inscripcion)->limit(1)->order_by($this->id,'DESC');
		$result=$this->db->get();
		if($result->num_rows()==1){
			return $result->result_array()[0];
		}else{
			return "";
		}
	}

	public function create($inscripcion_id,$usuario_id,$comentario){
		$data=[
			$this->inscripcion_id=>$inscripcion_id,
			$this->usuario_id=>$usuario_id,
			$this->comentario=>$comentario
		];
		$this->db->insert($this->table,$data);
		return $this->db->affected_rows()==1;
	}

}
