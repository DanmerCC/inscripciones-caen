<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Solicitud_model extends CI_Model
{
	private $tbl_solicitud='solicitud';

	function __construct()
	{
		parent::__construct();
		$this->load->helper('mihelper');
	}

	public function existe($idAlumno,$programa){
		$result=$this->db->query("SELECT * FROM solicitud WHERE (programa='$programa') AND (alumno ='$idAlumno')");
		if ($result->num_rows()==1) {
			return true;
		}else{
			return false;
		}
	}


	public function getFichaData($idAlumno,$idFicha){
		$solicitud=$this->db->query("SELECT s.idSolicitud,s.programa,s.alumno,s.tipo_financiamiento as tipoFinanciamiento,s.fecha_registro ,c.nombre as name_programa,c.numeracion as number_programa ,a.* FROM solicitud s  left join curso c on s.programa=c.id_curso left join alumno a on s.alumno=a.id_alumno WHERE (idSolicitud=$idFicha) AND (alumno ='$idAlumno')");
		// $result=[];
		// $i=0;

		// foreach ($solicitud->result_array() as $row){
  //           $result[$i]=$row;
		// }

		if ($solicitud->num_rows()==1) {
			return $solicitud->result_array()[0];
		}else{
			return null;
		}
	}


	public function getFichaDataEspecifico($idFicha){
		$solicitud=$this->db->query("SELECT s.idSolicitud,s.programa,s.alumno,s.tipo_financiamiento as tipoFinanciamiento,s.fecha_registro ,c.nombre as name_programa,c.numeracion as number_programa ,a.* FROM solicitud s  left join curso c on s.programa=c.id_curso left join alumno a on s.alumno=a.id_alumno WHERE idSolicitud='$idFicha';");

		if ($solicitud->num_rows()==1) {
			return $solicitud->result_array()[0];
		}else{
			return null;
		}
	}
	public function getAll(){
		$result=$this->db->query("SELECT tc.nombre as nombretipoCurso,s.idSolicitud,s.estado estado,s.programa,s.alumno,s.tipo_financiamiento,s.fecha_registro,a.documento,a.nombres,a.apellido_paterno,a.apellido_materno,c.nombre curso_nombre,c.numeracion curso_numeracion ,s.marcaPago , s.comentario FROM solicitud s left join alumno a on s.alumno=a.id_alumno left join curso c on s.programa=c.id_curso left join tipo_curso tc on c.idTipo_curso=tc.idTipo_Curso");
		return $result;
	}


	public function marcar(){
		$id=$this->input->post('id');
		$sql = "UPDATE solicitud SET estado='1' WHERE idSolicitud=?";
		$result=$this->db->query($sql,$id);
		if ($result) {
			echo "Solicitud verificada con exito";
		}else
		{
			echo "Error al quitar la marca";
		}
	}

	public function quitarMarca(){
		$id=$this->input->post('id');
		$sql = "UPDATE solicitud SET estado='0' WHERE idSolicitud=?";
		$result=$this->db->query($sql,$id);
		if ($result) {
			echo "Marca quitada";
		}else
		{
			echo "Error al quitar la marca";
		}

	}

	public function marcarPago(){
		$id=$this->input->post('id');
		$sql = "UPDATE solicitud SET marcaPago='1' WHERE idSolicitud=?";
		$result=$this->db->query($sql,$id);
		if ($result) {
			echo "Solicitud verificada con exito";
		}else
		{
			echo "Error al quitar la marca";
		}
	}

	public function quitarMarcaPago(){
		$id=$this->input->post('id');
		$sql = "UPDATE solicitud SET marcaPago='0' WHERE idSolicitud=?";
		$result=$this->db->query($sql,$id);
		if ($result) {
			echo "Marca quitada";
		}else
		{
			echo "Error al quitar la marca";
		}

	}

	public function delete($id){
		$sql = "DELETE FROM `solicitud` WHERE idSolicitud = ?";
		$result=$this->db->query($sql,$id);
		return $result;
	}


	public function atendidas(){
		$result=$this->db->query("SELECT s.idSolicitud,s.estado estado,s.programa,s.alumno,s.tipo_financiamiento,s.fecha_registro,a.documento,a.nombres,a.apellido_paterno,a.apellido_materno,c.nombre curso_nombre,c.numeracion curso_numeracion FROM solicitud s left join alumno a on s.alumno=a.id_alumno left join curso c on s.programa=c.id_curso where s.estado='1';");
		return $result;
	}

	public function solicitud_porId($id,$idAlumno=null){

		$this->db->select('s.idSolicitud,s.programa,s.alumno,s.tipo_financiamiento,s.fecha_registro,c.numeracion,c.nombre as nombreCurso,tc.nombre as tipoCurso,a.documento,a.nombres,a.apellido_paterno,a.apellido_materno');
		$this->db->from('solicitud s');
		$this->db->join('curso c', 's.programa=c.id_curso','left');
		$this->db->join('tipo_curso tc', 'c.idTipo_curso = tc.idTipo_curso','left');
		$this->db->join('alumno a', 's.alumno = a.id_alumno','left');
		$this->db->where('s.idSolicitud',$id);
		if($idAlumno!=null){
			$this->db->where('s.alumno',$idAlumno);
		}

		return $this->db->get();
	}

	//Array
	public function byIdAndAlumno($id,$idAlumno=null){
		return resultToArray($this->solicitud_porId($id,$idAlumno));
	}

	public function existByIdAndAlumno($id,$idAlumno){
		$result=$this->byIdAndAlumno($id,$idAlumno);
		return (count($result)!=0);
	}

	public function informacion($limit,$offset){
	    
	    $this->db->select('s.idSolicitud,a.nombres,a.apellido_paterno,a.apellido_materno,a.documento,a.email,c.nombre nombrePrograma,s.estado,tp.nombre tipoPrograma,s.fecha_registro as fecha_complete,DATE_FORMAT(s.fecha_registro,\'%d-%m-%Y\') as fecha_registro');
        $this->db->from('solicitud s');
        $this->db->join('alumno a', 's.alumno=a.id_alumno');
        $this->db->join('curso c', 's.programa=c.id_curso');
        $this->db->join('tipo_curso tp', 'c.idTipo_curso=tp.idTipo_curso');
        $this->db->limit($limit,$offset);
		//$result=$this->db->query("SELECT s.idSolicitud,a.nombres,a.apellido_paterno,a.apellido_materno,a.documento,a.email,c.nombre nombrePrograma,s.estado,tp.nombre tipoPrograma,s.fecha_registro from solicitud s left JOIN alumno a on s.alumno=a.id_alumno left join curso c on s.programa=c.id_curso left JOIN tipo_curso tp on c.idTipo_curso=tp.idTipo_curso");
		//return $result;
	    return $this->db->get()->result();
	    
	}
	
	function getNumSolicitudes(){
        return $this->db->count_all($this->tbl_solicitud);
    }
    function getComentarioArray($id){
    	$this->db->select('s.idSolicitud,s.comentario');
		$this->db->from('solicitud s');
		$this->db->where('s.idSolicitud',$id);
		return resultToArray($this->db->get());
    }

    function setComentarioArray($id,$comentario){

		$data = array(
		    'comentario' => $comentario
		);

		$this->db->where('idSolicitud', $id);
		$this->db->update('solicitud', $data);
		$result=($this->db->affected_rows()==1)?1:0;//forzamos el envio de 1 o cero en caso de ocurrir algun error

		return ["result"=>$result];
	}
	
	function getByAlumno($idAlumno){
		$this->db->select();
		$this->db->from($this->tbl_solicitud);
		$this->db->where('alumno',$idAlumno);
		return resultToArray($this->db->get());
	}
}
