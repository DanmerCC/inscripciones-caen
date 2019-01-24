<?php 



class Alumno_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('mihelper');
	}

	public function registrar($apellido_paterno,$apellido_materno,$nombres,$documento,$idTipoDocumento=1){
		$data=array(
			'id_alumno' => NULL,
			'apellido_paterno' => "$apellido_paterno",
			'apellido_materno' => "$apellido_materno",
			'nombres' => "$nombres",
			'documento' => "$documento",
			'idTipoDocumento'=>"$idTipoDocumento"
		);
		$this->db->insert('alumno',$data);
		$ultimoId = $this->db->insert_id();
		return $ultimoId;
	}


	public function all($idAlumno){
		return $this->db->select()->from('alumno')->where('id_alumno',$idAlumno)->get();
	}

	public function getAll(){
		
		return $this->db->select()->from('alumno')->where('estadoMatricula','inscrito')->get();
	}

	public function getAllInscritos(){
		
		return resultToArray($this->db->select()->from('alumno')->get());
	}


	public function updateInformacionPersonal($id,
		$grado_profesion,
		$apellido_paterno,
		$apellido_materno,
		$nombres,
		$tipoDocumento,
		$estado_civil,
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
		$parentesco
	){

		$data = array(
	    	'sufre_enfermedad'=>$sufre_enfermedad,
			'tipo_enfermedad'=>$tipo_enfermedad,
			'seguro_medico'=>$seguro_medico,
			'nombre_seguro'=>$nombre_seguro,
			'telefono_seguro'=>$telefono_seguro,
			'emergencia_familiar'=>$emergencia_familiar,
			'telefono_familiar'=>$telefono_familiar,
			'parentesco'=>$parentesco
        );
        $this->db->where('id_alumno', $id);
        return $this->db->update('alumno', $data);
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

	}

	public function solicitudes($id){

		$this->db->select('s.idSolicitud,s.programa,s.alumno,s.tipo_financiamiento,s.fecha_registro,c.numeracion,c.nombre as nombreCurso,tc.nombre as tipoCurso');
		$this->db->from('solicitud s');
		$this->db->join('curso c', 's.programa=c.id_curso','left');
		$this->db->join('tipo_curso tc', 'c.idTipo_curso = tc.idTipo_curso','left');
		$this->db->where('s.alumno',$id);

		return $this->db->get();

	//return $this->db->query("SELECT s.idSolicitud,s.programa,s.alumno,s.tipo_financiamiento,s.fecha_registro,c.numeracion as numeracion,c.nombre as nombreCurso,tc.nombre as tipoCurso from solicitud s left JOIN curso c on s.programa=c.id_curso left JOIN tipo_curso tc on c.idTipo_curso = tc.idTipo_curso where s.alumno=");

	}


}