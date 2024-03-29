<?php 



class Alumno_model extends CI_Model
{
	private $table='alumno';


	private $id='id_alumno';
	private $check_cv='check_cv_pdf';
	private $check_dj='check_dj_pdf';
	private $check_dni='check_dni_pdf';
	private $check_bach='check_bach_pdf';
	private $check_maes='check_maes_pdf';
	private $check_doct='check_doct_pdf';
	private $check_sins='check_sins_pdf';
	
	//*Salud Data
	private $desc_discapacidad='espec_discapacidad';

	private $celphone='celular';
	//*Searcheable columns*//
	private $apellido_paterno='apellido_paterno';
	private $apellido_materno='apellido_materno';
	private $nombres='nombres';
	private $documento='documento';
	private $email='email';
	private $grado_profesion='grado_profesion';
	private $estado_civil='estado_civil';
	private $genero='genero';
	private $fecha_nac='fecha_nac';
	private $telefono_casa='telefono_casa';
	private $distrito_nac='distrito_nac';
	private $provincia='provincia';
	private $departamento='departamento';
	private $direccion='direccion';
	private $distrito='distrito';
	private $lugar_trabajo='lugar_trabajo';
	private $area_direccion='area_direccion';
	private $tiempo_servicio='tiempo_servicio';
	private $cargo_actual='cargo_actual';
	private $direccion_laboral='direccion_laboral';
	private $distrito_laboral='distrito_laboral';
	private $cambiar='cambiar';
	private $seguro_medico='seguro_medico';
	private $nombre_seguro='nombre_seguro';
	private $situacion_militar='situacion_militar';
	private $grado_militar='gradoMilitar';
	private $plana_militar='planaMilitar';
	private $nacionalidad='nacionalidad';
	private $situacion_laboral='situacion_laboral';
	

	private $public_columns=[];
	private $startIdPersona=NULL;


	function __construct()
	{
		parent::__construct();
		$this->load->helper('mihelper');
		$this->public_columns=[
			$this->id,
			$this->nombres,
			$this->apellido_paterno,
			$this->apellido_materno,
			$this->documento,
			$this->email,
			$this->celphone,
			$this->grado_profesion,
			$this->estado_civil,
			$this->genero,
			$this->fecha_nac,
			$this->telefono_casa,
			$this->desc_discapacidad,
			$this->distrito_nac,
			$this->provincia,
			$this->departamento,
			$this->direccion,
			$this->distrito,
			$this->lugar_trabajo,
			$this->area_direccion,
			$this->tiempo_servicio,
			$this->cargo_actual,
			$this->direccion_laboral,
			$this->distrito_laboral,
			$this->seguro_medico,
			$this->nombre_seguro,
			$this->situacion_militar,
			$this->grado_militar,
			$this->plana_militar,
			$this->nacionalidad,
			$this->situacion_laboral,
			$this->check_bach,
			$this->check_cv,
			$this->check_dj,
			$this->check_dni,
			$this->check_doct,
			$this->check_maes,
		];

	}

	public function registrar($apellido_paterno,$apellido_materno,$nombres,$documento,$email,$celphone,$idTipoDocumento=1){
		$data=array(
			'id_alumno' => NULL,
			'apellido_paterno' => "$apellido_paterno",
			'apellido_materno' => "$apellido_materno",
			'nombres' => "$nombres",
			'documento' => "$documento",
			'idTipoDocumento'=>"$idTipoDocumento",
			'email'=>$email,
			$this->celphone=>$celphone
		);
		$this->db->insert('alumno',$data);
		$ultimoId = $this->db->insert_id();
		return $ultimoId;
	}


	public function all($idAlumno){
		return $this->db->select()->from('alumno')->where('id_alumno',$idAlumno)->get();
	}

	public function findById($idAlumno){
		return resultToArray($this->db->select()->from('alumno')->where('id_alumno',$idAlumno)->get());
	}

	public function findByDocumento($numero){
		return $this->db->select('id_alumno,apellido_paterno,apellido_materno,nombres,documento,cargo_actual')->from('alumno')->where('documento',$numero)->get();
	}

	public function findAllInnerSolicitudCountById($idAlumno){
		$this->db->select('COUNT(s.idSolicitud) as solicitudes,a.*');
		$this->db->from($this->table." a");
		$this->db->join('solicitud s', 'a.'.$this->id.'=s.alumno','left');
		$this->db->where($this->id,$idAlumno);
		$this->db->group_by('a.'.$this->id);
		$this->db->order_by('solicitudes', 'DESC');
		return resultToArray($this->db->get());
	}

	public function getAll(){
		
		return $this->db->select()->from('alumno')->where('estadoMatricula','inscrito')->get();
	}

	public function getAllInscritos(){
		$this->db->select();
		$this->db->from('alumno');
		$this->db->order_by("id_alumno", "asc");
		return resultToArray($this->db->get());
	}


	public function updateInformacionPersonal($id,
		$grado_profesion,
		$apellido_paterno,
		$apellido_materno,
		$nombres,
		$tipoDocumento,
		$estado_civil,
		$genero,
		$fecha_nac,
		$telefono_casa,
		$celular,
		$email,
		$distrito_nac,
		$provincia,
		$departamento,
		$direccion,
		$interior,
		$distrito,
		$nacionalidad,
		$grado_militar,
		$plana_militar,
		$cip_militar,
		$situacion_militar,
		$si_militar
	){

		$data = array(
	        'grado_profesion'=>$grado_profesion,
			'apellido_paterno'=>$apellido_paterno,
			'apellido_materno'=>$apellido_materno,
			'nombres'=>$nombres,
			'idTipoDocumento'=>$tipoDocumento,
			'estado_civil'=>$estado_civil,
			'genero'=>$genero,
			'fecha_nac'=>$fecha_nac,
			'telefono_casa'=>$telefono_casa,
			'celular'=>$celular,
			'email'=>$email,
			'distrito_nac'=>$distrito_nac,
			'provincia'=>$provincia,
			'departamento'=>$departamento,
			'direccion'=>$direccion,
			'interior'=>$interior,
			'distrito'=>$distrito,
			'nacionalidad'=>$nacionalidad,
			'gradoMilitar'=>$grado_militar,
			'planaMilitar'=>$plana_militar,
			'cip_militar'=>$cip_militar,
			'situacion_militar'=>$situacion_militar,
			'si_militar'=>$si_militar
        );
        $this->db->where('id_alumno', $id);
        return $this->db->update('alumno', $data);
	}

	public function updateInformacionLaboral($id,
		$lugar_trabajo,
		$area_direccion,
		$tiempo_servicio,
		$cargo_actual,
		$direccion_laboral,
		$distrito_laboral,
		$telefono_laboral,
		$anexo_laboral,
		$experiencia_laboral1,
		$fecha_inicio1,
		$fecha_fin1,
		$experiencia_laboral2,
		$fecha_inicio2,
		$fecha_fin2,
		$curso_caen,
		$indicar1,
		$curso_maestria,
		$indicar2,
		$situacion_laboral
	){

		$data = array(
	        'lugar_trabajo'=>$lugar_trabajo,
			'area_direccion'=>$area_direccion,
			'tiempo_servicio'=>$tiempo_servicio,
			'cargo_actual'=>$cargo_actual,
			'direccion_laboral'=>$direccion_laboral,
			'distrito_laboral'=>$distrito_laboral,
			'telefono_laboral'=>$telefono_laboral,
			'anexo_laboral'=>$anexo_laboral,
			'experiencia_laboral1'=>$experiencia_laboral1,
			'fecha_inicio1'=>$fecha_inicio1,
			'fecha_fin1'=>$fecha_fin1,
			'experiencia_laboral2'=>$experiencia_laboral2,
			'fecha_inicio2'=>$fecha_inicio2,
			'fecha_fin2'=>$fecha_fin2,
			'curso_caen'=>$curso_caen,
			'indicar1'=>$indicar1,
			'curso_maestria'=>$curso_maestria,
			'indicar2'=>$indicar2,
			'situacion_laboral'=>$situacion_laboral
        );
        $this->db->where('id_alumno', $id);
        return $this->db->update('alumno', $data);
	}


	public function updateInformacionAcademicos($id,
		$titulo_obtenido,
		$universidad_titulo,
		$fecha_titulo,
		$grado_obtenido,
		$universidad_grado,
		$fecha_grado,
		$maestria_obtenida,
		$universidad_maestria,
		$fecha_maestria,
		$doctorado_obtenido,
		$universidad_doctor,
		$fecha_doctor
	){

		$data = array(
	    'titulo_obtenido'=>$titulo_obtenido,
		'universidad_titulo'=>$universidad_titulo,
		'fecha_titulo'=>$fecha_titulo,
		'grado_obtenido'=>$grado_obtenido,
		'universidad_grado'=>$universidad_grado,
		'fecha_grado'=>$fecha_grado,
		'maestria_obtenida'=>$maestria_obtenida,
		'universidad_maestria'=>$universidad_maestria,
		'fecha_maestria'=>$fecha_maestria,
		'doctorado_obtenido'=>$doctorado_obtenido,
		'universidad_doctor'=>$universidad_doctor,
		'fecha_doctor'=>$fecha_doctor
        );
        $this->db->where('id_alumno', $id);
        return $this->db->update('alumno', $data);
	}



	public function updateInformacionSalud($id,
		$sufre_enfermedad,
		$tipo_enfermedad,
		$seguro_medico,
		$nombre_seguro,
		$telefono_seguro,
		$emergencia_familiar,
		$telefono_familiar,
		$parentesco,
		$discapacidad
	){

		$data = array(
	    	'sufre_enfermedad'=>$sufre_enfermedad,
			'tipo_enfermedad'=>$tipo_enfermedad,
			'seguro_medico'=>$seguro_medico,
			'nombre_seguro'=>$nombre_seguro,
			'telefono_seguro'=>$telefono_seguro,
			'emergencia_familiar'=>$emergencia_familiar,
			'telefono_familiar'=>$telefono_familiar,
			'parentesco'=>$parentesco,
			$this->desc_discapacidad=>$discapacidad
        );
        $this->db->where('id_alumno', $id);
        return $this->db->update('alumno', $data);
	}

	public function updateOtros($def_patria=null,$def_democracia){
		$data = array(
			'def_patria'=>$def_patria,
			'def_democracia'=>$def_democracia
		);
		return $this->db->update($this->table,$data);

	}

	public function updateInformacionReferencias($id,$referencia_personal1,$referencia_personal2){
		$data = array(
            'referencia_personal1' => $referencia_personal1,
            'referencia_personal2' => $referencia_personal2
        );
        $this->db->where('id_alumno', $id);
        return $this->db->update('alumno', $data);
	}

	public function nuevaSolicitud($programa,$alumno,$tipo_financiamiento){
		$data=array(
			'programa' => "$programa",
			'alumno' => "$alumno",
			'tipo_financiamiento' => "$tipo_financiamiento"
		);
		$this->db->insert('solicitud',$data);
		return $this->db->affected_rows()==1;
	}

	public function solicitudes($id){

		$this->db->select('a.documento as documento,s.idSolicitud,s.programa,s.alumno,s.tipo_financiamiento,s.fecha_registro,c.numeracion,c.nombre as nombreCurso,tc.nombre as tipoCurso,tc.idTipo_curso as idTipoCurso');
		$this->db->from('solicitud s');
		$this->db->join('curso c', 's.programa=c.id_curso','left');
		$this->db->join('tipo_curso tc', 'c.idTipo_curso = tc.idTipo_curso','left');
		$this->db->join('alumno a', 'a.id_alumno = s.alumno','left');
		$this->db->where('s.alumno',$id);

		return $this->db->get();

	//return $this->db->query("SELECT s.idSolicitud,s.programa,s.alumno,s.tipo_financiamiento,s.fecha_registro,c.numeracion as numeracion,c.nombre as nombreCurso,tc.nombre as tipoCurso from solicitud s left JOIN curso c on s.programa=c.id_curso left JOIN tipo_curso tc on c.idTipo_curso = tc.idTipo_curso where s.alumno=");

	}

	public function set_check_cvFile($id_alumno){
		$data=array(
			$this->check_cv=>1
		);
		$this->db->where($this->id, $id_alumno);
		return $this->db->update($this->table,$data);
	}

	public function set_check_dniFile($id_alumno){
		$data=array(
			$this->check_dni=>1
		);
		$this->db->where($this->id, $id_alumno);
		return $this->db->update($this->table,$data);
	}
	public function set_check_djFile($id_alumno){
		$data=array(
			$this->check_dj=>1
		);
		$this->db->where($this->id, $id_alumno);
		return $this->db->update($this->table,$data);
	}

	public function set_check_bachFile($id_alumno){
		return $this->set_check_file_true($this->check_bach,$id_alumno);
	}

	public function set_check_maesFile($id_alumno){
		return $this->set_check_file_true($this->check_maes,$id_alumno);
	}

	public function set_check_doctFile($id_alumno){
		return $this->set_check_file_true($this->check_doct,$id_alumno);
	}

	public function set_check_sinstFile($id_alumno){
		return $this->set_check_file_true($this->check_sins,$id_alumno);
	}

	private function set_check_file_true($column,$id_alumno){
		$data=array(
			$column=>1
		);
		$this->db->where($this->id, $id_alumno);

		return $this->db->update($this->table,$data);
	}

	public function count(){
        /*$this->db->select("COUNT(*) as cant");
        $this->db->from($this->table);
        $result=$this->db->get();
        foreach ($variable as $key => $value) {
            # code...
        }*/
        return $this->db->get($this->table)->num_rows();;
    }
    public function getAllInscritosPage($start,$limit){
        $this->db->select();
        $this->db->from('alumno');
        $this->db->order_by("id_alumno", "desc");
        $this->db->limit($limit,$start);
        return resultToArray($this->db->get());
	}
	
	public function getAllInscritosAndFindTextPage($start,$limit,$text){
		$this->db->select();
        $this->db->from($this->table);
		$this->db->like($this->apellido_paterno,$text);
		$this->db->or_like($this->apellido_materno,$text);
		$this->db->or_like($this->nombres,$text);
		$this->db->or_like($this->documento,$text);
		$this->db->or_like($this->email,$text);
		$this->db->order_by("id_alumno", "desc");
        $this->db->limit($limit,$start);
        return resultToArray($this->db->get());
	}

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

	public function list_public_columns(){
		return implode(',',$this->public_columns);
	}


	/**
	 * @return columns retorna un array con los campos para el filtrado de estadisticas
	 * 
	 */
	public function getColumnsForAnalisis(){
		return [
			$this->id,
			$this->estado_civil,
			$this->distrito_laboral,
			$this->distrito,
			$this->distrito_nac,
			$this->provincia,
			$this->departamento,
			$this->seguro_medico,
			$this->nombre_seguro,
			$this->situacion_militar,
			$this->grado_profesion,
			$this->lugar_trabajo,
			$this->grado_militar,
			$this->plana_militar,
			$this->nacionalidad,
			$this->situacion_laboral
		];
	}

	/**
	 * @var column name of column
	 */
	public function getCountForAnalisis($column,$where_data=NULL){
		$this->db->select('COUNT('.$this->id.') as conteo,'.$column)->from($this->table);
		if(isset($where_data)){
			$this->db->where($column,$where_data);
		}
		
		return resultToArray($this->db->get());
	}
	public function getDataGroupColumn($column_name){
		$this->db->select($column_name)->from($this->table)->group_by($column_name);
		return resultToArray($this->db->get());
	}

	/**
	 * @method  get_page_api devuelve un array con las personas 
	 * @var int $start es el inicio de la paginacion
	 * @var int $limit es la cantidad de registros retornados
	 */
	public function get_page_api($start,$limit = 10){
		$this->query_selectApiColumnsFromTable();
		$this->db->limit($limit,$start);
		return resultToArray($this->db->get());
	}

	public function get_all_api(){
		$this->query_selectApiColumnsFromTable();
		if($this->startIdPersona!==NULL){
			$this->db->where($this->id.' >',$this->startIdPersona);
		}
		return resultToArray($this->db->get());
	}

	public function get_one_api($id){
		$this->query_selectApiColumnsFromTable();
		$this->db->where($this->id,$id);
		return resultToArray($this->db->get());
	}

	public function  query_selectApiColumnsFromTable(){
		$this->db->select(
			implode(',',$this->getApicColumns())
		);
		$this->db->from($this->table);
	}

	public function getApicColumns($alias=NULL){
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

	//return array object to alumno
	public function find($id){
		$this->db->select('a.*,u.acceso as usuario_id,u.tipo')
		->from($this->table.' a')
		->join('tipodocumento t','a.idTipoDocumento = t.idTipoDocumento')
		->join('usuario u','a.id_alumno = u.alumno','left')
		->where($this->id,$id);
		$result=$this->db->get();
		if($result->num_rows()==1){
			return $result->result_array()[0];
		}else{
			return null;
		}
	}

	/**
	 * Id de 
	 * @param id Integer
	 */
	public function setStartId($id){
		$this->startIdPersona=$id;
	}

}
