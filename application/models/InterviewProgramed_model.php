<?php 
/**
 * 
 */
class InterviewProgramed_model extends MY_Model
{
	private $table='intvw_programmed_interviews';
	private $id='id';

	private $alumno_id='alumno_id';
	private $inscripcion_id='inscripcion_id';
	private $estado_id='estado_id';
	private $fecha_programado='fecha_programado';
	private $created='created';
	private $updated='updated';

	
	function __construct()
	{
		parent::__construct();
		$this->load->model('StateInterviewProgramed_model');
		$this->load->model('Inscripcion_model');
		$this->load->model('Solicitud_model');
		
	}

	function create($inscripcion_id,$fecha_programado){
		$resultado=false;
		$this->db->trans_begin();
		try{
			$inscripcion=$this->Inscripcion_model->getOneOrFail($inscripcion_id);
			$solicitud=$this->Solicitud_model->getOrFail($inscripcion["solicitud_id"]);

			$data=array(
				$this->alumno_id=>$solicitud["alumno"],
				$this->inscripcion_id=>$inscripcion_id,
				$this->estado_id=>$this->StateInterviewProgramed_model->PENDIENTE,
				$this->fecha_programado=>$fecha_programado
			);
			$resultado=$this->db->insert($this->table,$data);
			$this->Inscripcion_model->updateEstadoEntrevista($inscripcion_id,$this->StateInterviewProgramed_model->PENDIENTE);
		}catch(Exception $e){
			$this->db->trans_rollback();
		}
		$this->db->trans_commit();
		return $resultado;
	}

	function byIdInscripcion($idInscripcion){
		$this->db->select();
		$this->db->from($this->table);
		$this->db->where($this->inscripcion_id,$idInscripcion);
		$result=$this->db->get();
		return $result->result_array();
	}

	function lastedById($idInscripcion){
		$this->db->select();
		$this->db->from($this->table);
		$this->db->where($this->inscripcion_id,$idInscripcion);
		$this->db->limit(1);
		$this->db->order_by($this->id,'desc');
		$result=$this->db->get();
		if($result->num_rows()==1){
			return $result->result_array()[0];
		}else{
			return null;
		}
	}

	function getAll(){
		$this->db->select($this->table.'.*,alumno.nombres,alumno.apellido_paterno');
		$this->db->from($this->table);
		$this->db->join('alumno','alumno.id_alumno='.$this->table.'.alumno_id');
		$result=$this->db->get();
		return $result->result_array();
	}

	function getArrayInscripcionIds(){
		$this->db->select($this->inscripcion_id);
		$this->db->from($this->table);
		$result=$this->db->get();
		$interviews=$result->result_array();
		$ids_array=[];
		for ($i=0; $i <count($interviews); $i++) { 
			array_push($ids_array,$interviews[$i][$this->inscripcion_id]);
		}
		return $ids_array;
	}

	function changeDate($id,$newDate){
		$newDate=date('Y-m-d h:i:s A',strtotime($newDate));
		$data=array(
			$this->fecha_programado=>$newDate
		);
		
		$this->db->where($this->id,$id);
		$this->db->update($this->table,$data);
		return $this->db->affected_rows()==1;
	}

	function get($id){
		$result=$this->db->select()->from($this->table)->where($this->id,$id)->get();
		if($result->num_rows()==1){
			return $result->result_array()[0];
		}elseif($result->num_rows()==0){
			return null;
		}else{
			throw new Exception("Error al buscar una entrevista");
		}
	}

	function getByInscripcion($id){
		$result=$this->db
		->select($this->table.'.*,alumno.nombres,alumno.apellido_paterno,alumno.apellido_materno')
		->from($this->table)
		->join('alumno','alumno.id_alumno='.$this->table.'.'.$this->alumno_id)
		->where($this->inscripcion_id,$id)->get();
		if($result->num_rows()==1){
			return $result->result_array()[0];
		}elseif($result->num_rows()==0){
			return null;
		}else{
			throw new Exception("Error al buscar una entrevista por inscripcion");
		}
	}

	function getBuildables($filter_programa_id=null){
		
		$all_programed_ids=$this->getArrayInscripcionIds();
		$this->db->select(
			'inscripcion.id_inscripcion,'.
			'alumno.documento,'.
			'alumno.nombres,'.
			'alumno.apellido_paterno,'.
			'alumno.apellido_materno,'.
			'curso.numeracion as numeracion_curso,'.
			'tipo_curso.nombre as nombre_tipo_curso,'.
			'curso.nombre as nombre_curso'

		);
		$this->db->from('inscripcion');
		$this->db->join('solicitud','solicitud.idSolicitud=inscripcion.solicitud_id');
		$this->db->join('alumno','alumno.id_alumno=solicitud.alumno');
		$this->db->join('curso','curso.id_curso=solicitud.programa');
		$this->db->join('tipo_curso','curso.idTipo_curso=tipo_curso.idTipo_curso');
		$this->db->where_not_in('inscripcion.id_inscripcion',$all_programed_ids);
		if($filter_programa_id!=null){
			$this->db->where('solicitud.programa',$filter_programa_id);
		}
		$result=$this->db->get();
		return $result->result_array();
	}

	function delete($id){
		$this->db->trans_begin();
		if(!empty($id)){
			$this->db->where($this->id, $id);
			$this->db->delete($this->table);
		}else{
			throw new Exception("Error al tratar de eliminar una entrevista con id : ".$id);
		}

		$status=$this->db->affected_rows()==1;
		if($status){
			$this->db->trans_commit();
		}else{
			$this->db->trans_rollback();
		}

		return $status;
	}
	
	function update($interview_id,$estado_id){
		$this->db->trans_begin();
		
		$inscripcion=$this->get($interview_id);
		$this->Inscripcion_model->updateEstadoEntrevista($inscripcion['inscripcion_id'],$estado_id);

		$this->db->where($this->id,$interview_id);
		$this->db->update($this->table,[$this->estado_id=>$estado_id]);

		$status=$this->db->affected_rows()==1;
		if($status){
			$this->db->trans_commit();
		}else{
			$this->db->trans_rollback();
		}

		return $status;
	}

	private function multiModelsTransactions($querysCallBack){
		$this->db->trans_begin();
		
		$querysCallBack();

		$status=$this->db->affected_rows()==1;
		if($status){
			$this->db->trans_commit();
		}else{
			$this->db->trans_rollback();
		}

		return $status;
	}
}
