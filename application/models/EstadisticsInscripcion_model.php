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
}
