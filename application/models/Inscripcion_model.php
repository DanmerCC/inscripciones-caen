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

	private $where_filters=[];


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
		$this->where_filters=array(
			$this->deleted=>NULL
		);
	}

	/**
	 * return array with conditions
	 * @var prefix String example 'p'.'nombre' from producto as p;
	 */
	public function filters($prefix="",$override=FALSE){
		$filtros=[];
		if($prefix==""){
			$filters_with_prefix=[];
			$original_filters=$this->where_filters;
			foreach ($original_filters as $key => $filter) {
				$filters_with_prefix[$prefix.'.'.$key]=$filter;
			}
			$filtros=$filters_with_prefix;
		}else{
			$filtros=$this->where_filters;
		}

		return $filtros;
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
			$this->deleted.' IS NULL'=>NULL
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
		->where($this->deleted." IS NULL");
		$result=$this->db->get();
		return $result->num_rows();
	}

	/**
	 * delete software
	 */
	public function delete($id){
		$data=array(
			$this->deleted=>date('Y/m/d H:i:s')
		);
		$this->db->where($this->id, $id);
        return $this->db->update($this->table, $data);
	}

	/**
	* get a page only no deleted marked
	*/
	public function get_page($start,$limit = 10){
		$this->db->select('s.idSolicitud,ins.id_inscripcion,c.id_curso,c.nombre as nombre_curso,c.numeracion,a.nombres as nombres,a.documento,a.email,a.celular,a.telefono_casa,tc.nombre as tipo_curso,a.apellido_paterno,a.apellido_materno,u.acceso as nombre_user,ins.created as created ,ins.id_inscripcion');
		$this->db->from($this->table.' ins');
		$this->db->join('solicitud s','ins.solicitud_id = s.idSolicitud','left');
		$this->db->join('usuario u','ins.created_user_id = u.id','left');
		$this->db->join('curso c','c.id_curso = s.programa','left');
		$this->db->join('tipo_curso tc','c.idTipo_curso = tc.idTipo_curso','left');
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
		$this->db->select('s.idSolicitud,ins.id_inscripcion,c.id_curso,c.nombre as nombre_curso,c.numeracion,a.nombres as nombres,a.documento,a.email,a.celular,a.telefono_casa,tc.nombre as tipo_curso,a.apellido_paterno,a.apellido_materno,u.acceso as nombre_user,ins.created as created,ins.id_inscripcion');
		$this->db->from($this->table.' ins');
		$this->db->like('CONCAT(c.numeracion," ",tc.nombre," ",c.nombre)',$text);
		$this->db->or_like('a.nombres',$text);
		$this->db->or_like('a.apellido_paterno',$text);
		$this->db->or_like('a.apellido_materno',$text);
		$this->db->join('solicitud s','ins.solicitud_id = s.idSolicitud','left');
		$this->db->join('curso c','c.id_curso = s.programa','left');
		$this->db->join('tipo_curso tc','c.idTipo_curso = tc.idTipo_curso','left');
		$this->db->join('usuario u','ins.created_user_id = u.id','left');
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
	 * get all inscriptions array value format
	 */

	public function get_all(){
		$this->db->select($this->list_public_columns());
		$this->db->from($this->table);
		return resultToArray($this->db->get());
	}

	public function get_by_id($id){
		$this->db->select($this->list_public_columns());
		$this->db->from($this->table);
		$this->db->where($this->id,$id);
		return resultToArray($this->db->get());
	}

	private function list_public_columns(){
		return implode(',',$this->public_columns);
	}

	private function getApicColumns($alias=NULL){
		if($alias===NULL){
			return $this->public_columns;
		}else{
			$arraynew=[];
			for ($i=0; $i < count($this->public_columns); $i++) { 
				$arraynew[$i]=$alias.'.'.$this->public_columns[$i];
			}
			return $arraynew;
		}
	}

	/**
	* get a page only no deleted marked for api
	*/
	public function get_page_api($start,$limit = 10){
		$this->db->select(
			implode(',',$this->getApicColumns('ins')).
			',c.id_curso,c.nombre as nombre_curso,c.numeracion,a.id_alumno,a.nombres as nombres,a.apellido_paterno,a.apellido_materno,u.acceso as nombre_user,tc.nombre as tipo_curso'
		);
		$this->db->from($this->table.' ins');
		$this->db->join('solicitud s','ins.solicitud_id = s.idSolicitud','left');
		$this->db->join('usuario u','ins.created_user_id = u.id','left');
		$this->db->join('curso c','c.id_curso = s.programa','left');
		$this->db->join('tipo_curso tc','c.idTipo_curso = tc.idTipo_curso','left');
		$this->db->join('alumno a','s.alumno = a.id_alumno','left');
		$this->db->where(
			array(
				'ins.'.$this->deleted=>NULL
			)
		);
		$this->db->limit($limit,$start);
		
        return resultToArray($this->db->get());
	}

	public function get_page_api_by_program($start,$limit = 10,$id){

		//Set new particular filter to inscripcion
		$this->where_filters['id_curso']=$id;
		$this->db->select(
			implode(',',$this->getApicColumns('ins')).
			',c.id_curso,c.nombre as nombre_curso,c.numeracion,a.id_alumno,a.nombres as nombres,a.apellido_paterno,a.apellido_materno,u.acceso as nombre_user,tc.nombre as tipo_curso'
		);
		$this->db->from($this->table.' ins');
		$this->db->join('solicitud s','ins.solicitud_id = s.idSolicitud','left');
		$this->db->join('usuario u','ins.created_user_id = u.id','left');
		$this->db->join('curso c','c.id_curso = s.programa','left');
		$this->db->join('tipo_curso tc','c.idTipo_curso = tc.idTipo_curso','left');
		$this->db->join('alumno a','s.alumno = a.id_alumno','left');
		$this->db->where(
			$this->filters('ins')
		);			
		$this->db->where('s.sent_to_inscripcion IS NOT NULL',NULL);
		$this->db->where('ins.deleted IS NULL',NULL);
		$this->db->limit($limit,$start);
        return resultToArray($this->db->get());
	}

	public function get_all_api_by_program($id){

		//add filter by program
		$this->where_filters['id_curso']=$id;

		$this->db->select(
			implode(',',$this->getApicColumns('ins')).
			',c.id_curso,c.nombre as nombre_curso,c.numeracion,a.nombres as nombres,a.apellido_paterno,a.apellido_materno,u.acceso as nombre_user,tc.nombre as tipo_curso'
		);
		$this->basic_query('ins');
		$this->db->join('solicitud s','ins.solicitud_id = s.idSolicitud','left');
		$this->db->join('usuario u','ins.created_user_id = u.id','left');
		$this->db->join('curso c','c.id_curso = s.programa','left');
		$this->db->join('tipo_curso tc','c.idTipo_curso = tc.idTipo_curso','left');
		$this->db->join('alumno a','s.alumno = a.id_alumno','left');
		$this->db->where(
			$this->filters('ins')
		);
		return resultToArray($this->db->get());
	}

	public function get_all_api(){
		$this->db->select(
			implode(',',$this->getApicColumns('ins')).
			',c.id_curso,c.nombre as nombre_curso,c.numeracion,a.nombres as nombres,a.apellido_paterno,a.apellido_materno,u.acceso as nombre_user,tc.nombre as tipo_curso'
		);
		$this->basic_query('ins');
		$this->db->join('solicitud s','ins.solicitud_id = s.idSolicitud','left');
		$this->db->join('usuario u','ins.created_user_id = u.id','left');
		$this->db->join('curso c','c.id_curso = s.programa','left');
		$this->db->join('tipo_curso tc','c.idTipo_curso = tc.idTipo_curso','left');
		$this->db->join('alumno a','s.alumno = a.id_alumno','left');
		return resultToArray($this->db->get());
	}

	private function basic_query($alias=NULL){
		$alias_or_void=(isset($alias)?$alias:'');
		$this->db->from($this->table.' '.$alias_or_void);
		$this->db->where(
			array(
				$alias_or_void.'.'.$this->deleted=>NULL
			)
		);
	}

	/**
	* get a page only no deleted marked for api
	*/
	public function get_one_api($id){
		$this->db->select(
			implode(',',$this->getApicColumns('ins')).
			',c.id_curso,c.nombre as nombre_curso,c.numeracion,a.id_alumno,a.nombres as nombres,a.apellido_paterno,a.apellido_materno,u.acceso as nombre_user,tc.nombre as tipo_curso'
		);
		$this->db->from($this->table.' ins');
		$this->db->join('solicitud s','ins.solicitud_id = s.idSolicitud','left');
		$this->db->join('usuario u','ins.created_user_id = u.id','left');
		$this->db->join('curso c','c.id_curso = s.programa','left');
		$this->db->join('tipo_curso tc','c.idTipo_curso = tc.idTipo_curso','left');
		$this->db->join('alumno a','s.alumno = a.id_alumno','left');
		$this->db->where(
			array(
				'ins.'.$this->deleted=>NULL
			)
		);
		$this->db->where('ins.'.$this->id.'=',(int)$id);
        return resultToArray($this->db->get());
	}


	public function getColumnsForCharts(){
		$result=[];
		
		return array_merge($result,$this->getExternalColumnsCharts());
	}
	public function getExternalColumnsCharts(){
		return [
			"nombre_programa",
			"tipo_programa"
		];
	}

	public function getExternalColumnDetails($external_name){
		$externals_details=[
			"nombre_programa"=>[
				"tabla"=>"curso",
				"real_column_name"=>"nombre"
				]
		];
		return $externals_details[$external_name];
	}

	public function getCountByColumn($column,$value){
		$result=$this->db->select("COUNT(".$this->id.") as ".$column)
			->from($this->table);
	}

	public function getGroupData($column_name){
		if(in_array($column_name,$this->getExternalColumnsCharts())){
			$this->db->select('c '.$this->getExternalColumnDetails($column_name)["real_column_name"]);
		}else{
			$this->db->select('ins.'.$column_name);
		}
		$this->db->from($this->table.' ins');
		if(in_array($column_name,$this->getExternalColumnsCharts())){

			$this->db->join('solicitud s','ins.solicitud_id = s.idSolicitud','left');
			$this->db->join('usuario u','ins.created_user_id = u.id','left');
			$this->db->join('curso c','c.id_curso = s.programa','left');
			$this->db->join('tipo_curso tc','c.idTipo_curso = tc.idTipo_curso','left');
			$this->db->join('alumno a','s.alumno = a.id_alumno','left');

		}

		$this->db->where(
			array(
				'ins.'.$this->deleted=>NULL
			)
		);
		$this->db->where('ins.'.$this->id.'=',(int)$id);
	}


	public function queryGetProgramCount(){
		$this->db->select('COUNT(ins.id_inscripcion) as conteo,c.id_curso,c.nombre as nombre_programa');
		$this->basic_query('ins');
		$this->db->join('solicitud s','ins.solicitud_id = s.idSolicitud','left');
		$this->db->join('usuario u','ins.created_user_id = u.id','left');
		$this->db->join('curso c','c.id_curso = s.programa','left');
		$this->db->join('tipo_curso tc','c.idTipo_curso = tc.idTipo_curso','left');
		$this->db->join('alumno a','s.alumno = a.id_alumno','left');
		$this->db->group_by('c.id_curso');
		return resultToArray($this->db->get());
	}

}
