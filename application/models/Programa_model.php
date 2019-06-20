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
	private $type_filter="";

	private $public_columns=[];

	function __construct()
	{
		parent::__construct();
		$this->load->helper('mihelper');
		$this->load->library('Nativesession');
		$this->load->model('Permiso_model');

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

	public function get_one($id){
		return $this->getById($id)->row();
	}

	public function get_one_with_type($id){
		$this->db->select('c.*, t.nombre as tipo_curso')->from($this->table.' c');
		$this->db->join('tipo_curso t', 'c.idTipo_curso = t.idTipo_curso');
		$this->db->where('c.'.$this->id,$id);
		$result=$this->db->get();
		return $result->row();
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


	public function page($start,$limit,$number_order,$order){
		$columns_select=array();
		$columns_select=$this->getPublicColumns('p');

		array_push($columns_select,'tc.nombre as tipoNombre');
		
		$this->db->select(implode(',',$columns_select))
				->join('tipo_curso tc','p.'.$this->tipo.'=tc.idTipo_curso');
				
		$this->query_orderBy($number_order,$order,$this->getOrdersColumnsByDatatables());
				$this->db->from($this->table.' p');
		$this->query_filters('p');
		$this->db->limit($limit,$start);
		return resultToArray($this->db->get());
	}

	public function page_with_filter($start,$limit,$filter_text,$number_order,$order){
		$columns_select=array();
		$columns_select=$this->getPublicColumns('p');
		array_push($columns_select,'tc.nombre as tipoNombre');
			$this->db->select(implode(',',$columns_select))
					->from($this->table.' p');
		$this->query_filters('p');
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
			$this->query_orderBy($number_order,$order,$this->getOrdersColumnsByDatatables());
			$this->db->limit($limit,$start);
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
		$this->query_filters();
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


	private function query_orderBy($number,$order,$columnas=NULL){
		
		$this->db->order_by(isset($columnas)?$columnas[$number]:$this->id,$order);
	}

	public function getOrdersColumnsByDatatables(){
		return $order_columns=[
			'p.'.$this->id,
			'p.'.$this->name,
			'p.'.$this->duracion,
			'p.'.$this->costo_total,
			'p.'.$this->vacantes,
			'p.'.$this->fecha_inicio,
			'p.'.$this->fecha_final,
			'tc.nombre',
			$this->estado
		];
	}

	public function setTypeFilter($type_filter){
		$this->type_filter=$type_filter;
	}

	public function query_filters($alias_table=NULL){
		$real_alias=isset($alias_table)?$alias_table.'.':'';
		if($this->state_filter!=''){
			$this->db->where($real_alias.$this->estado,$this->state_filter=="visible");
		}
		if($this->type_filter!=''){
			$this->db->where($real_alias.$this->tipo,$this->type_filter);
		}
	}

	public function postergar($curso_id,$fecha_nueva,$nuevo_termino,$comentario=""){
		$this->verifyLogin();
		$idUser=$this->nativesession->get('idUsuario');
		$this->load->model('Postergacion_model');
		$this->db->select()->from($this->table)->where($this->id,$curso_id);
		$result=$this->db->get();
		if($result->num_rows()!==1){
			throw new Exception('No se encontro programa');
		}
		$programa=$result->row_array();
		$this->db->trans_start();
		$resultado=$this->Postergacion_model->create(
			$programa[$this->id],
			$programa[$this->fecha_inicio],
			$fecha_nueva,
			$idUser,
			$nuevo_termino,
			$comentario
		);
		$data = array(
			$this->fecha_inicio=>$fecha_nueva,
			$this->fecha_final=>$nuevo_termino
		);

		$this->db->where($this->id, $curso_id);
		$this->db->update($this->table, $data);
		$afected_rows_query=$this->db->affected_rows();
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
			throw new Exception("Error en consulta al postergar");
		}
		return $afected_rows_query;
	}

	private function verifyLogin(){
		if($this->nativesession->get('idUsuario')==NULL){
			show_error("Session no permitida",500);
		}else{
			return true;
		}
	}

	public function findById($id){
		$this->db->select()->from($this->table)->where($this->id,$id);
		$result=$this->db->get();
		if($result->num_rows()!==1){
			return false;
		}else{
			return $result->result_array()[0];
		}
	}

	public function types(){
		$this->db->select()->from('tipo_curso');
		return $this->db->get()->result_array();
	}
	
}
