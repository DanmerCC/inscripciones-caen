<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class FinanzasAuthorization_model extends CI_Model
{

	private $id='id';
	private $table='fin_authorizacion_inscrito';
	private $author_usuario_id='author_usuario_id';
	private $inscripcion_id='inscripcion_id';
	private $comentario='comentario';
	private $tipo_id='tipo_id';

	function __construct()
	{
		parent::__construct();
	}

	function create($usuario_id,$inscripcion_id,$tipo_id,$comentario=''){
		$data=array(
			$this->author_usuario_id=>$usuario_id,
			$this->inscripcion_id=>$inscripcion_id,
			$this->comentario=>$comentario,
			$this->tipo_id=>$tipo_id
		);
		$this->db->insert($this->table,$data);
		return ($this->db->affected_rows()==1);
	}

	function all(){
		$this->db->select()->from($this->table);
		$result=$this->db->get();
		return $result->result_array();

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
}
