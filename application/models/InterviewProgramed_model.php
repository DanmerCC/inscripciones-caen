<?php 
/**
 * 
 */
class InterviewProgramed_model extends MY_Model
{
	private $table='intvw_programmed_interviews';
	private $id='id';

	private $alumno_id='alumno_id';
	private $inscripcion_id='inscripcion_id';
	private $estado_id='estado_id';
	private $fecha_programado='fecha_programado';
	private $created='created';
	private $updated='updated';

	
	function __construct()
	{
		parent::__construct();
		$this->load->model('StateInterviewProgramed_model');
		$this->load->model('Inscripcion_model');
		$this->load->model('Solicitud_model');
		
	}

	function create($inscripcion_id,$fecha_programado){
		$this->db->trans_begin();
		try{
			$inscripcion=$this->Inscripcion_model->getOneOrFail($inscripcion_id);
			$solicitud=$this->Solicitud_model->getOrFail($inscripcion["solicitud_id"]);
			$data=array(
				$this->alumno_id=>$solicitud["alumno"],
				$this->inscripcion_id=>$inscripcion_id,
				$this->estado_id=>$this->StateInterviewProgramed_model->PENDIENTE,
				$this->fecha_programado=>$fecha_programado
			);
			$this->db->insert($this->table,$data);
		}catch(Exception $e){
			$this->db->trans_rollback();
		}
		$this->db->trans_commit();
		$correct_query=$this->db->affected_rows()==1;
		return $correct_query;
	}

	function byIdInscripcion($idInscripcion){
		$this->db->select();
		$this->db->from($this->table);
		$this->db->where($this->inscripcion_id,$idInscripcion);
		$result=$this->db->get();
		return $result->result_array();
	}

	function lastedById($idInscripcion){
		$this->db->select();
		$this->db->from($this->table);
		$this->db->where($this->inscripcion_id,$idInscripcion);
		$this->db->limit(1);
		$this->db->order_by($this->id,'desc');
		$result=$this->db->get();
		if($result->num_rows()==1){
			return $result->result_array()[0];
		}else{
			return new stdClass;
		}
	}

}
