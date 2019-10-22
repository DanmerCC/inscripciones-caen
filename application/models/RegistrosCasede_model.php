<?php


class RegistrosCasede_model extends CI_Model {

	private $table='participante';

	private $fecha_inscripcion='fecha_inscripcion';
	private $DB2;
	private $anio_casede=2019;
	private $marca_asistencia='marca_asistencia';
	private $marca_asistencia_seg='marca_asistencia_seg';

	function __construct(){
		parent::__construct();
		$this->DB2 = $this->load->database('dbcasede', TRUE);
		$this->load->helper('mihelper');
	}


	function listar(){
		$fecha_column=$this->fecha_inscripcion;
		$this->DB2->select();
		$this->DB2->from($this->table);
		$this->DB2->where("YEAR($fecha_column)",$this->anio_casede);
		$query = $this->DB2->get();
		return resultToArray($query);
		
	}

	function insertarAsistencia($id_inscrito){
		$this->insert_asistencia(1,$id_inscrito);
	}

	function insertarAsistencia_seg($id_inscrito){
		$this->insert_asistencia(2,$id_inscrito);
	}

	function get_actual_date(){
		date_default_timezone_set('America/Lima');
		return  date('Y-m-d h:i:s', time());
	}

	function insert_asistencia($tipo,$id_inscrito){
		$fecha=$this->get_actual_date();
		if($tipo==1){
			$data=array(
				$this->marca_asistencia=>$fecha
			);
		}
		if($tipo==2){
			$data=array(
				$this->marca_asistencia_seg=>$fecha
			);
		}
		$this->DB2->where('id_participante',$id_inscrito);
		if(isset($data)){
			$this->DB2->update($this->table,$data);
		}else{
			show_error("peticion incorrecta",500);
		}
	}

}
