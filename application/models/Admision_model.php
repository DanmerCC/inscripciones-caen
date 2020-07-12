<?php 

/*
Modelo de action acciones relacionadas a una notificacion
*/

class Admision_model extends MY_Model
{
	private $table='admisions';

	private $id='id';
	private $alumno_id='alumno_id';
	private $inscription_id='inscription_id';
	private $posgrade_id = 'posgrade_id';
	private $acta_id = 'acta_id';


	function __construct()
	{
		parent::__construct();
		$this->load->helper('mihelper');
		$this->load->model('Inscripcion_model');
		
	}

	function create($data){

		$this->db->insert($this->table,$data);

		return $this->getLastIdOrFail();
	}

	function bulk($data){

		$inscripciondis = [];

		for ($i=0; $i < count($data) ; $i++) { 
			array_push($inscripciondis,$data[$i][$this->inscription_id]);
		}

		$countdata  = count($data);
		
		$affected = $this->db->insert_batch($this->table,$data);

		if($affected == $countdata){

			$this->Inscripcion_model->admids($inscripciondis);

			return $affected;

		}else{
			throw new Exception("Error al volcar admision o admisiones");
		}
	}

	private function getLastIdOrFail(){
		if($this->db->affected_rows()==1){

			return $this->db->insert_id();

		}else{
			throw new Exception("Error al registrar admision o admisiones");
		}
	}

	/**
	 * @method getArrayObject
	 * 
	 * @var integer alumno_id
	 * @var integer inscription_id
	 * @var integer posgrade_id
	 * 
	 * @return array
	 */

	function getArrayObject($alumno_id,$inscription_id,$posgrade_id,$acta_id){
		return [
			$this->alumno_id=>$alumno_id,
			$this->inscription_id=>$inscription_id,
			$this->posgrade_id=>$posgrade_id,
			$this->acta_id=>$acta_id
		];
	}

	function find($id){
		return $this->db->select()->from($this->table)->where('id',$id)->get()->result_object();
	}

	function by_inscription($id){
		return $this->db->
		select()
		->from($this->table)
		->where($this->inscription_id,$id)
		->join('acta_admision','acta_admision.id='.$this->table.'.'.$this->acta_id)
		->get()
		->result_object();
	}

	function by_acta($id){
		return $this->db->
		select($this->table.'.*,alumno.nombres as alumno_nombres,alumno.apellido_paterno as alumno_apellido_paterno,alumno.apellido_materno as alumno_apellido_materno,curso.nombre as curso_nombre')
		->from($this->table)
		->where($this->acta_id,$id)
		->join('acta_admision','acta_admision.id='.$this->table.'.'.$this->acta_id,'left')
		->join('alumno','alumno.id_alumno='.$this->table.'.'.$this->alumno_id,'left')
		->join('curso','curso.id_curso='.$this->table.'.'.$this->posgrade_id,'left')
		->get()
		->result_object();
	}

	
	
}
