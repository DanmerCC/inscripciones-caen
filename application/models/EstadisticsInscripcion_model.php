<?php 
/**
 * Inscripciones _model
 */
class EstadisticsInscripcion_model extends CI_Model
{
	private $table='inscripcion';
	private $id='id_inscripcion';
	private $solicitud_id='solicitud_id';
	private $created_user_id='created_user_id';
	private $estado_finanzas_id='estado_finanzas_id';
	private $estado_admision_id='estado_admision_id';
	private $created='created';
	//** Determina si el registro existe */
	private $deleted='deleted';
	private $modified='modified';

	private $where_filters=[];


	private $public_columns=[];

	public $global_stado_finanzas=[];

	public $array_estado_finanzas=[];

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('mihelper');
		$this->public_columns=[
			$this->id,
			$this->solicitud_id,
			$this->created_user_id,
			$this->estado_finanzas_id
		];
		$this->where_filters=array(
			$this->deleted=>NULL
		);
		$this->load->model('EstadoFinanzas_model');
		$this->array_estado_finanzas=$this->EstadoFinanzas_model->all();
	}

	public function inscritosPorFechas($fechaInicio,$fechaFin,$programa_ids=[]){
		$this->db->select('COUNT(inscripcion.id_inscripcion) as cantidad,DATE(inscripcion.created) as fecha,solicitud.programa')
		->from('solicitud')
		->join('inscripcion','solicitud.idSolicitud=inscripcion.solicitud_id')
		
		->where("inscripcion.created > '$fechaInicio'",NULL)
		->where("inscripcion.created < '$fechaFin'",NULL);
		if(count($programa_ids)>0){
			$this->db->where_in("solicitud.programa",$programa_ids);
		}
		
		$this->db->group_by('DATE(inscripcion.created)');
		$this->db->group_by('solicitud.programa');
		
		return $this->db->get()->result_array();
	}

	public function inscritosPorPrograma(){
		$this->db->select('COUNT(solicitud.idSolicitud) as cantidad,alumno.si_militar,solicitud.programa,')
		->from('alumno')
		->join('solicitud','solicitud.alumno=alumno.id_alumno')
		->join('inscripcion','inscripcion.solicitud_id=solicitud.idSolicitud')
		->group_by('alumno.si_militar,solicitud.programa');

		return $this->db->get()->result_array();
	}

	public function exalumnosPorPrograma(){
		$this->db->select(
			'COUNT(inscripcion.id_inscripcion) as cantidad,'.
			'alumno.curso_caen,'.
			'alumno.curso_maestria,'.
			'solicitud.programa,'
		)
		->from('alumno')
		->join('solicitud','solicitud.alumno=alumno.id_alumno')
		->join('inscripcion','inscripcion.solicitud_id = solicitud.idSolicitud')
		->group_by('alumno.curso_caen,alumno.curso_maestria ,solicitud.programa');
		return $this->db->get()->result_array();
	}

	function porGenero(){
		$this->db->select(
			'COUNT(inscripcion.id_inscripcion) as cantidad,'.
			'alumno.genero'
		)
		->from('alumno')
		->join('solicitud','solicitud.alumno =alumno.id_alumno')
		->join('inscripcion','inscripcion.solicitud_id = solicitud.idSolicitud')
		->group_by('alumno.genero');
		return $this->db->get()->result_array();
	}

	function porPrograma(){
		$this->db->select('COUNT(inscripcion.id_inscripcion)as inscritos,CONCAT(tipo_curso.nombre," ",curso.nombre) as programa,curso.numeracion ,curso.id_curso');
		$this->db->from('inscripcion');
		$this->db->join('solicitud','solicitud.idSolicitud=inscripcion.solicitud_id');
		$this->db->join('curso','curso.id_curso=solicitud.programa');
		$this->db->join('tipo_curso','tipo_curso.idTipo_curso=curso.idTipo_curso');
		$this->db->group_by('curso.id_curso');
		$result=$this->db->get();
		return $result->result_array();
	}

	function bySi_militarColumn(){
		$this->db->select("COUNT(inscripcion.id_inscripcion)as cantidad,IF(alumno.si_militar='0','MILITAR','CIVIL') AS tipo");
		$this->db->from('alumno');
		$this->db->join('solicitud','solicitud.alumno=alumno.id_alumno');
		$this->db->join('inscripcion','inscripcion.solicitud_id=solicitud.idSolicitud');
		$this->db->group_by('si_militar');
		$result=$this->db->get();
		return $result->result_array();
	}

	function porLugarDeProcedencia(){
		/**
		 * SELECT 
		 * COUNT(alumno.id_alumno) as cantidad,
		 * alumno.genero FROM alumno
		 *  JOIN solicitud ON solicitud.alumno=alumno.id_alumno 
		 *  JOIN inscripcion ON inscripcion.solicitud_id=solicitud.idSolicitud
		 *  GROUP BY alumno.genero
		 */
		$this->db->select("COUNT(inscripcion.id_inscripcion)as cantidad,alumno.departamento");
		$this->db->from('alumno');
		$this->db->join('solicitud','solicitud.alumno=alumno.id_alumno');
		$this->db->join('inscripcion','inscripcion.solicitud_id=solicitud.idSolicitud');
		$this->db->group_by('alumno.departamento');
		$result=$this->db->get();
		return $result->result_array();
	}
}
