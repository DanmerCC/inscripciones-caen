<?php 

/*
Modelo de evaluacion acciones relacionadas a una notificacion
*/

class Evaluacion_model extends MY_Model
{
	private $table='adms_evaluaciones';

	private $id='id';
	private $inscripcion_id='inscripcion_id';
	private $alumno_id='alumno_id';
	private $programa_id='programa_id';
	private $doc_adjunto='doc_adjunto';
	private $created_user_id='created_user_id';
	private $created='created';
	private $modificated='modificated';

	function __construct()
	{
		parent::__construct();
		$this->load->helper('mihelper');
		
	}


	function findOrFail($id){
		$this->db->select();
		$this->db->from($this->table);
		$this->db->where($this->id,$id);
		$result=$this->db->get();
		if($result->num_rows()==1){
			return $result->result_array()[0];
		}else{
			throw new Exception("Error al buscar evaluacion");
		}
	}

	function getAllEvaluacionesAndFindTextPage($start,$limit,$search){
		$this->query_part_select();
		$this->db->limit($limit,$start);
		return $this->get()->result_array();
	}

	function query_part_select(){
		$this->db->select();
		$this->db->from($this->table);
		$this->db->join('alumno',$this->table.'.'.$this->id.'=alumno.id_alumno');
	}
	
}
