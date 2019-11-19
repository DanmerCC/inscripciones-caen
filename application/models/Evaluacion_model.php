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

	public  $programa_id_global_filter=null;

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

	function getAllEvaluacionesAndFindTextPage($start,$limit,$search=''){
		$this->query_part_select();
		$this->db->limit($limit,$start);
		if($search!=''){
			$this->db->group_start();
				$this->db->like('nombres',$search,'after');
				$this->db->or_like('apellido_paterno',$search,'after');
				$this->db->or_like('apellido_materno',$search,'after');
			$this->db->group_end();
		}
		$this->filterByPrograma();
		return $this->db->get()->result_array();
	}

	function query_part_select(){
		$this->db->select();
		$this->db->from($this->table);
		$this->db->join('alumno',$this->table.'.'.$this->alumno_id.'=alumno.id_alumno');
		$this->db->join('curso',$this->table.'.'.$this->programa_id.'=curso.id_curso');
	}

	function getAllEvaluaccionesPage($start,$limit){
		$this->query_part_select();
		$this->db->limit($limit,$start);
		$this->filterByPrograma();
		return $this->db->get()->result_array();
	}

	function count(){
		$this->db->select($this->id);
		$this->db->from($this->table);
		return $this->db->get()->num_rows();
	}

	function countByInscripcion($id_inscripcion){
		$this->db->select("COUNT($this->id) as cantidad");
		$this->db->from($this->table);
		$this->db->where($this->inscripcion_id,$id_inscripcion);
		$result=$this->db->get();
		return $result->result_array()[0]['cantidad'];
	}
	private function filterByPrograma(){
		if($this->programa_id_global_filter!=null){
			$this->db->group_start();
				$this->db->where($this->programa_id,(int)$this->programa_id_global_filter);
			$this->db->group_end();
		}
	}

	public function create($id_inscripcion){
		$this->load->model('Inscripcion_model');
		$this->load->model('Solicitud_model');
		try {
			$inscripcion=$this->Inscripcion_model->getOneOrFail($id_inscripcion);
		} catch (\Exception $e) {
			throw $e;
			exit;
		}
		$inscripcion=$this->Inscripcion_model->getOneOrFail($id_inscripcion);
		$solicitud=$this->Solicitud_model->getOrFail($inscripcion['solicitud_id']);
		$idUsuario=$this->nativesession->get('idUsuario');
		$data=array(
			'inscripcion_id'=>$inscripcion['id_inscripcion'],
			'alumno_id'=>$solicitud['alumno'],
			'programa_id'=>$solicitud['programa'],
			'created_user_id'=>$idUsuario,
		);
		$this->db->insert($this->table,$data);
		return $this->db->affected_rows()==1;
	}
}
