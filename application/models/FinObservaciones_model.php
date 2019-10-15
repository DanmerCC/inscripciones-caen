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
		$this->db->select()->from($this->table)->where($this->inscripcion_id,$id_inscripcion)->limit(1)->order_by();
		$result=$this->db->get();
		if($result->num_rows()==1){

		}
	}


}
