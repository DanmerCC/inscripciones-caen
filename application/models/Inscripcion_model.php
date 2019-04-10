<?php 
/**
 * Inscripciones _model
 */
class Inscripcion_model extends CI_Model
{
	private $table='inscripcion';
	private $id='id_inscripcion';
	private $solicitud_id='solicitud_id';
	private $created_user_id='created_user_id';
	private $created='created';
	//** Determina si el registro existe */
	private $deleted='deleted';
	private $modified='modified';


	private $public_columns=[];

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('mihelper');
		$this->public_columns=[
			$this->id,
			$this->solicitud_id,
			$this->created_user_id
		];
	}

	public function create($idSolicitud,$created_user_id){
		$this->load->model('Solicitud_model');
		if($this->Solicitud_model->verify_requeriments($idSolicitud)){
			$data=array(
				$this->solicitud_id=>$idSolicitud,
				$this->created_user_id=>$created_user_id
			);
			$this->db->insert($this->table,$data);
			$id_row_inserted=$this->db->insert_id();
			return ($this->db->affected_rows()==1);
		}else{
			return false;
		}
		
		
	}

	public function find_by_id($id){
		
		$conditions=array(
			$this->id=>$id,
			$this->deleted=>NULL
		);

		$result=$this->db
			->select(
				implode(',',$this->public_columns)
			)
			->from($this->table)
			->where($this->conditions)
			->get();
		if($result->num_rows()===1){
			return  $result->result_array()[0];
		}else{
			return NULL;
		}
	}

	public function count(){
		$this->db->select(implode(',',$this->public_columns))
		->from($this->table)
		->where($this->deleted,NULL);
		$result=$this->db->get();
		return $result->num_rows();
	}

	/**
	 * delete software
	 */
	public function delete($id){
		$data=array(
			$this->deleted=date('m/d/Y h:i:s a', time())
		);
		$this->db->where($this->id, $id);
        return $this->db->update('alumno', $data);
	}

	/**
	* get a page only no deleted marked
	*/
	public function get_page($start,$limit = 10){
		$this->db->select('c.id_curso,c.nombre as nombre_curso,c.numeracion,a.nombres as nombres,a.apellido_paterno,a.apellido_materno');
		$this->db->from($this->table.' ins');
		$this->db->join('solicitud s','ins.solicitud_id = s.idSolicitud','left');
		$this->db->join('curso c','c.id_curso = s.programa','left');
		$this->db->join('alumno a','s.alumno = a.id_alumno','left');
		$this->db->where(
			array(
				'ins.'.$this->deleted=>NULL
			)
		);
		$this->db->limit($limit,$start);
		
        return resultToArray($this->db->get());
	}


	/**
	 * SELECT ins.*,a.nombres,a.apellido_paterno,a.apellido_materno FROM  inscripcion ins left JOIN solicitud s ON ins.solicitud_id = s.idSolicitud left JOIN curso c on c.id_curso = s.programa left JOIN alumno a on s.alumno = a.id_alumno LIMIT ?,?
	 */
	public function get_page_and_filter($start,$limit,$text){
		$this->db->select('c.id_curso,c.nombre as nombre_curso,c.numeracion,a.nombres as nombres,a.apellido_paterno,a.apellido_materno');
		$this->db->from($this->table.' ins');
		$this->db->join('solicitud s','ins.solicitud_id = s.idSolicitud','left');
		$this->db->join('curso c','c.id_curso = s.programa','left');
		$this->db->join('alumno a','s.alumno = a.id_alumno','left');
		$this->db->where(
			array(
				'ins.'.$this->deleted=>NULL
			)
		);
		$this->db->limit($limit,$start);
        return resultToArray($this->db->get());
	}
	
}