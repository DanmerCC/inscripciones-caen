<?php 



class Programa_model extends CI_Model
{
	private $table='curso';
	private $id='id_curso';
	private $name='nombre';
	private $duracion='duracion';
	private $costo_total='costo_total';
	private $vacantes='vacantes';
	private $fecha_inicio='fecha_inicio';
	private $fecha_final='fecha_final';
	private $tipo='idTipo_curso';
	private $estado='estado';
	private $numeracion='numeracion';

	private $state_filter="";

	private $public_columns=[];

	function __construct()
	{
		parent::__construct();
		$this->load->helper('mihelper');

	}

	public function all(){
		return $this->db->query('SELECT c.id_curso,c.nombre,c.duracion,c.costo_total,c.vacantes,c.fecha_inicio,c.fecha_final,c.idTipo_curso,c.estado,c.numeracion,t.nombre as tipoNombre FROM curso c left join tipo_curso t on c.idTipo_curso = t.idTipo_curso');
	}

  public function allActives(){
		return $this->db->query('SELECT c.id_curso,c.nombre,c.duracion,c.costo_total,c.vacantes,c.fecha_inicio,c.fecha_final,c.idTipo_curso,c.estado,c.numeracion,t.nombre as tipoNombre FROM curso c left join tipo_curso t on c.idTipo_curso = t.idTipo_curso where c.estado=1');
	}

	public function allActivesByType($idType){
		$this->db->select('c.id_curso,c.nombre,c.duracion,c.costo_total,c.vacantes,c.fecha_inicio,c.fecha_final,c.idTipo_curso,c.estado,c.numeracion,t.nombre as tipoNombre');
		$this->db->from('curso c');
		$this->db->join('tipo_curso t', 'c.idTipo_curso = t.idTipo_curso');
		$this->db->where('c.estado',1);
		$conditions = array('c.estado' => 1, 'c.idTipo_curso' => $idType);
		$this->db->where($conditions);
		return $this->db->get();
	}

	public function getAllTipos(){
		return $this->db->select()->from('tipo_curso')->get();
	}

	public function getById($id){
		$sql = "SELECT * FROM `curso` WHERE id_curso=?";
		$result=$this->db->query($sql,$id);
		return $result;
	}
	public function update($nombre,$id_curso,$duracion,$costo_total,$vacantes,$fecha_inicio,$fecha_final,$idTipo_curso,$numeracion){

		$data = array(
			'nombre'=>$nombre,
			'id_curso'=>$id_curso,
			'duracion'=>$duracion,
			'costo_total'=>$costo_total,
			'vacantes'=>$vacantes,
			'fecha_inicio'=>$fecha_inicio,
			'fecha_final'=>$fecha_final,
			'idTipo_curso'=>$idTipo_curso,
			'numeracion'=>$numeracion
		);

		$this->db->where('id_curso', $id_curso);
		$this->db->update('curso', $data);
		return $this->db->affected_rows();
	}

	public function activar($id){
		$this->db->set('estado', '1');
		$this->db->where('id_curso', $id);
		$this->db->update('curso');
		return $this->db->affected_rows();
	}

	public function desactivar($id){
		$this->db->set('estado', '0');
		$this->db->where('id_curso', $id);
		$this->db->update('curso');
		return $this->db->affected_rows();
	}


	public function insertar($nombre,$duracion,$costo_total,$vacantes,$fecha_inicio,$fecha_final,$idTipo_curso,$numeracion){

		$data = array(
			'nombre'=>$nombre,
			'duracion'=>$duracion,
			'costo_total'=>$costo_total,
			'vacantes'=>$vacantes,
			'fecha_inicio'=>$fecha_inicio,
			'fecha_final'=>$fecha_final,
			'idTipo_curso'=>$idTipo_curso,
			'numeracion'=>$numeracion
		);

		$result=$this->db->insert('curso',$data);
		return $result;
	}

	public function actives(){
		$this->db->select('nombre,id_curso');
		$this->db->from('curso');
		$this->db->where('estado',1);
		return resultToArray($this->db->get());
	}
/**
 * prefix or alias example c in c.column
 */
	private function getPublicColumns($prefix=""){
		$real_prefix=(!empty($prefix))?$prefix.'.':'';

		return [
			$real_prefix.$this->id,
			$real_prefix.$this->name,
			$real_prefix.$this->numeracion,
			$real_prefix.$this->duracion,
			$real_prefix.$this->costo_total,
			$real_prefix.$this->vacantes,
			$real_prefix.$this->fecha_inicio,
			$real_prefix.$this->fecha_final,
			$real_prefix.$this->estado
		];
	}


	public function page($start,$limit){
		$this->db->select(implode(',',$this->getPublicColumns('p')).', tc.nombre as tipoNombre')
				->join('tipo_curso tc','p.'.$this->tipo.'=tc.idTipo_curso')
				->order_by($this->id, "desc")
				->from($this->table.' p');
			if($this->state_filter!=''){
				$this->db->where($this->estado,$this->state_filter=="visible");
			}
			$this->db->limit($limit,$start);
		return resultToArray($this->db->get());
	}

	public function page_with_filter($start,$limit,$filter_text){
			$this->db->select(implode(',',$this->getPublicColumns('p')).', tc.nombre as tipoNombre')
					->from($this->table.' p');
		if($this->state_filter!=''){
			$this->db->where($this->estado,$this->state_filter=="visible");
		}
			$this->db->join('tipo_curso tc','p.'.$this->tipo.'=tc.idTipo_curso','left')
					->like('p.'.$this->name,$filter_text);
		if(is_numeric($filter_text)){
			$this->db->or_like('p.'.$this->numeracion,$filter_text);
		}
			$this->db
					->or_like('p.'.$this->numeracion,$filter_text)
					->or_like('p.'.$this->vacantes,$filter_text);
		if(is_numeric($filter_text)){
			$this->db->or_like('p.'.$this->costo_total,$filter_text);
		}
			$this->db
					->order_by($this->id, "desc")
					->limit($limit,$start);
			return resultToArray($this->db->get());
	}

	public function count(){
		$this->db->select($this->id)
				->from($this->table);
		$result=$this->db->get();
		return $result->num_rows();
	}

	/**
	 * @method 
	 * cuenta tomando en cuenta el filtro de estado en modelo
	 */
	public function countWithStateFilter(){
			$this->db->select($this->id)
					->from($this->table);
		if($this->state_filter!=''){
			$this->db->where($this->estado,$this->state_filter=="visible");
		}
		return	$this->db->get()->num_rows();
	}

	/**
	 * set a 	"visible" or
	 * 			"no visible" or
	 * 			"" default value
	 */
	public function onlyVisibleFilter($value){
		$this->state_filter=$value;
	}

}
