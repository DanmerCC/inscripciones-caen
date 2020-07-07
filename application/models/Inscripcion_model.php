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
	private $estado_finanzas_id='estado_finanzas_id';
	private $estado_admision_id='estado_admision_id';
	private $created='created';
	//** Determina si el registro existe */
	private $deleted='deleted';
	private $modified='modified';
	private $state_interview_id='state_interview_id';

	private $where_filters=[];


	private $public_columns=[];

	public $global_stado_finanzas=[];

	public $array_estado_finanzas=[];

	public $filter_estado_admision_ids=[];

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
		$this->load->model('EstadoAdmisionInscripcion_model');//EstadoAdmisionInscripcion_model
		$this->array_estado_finanzas=$this->EstadoFinanzas_model->all();
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
			->where($conditions)
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
	public function get_page($start,$limit = 10,$deletes=true){
		$this->db->select(
			's.idSolicitud,'.
			'ins.id_inscripcion,'.
			'ins.deleted as f_anulado,'.
			'ins.'.$this->estado_finanzas_id.','.
			'ef.nombre as estado_finanzas,'.
			'c.id_curso,'.
			'c.nombre as nombre_curso,'.
			'c.numeracion,'.
			'a.nombres as nombres,'.
			'a.documento,'.
			'a.email,'.
			'a.celular,'.
			'a.telefono_casa,'.
			'tc.nombre as tipo_curso,'.
			'a.apellido_paterno,'.
			'a.apellido_materno,'.
			'u.acceso as nombre_user,'.
			'ins.created as created ,'.
			'ins.id_inscripcion,'.
			'ea.id as estado_admisions_id,'.
			'ea.nombre as nombre_estado_admision,'.
			'state_interview_id'
		);
		$this->db->from($this->table.' ins');
		$this->dtq_join_solicitud_usuario_curso_tipo_curso_alumno();
		
		if(!$deletes){
			$this->db->where(
				array(
					'ins.'.$this->deleted=>NULL
				)
			);
		}
		$this->dt_query_datatable_filter_array('ins');
		$this->query_part_for_filter_by_estado_admision('ins');
		
		$this->db->limit($limit,$start);
		
        return resultToArray($this->db->get());
	}

	public function get_count($deletes=true){
		$this->db->select('COUNT(ins.id_inscripcion) as count');
		$this->db->from($this->table.' ins');
		$this->dtq_join_solicitud_usuario_curso_tipo_curso_alumno();
		if(!$deletes){
			$this->db->where(
				array(
					'ins.'.$this->deleted=>NULL
				)
			);
		}
		$this->dt_query_datatable_filter_array('ins');
		$this->query_part_for_filter_by_estado_admision('ins');
		$result=$this->db->get()->result_array();
		if(count($result)==1){
			return $result[0]['count'];
		}
		return null;
	}


	/**
	 * SELECT ins.*,a.nombres,a.apellido_paterno,a.apellido_materno FROM  inscripcion ins left JOIN solicitud s ON ins.solicitud_id = s.idSolicitud left JOIN curso c on c.id_curso = s.programa left JOIN alumno a on s.alumno = a.id_alumno LIMIT ?,?
	 */
	public function get_page_and_filter($start,$limit,$text,$deletes=true){
		$this->db->select(
			's.idSolicitud,'.
			'ins.id_inscripcion,'.
			'ins.deleted as f_anulado,'.
			'ins.'.$this->estado_finanzas_id.','.
			'ef.nombre as estado_finanzas,'.
			'c.id_curso,'.
			'c.nombre as nombre_curso,'.
			'c.numeracion,'.
			'a.nombres as nombres,'.
			'a.documento,'.
			'a.email,'.
			'a.celular,'.
			'a.telefono_casa,'.
			'tc.nombre as tipo_curso,'.
			'a.apellido_paterno,'.
			'a.apellido_materno,'.
			'u.acceso as nombre_user,'.
			'ins.created as created,'.
			'ins.id_inscripcion,'.
			'ea.id as estado_admisions_id,'.
			'ea.nombre as nombre_estado_admision,'.
			'ins.state_interview_id');
		$this->db->from($this->table.' ins');
		$this->db->group_start();
			$this->db->like('CONCAT(c.numeracion," ",tc.nombre," ",c.nombre)',$text);
			$this->db->or_like('a.nombres',$text);
			$this->db->or_like('a.apellido_paterno',$text);
			$this->db->or_like('a.apellido_materno',$text);
		$this->db->group_end();
		$this->dtq_join_solicitud_usuario_curso_tipo_curso_alumno();
		if(!$deletes){
			$this->db->where(
				array(
					'ins.'.$this->deleted=>NULL
				)
			);
		}
		$this->dt_query_datatable_filter_array('ins');
		$this->query_part_for_filter_by_estado_admision('ins');
		$this->db->limit($limit,$start);
        return resultToArray($this->db->get());
	}

	public function get_count_and_filter($text,$deletes=true){
		$this->db->select('COUNT(ins.id_inscripcion) as count');
		$this->db->from($this->table.' ins');
		$this->db->group_start();
			$this->db->like('CONCAT(c.numeracion," ",tc.nombre," ",c.nombre)',$text);
			$this->db->or_like('a.nombres',$text);
			$this->db->or_like('a.apellido_paterno',$text);
			$this->db->or_like('a.apellido_materno',$text);
		$this->db->group_end();
		$this->dtq_join_solicitud_usuario_curso_tipo_curso_alumno();
		if(!$deletes){
			$this->db->where(
				array(
					'ins.'.$this->deleted=>NULL
				)
			);
		}
		$this->dt_query_datatable_filter_array('ins');
		$this->query_part_for_filter_by_estado_admision('ins');
		

		$result=$this->db->get()->result_array();
		if(count($result)==1){
			return $result[0]['count'];
		}
        return null;
	}


	/**
	 * Estas dos functiones traen datos para expportar en excel
	 */
	public function get_all_to_export_and_filter($text,$deletes=true){
		$this->db->select('s.idSolicitud,ins.id_inscripcion,ins.deleted as f_anulado,ef.nombre as estado_finanzas,c.id_curso,c.nombre as nombre_curso,c.numeracion,a.*,tc.nombre as tipo_curso,u.acceso as nombre_user,ins.created as created,ins.id_inscripcion');
		$this->db->from($this->table.' ins');
		$this->db->group_start();
			$this->db->like('CONCAT(c.numeracion," ",tc.nombre," ",c.nombre)',$text);
			$this->db->or_like('a.nombres',$text);
			$this->db->or_like('a.apellido_paterno',$text);
			$this->db->or_like('a.apellido_materno',$text);
		$this->db->group_end();
		$this->dtq_join_solicitud_usuario_curso_tipo_curso_alumno();
		if(!$deletes){
			$this->db->where(
				array(
					'ins.'.$this->deleted=>NULL
				)
			);
		}
		$this->dt_query_datatable_filter_array('ins');
		//$this->db->limit($limit,$start);
        return resultToArray($this->db->get());
	}

	public function get_all_to_export($deletes=true){
		$this->db->select('s.idSolicitud,ins.id_inscripcion,ins.deleted as f_anulado,ef.nombre as estado_finanzas,c.id_curso,c.nombre as nombre_curso,c.numeracion,a.*,tc.nombre as tipo_curso,u.acceso as nombre_user,ins.created as created ,ins.id_inscripcion');
		$this->db->from($this->table.' ins');
		$this->dtq_join_solicitud_usuario_curso_tipo_curso_alumno();
		
		if(!$deletes){
			$this->db->where(
				array(
					'ins.'.$this->deleted=>NULL
				)
			);
		}
		$this->dt_query_datatable_filter_array('ins');
		
		//$this->db->limit($limit,$start);
		
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

	private function getPublicColumns($alias=NULL){
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
			',c.id_curso,c.nombre as nombre_curso,c.numeracion,a.id_alumno,
			a.nombres as nombres,a.apellido_paterno,a.apellido_materno,
			u.acceso as nombre_user,tc.nombre as tipo_curso,eval.id as evaluado'
		);
		$this->db->from($this->table.' ins');
		$this->db->join('solicitud s','ins.solicitud_id = s.idSolicitud','left');
		$this->db->join('usuario u','ins.created_user_id = u.id','left');
		$this->db->join('curso c','c.id_curso = s.programa','left');
		$this->db->join('tipo_curso tc','c.idTipo_curso = tc.idTipo_curso','left');
		$this->db->join('alumno a','s.alumno = a.id_alumno','left');
		$this->db->join('adms_evaluaciones eval','eval.inscripcion_id=ins.id_inscripcion','left');
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
			',c.id_curso,c.nombre as nombre_curso,c.numeracion,a.nombres as nombres,
			a.apellido_paterno,a.apellido_materno,u.acceso as nombre_user,
			tc.nombre as tipo_curso,eval.id as evaluado'
		);
		$this->basic_query('ins');
		$this->db->join('solicitud s','ins.solicitud_id = s.idSolicitud','left');
		$this->db->join('usuario u','ins.created_user_id = u.id','left');
		$this->db->join('curso c','c.id_curso = s.programa','left');
		$this->db->join('tipo_curso tc','c.idTipo_curso = tc.idTipo_curso','left');
		$this->db->join('alumno a','s.alumno = a.id_alumno','left');
		$this->db->join('adms_evaluaciones eval','eval.inscripcion_id=ins.id_inscripcion','left');
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

	/**
	 * Funcion de part querys comunes en datatables
	 * joins y ordenamiento 
	 *
	 * @return void
	 */
	public function dtq_join_solicitud_usuario_curso_tipo_curso_alumno(){
		$this->db->join('solicitud s','ins.solicitud_id = s.idSolicitud','left');
		$this->db->join('usuario u','ins.created_user_id = u.id','left');
		$this->db->join('curso c','c.id_curso = s.programa','left');
		$this->db->join('tipo_curso tc','c.idTipo_curso = tc.idTipo_curso','left');
		$this->db->join('alumno a','s.alumno = a.id_alumno','left');
		$this->db->join('estado_finanzas ef','ins.estado_finanzas_id = ef.id');
		$this->db->join('estado_admisions ea','ins.estado_admision_id = ea.id');
		$this->db->order_by('ins.created','desc');
	}

/**
 * @var integer id
 * @var integer estado_id
 */
	public function setEstadoFinanzas($id,$estado_id){
		$data=array(
			$this->estado_finanzas_id=>$estado_id
		);
		$this->db->where($this->id, $id);
		$this->db->update($this->table,$data);
		return ($this->db->affected_rows()==1);
	}

	function dt_query_datatable_filter_array($prefix=null){

		$ids=c_extract($this->array_estado_finanzas,'id');
		if(count($this->global_stado_finanzas)>0){
			$this->db->group_start();
			for ($i=0; $i < count($this->global_stado_finanzas); $i++) {
				
				if(in_array($this->global_stado_finanzas[$i],$ids)){
					if($prefix==null){
						$this->db->or_where($this->estado_finanzas_id,$this->global_stado_finanzas[$i]);
					}else{
						$this->db->or_where($prefix.'.'.$this->estado_finanzas_id,$this->global_stado_finanzas[$i]);
					}
				}else{
					throw new Exception("Error no se detecto un estado validado");
				}
			}
			$this->db->group_end();
		}else{
			
		}
		
	}

	function query_part_for_filter_by_estado_admision($prefix=null){

		$ids=c_extract($this->EstadoAdmisionInscripcion_model->all(),'id');
		if(count($this->filter_estado_admision_ids)>0){
			$this->db->group_start();
			for ($i=0; $i < count($this->filter_estado_admision_ids); $i++) {
				
				if(in_array($this->filter_estado_admision_ids[$i],$ids)){
					if($prefix==null){
						$this->db->or_where($this->estado_admision_id,$this->filter_estado_admision_ids[$i]);
					}else{
						$this->db->or_where($prefix.'.'.$this->estado_admision_id,$this->filter_estado_admision_ids[$i]);
					}
				}else{
					throw new Exception("Error no se detecto un estado admision validado");
				}
			}
			$this->db->group_end();
		}else{
			
		}
		
	}

	function changeState($id,$estado_id){
		$data=array(
			$this->estado_admision_id=>$estado_id
		);
		$this->db->where($this->id, $id);
		$this->db->update($this->table,$data);
		return $this->db->affected_rows()==1;
	}

	function getOneOrFail($id){
		$this->db->select()
		->from($this->table)
		->where($this->id,$id);
		$result=$this->db->get();
		if($result->num_rows()==1){
			return $result->result_array()[0];
		}else{
			throw new Exception("Error al buscar la inscripcion con id".$id);
		}
	}

	/**
	 * Actualiza el estado de entrevista del la inscripcion function
	 *
	 * @param int $idInscripcion
	 * @param int $idEstado
	 * @return boolean
	 */
	function updateEstadoEntrevista($idInscripcion,$idEstado){
		$this->db->where($this->id,$idInscripcion);
		$data=array(
			$this->state_interview_id=>$idEstado
		);
		$this->db->update($this->table,$data);
		return $this->db->affected_rows()==1;
	}


	function evaluables($search='',$max_options=30){
		$this->load->model('InterviewProgramed_model');
		$valids=$this->InterviewProgramed_model->valids(['id']);
		$this->db->select(
			implode(',',
			$this->getPublicColumns($this->table)
			).',alumno.nombres,alumno.apellido_paterno,apellido_materno,alumno.nombres as value,'.
			'CONCAT(curso.numeracion," ",tipo_curso.nombre," ",curso.nombre) as full_name_programa'
		);
		$this->db->from($this->table);
		$this->db->join('solicitud','solicitud.idSolicitud='.$this->table.'.solicitud_id');
		$this->db->join('curso','solicitud.programa=curso.id_curso');
		$this->db->join('tipo_curso','tipo_curso.idTipo_curso=curso.idTipo_curso');
		$this->db->join('alumno','alumno.id_alumno=solicitud.alumno');
		if($valids!=null){
			$this->db->where_not_in($this->id,$valids);
		}
		if($search!='' && isset($search)){
			$this->db->like('alumno.nombres',$search);
			$this->db->or_like('alumno.apellido_paterno',$search);
			$this->db->or_like('alumno.apellido_materno',$search);
		}
		$this->db->where($this->table.'.'.$this->deleted.' IS NULL',null,false);
		$this->db->limit($max_options);
		$result=$this->db->get();
		return $result->result_array();
	}

	public function resumen(){

		 $this->db->select('COUNT(ins.id_inscripcion) as incripcion_count,c.id_curso,c.nombre as nombre_programa,sf.id,sf.nombre as nombre_estado');
		$this->db->from($this->table.' ins');
		$this->basic_query('ins');
		$this->db->join('solicitud s','ins.solicitud_id = s.idSolicitud','left');
		$this->db->join('usuario u','ins.created_user_id = u.id','left');
		$this->db->join('curso c','c.id_curso = s.programa','left');
		$this->db->join('tipo_curso tc','c.idTipo_curso = tc.idTipo_curso','left');
		$this->db->join('alumno a','s.alumno = a.id_alumno','left');
		$this->db->join('estado_finanzas sf','sf.id = ins.id_inscripcion','left');
		$this->db->group_by(['c.id_curso','ins.estado_finanzas_id']);
		$query = $this->db->order_by('c.id_curso',"DESC")->get();

		return $query->result();
	}
}
