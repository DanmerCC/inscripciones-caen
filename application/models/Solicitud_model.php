<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Solicitud_model extends CI_Model
{
	private $tbl_solicitud='solicitud';
	private $id='idSolicitud';
	private $id_programa='programa';
	private $check_sol_ad='check_sol_ad';
	private $check_proyect_invs='check_proyect_invest';
	private $alumno_id='alumno';
	private $check_hdatos='check_hdatos';
	private $state='estado';
	private $notification_mensaje='notification_mensaje';
	private $estado_finanzas_id = 'estado_finanzas_id';


	public $global_stado_finanzas=[];
	public $array_estado_finanzas=[];

	/**
	 * var @sent cuando la solicitud ya esta enviada
	 */
	private $sent='sent_to_inscripcion';

	function __construct()
	{
		parent::__construct();
		$this->load->model('EstadoFinanzasSolicitud_model');
		$this->array_estado_finanzas=$this->EstadoFinanzasSolicitud_model->all();
		$this->load->helper('mihelper');
	}

	public function existe($idAlumno,$programa){
		$result=$this->db->query("SELECT * FROM solicitud WHERE (programa='$programa') AND (alumno ='$idAlumno') AND ($this->sent IS NULL)");
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

	public function getAllOrderByIdSolicitud(){
		$result=$this->db->query("SELECT tc.nombre as nombretipoCurso,s.idSolicitud as idSolicitud,s.estado estado,s.programa,s.alumno as alumno,s.tipo_financiamiento,s.fecha_registro,a.documento,a.nombres,a.apellido_paterno,a.apellido_materno,c.nombre curso_nombre,c.numeracion curso_numeracion ,s.marcaPago , s.comentario FROM solicitud s left join alumno a on s.alumno=a.id_alumno left join curso c on s.programa=c.id_curso left join tipo_curso tc on c.idTipo_curso=tc.idTipo_Curso  where (s.$this->sent IS NULL) ORDER BY s.idSolicitud");
		return $result;
	}

	/***Metodos para datatable paginado y filtrado de datos */
	public function get_data_for_datatable($start,$length,$text=NULL){
		$this->fn_query_datatable_base();
		$this->db->limit($length,$start);
		if($text!==NULL||isset($text)){
			$this->db->group_start();
				$this->db->like('a.nombres',$text);
				$this->db->or_like('a.apellido_paterno',$text);
				$this->db->or_like('a.apellido_materno',$text);
				$this->db->or_like('a.documento',$text);
				$this->db->or_like('c.numeracion',$text);
				$this->db->or_like('s.comentario',$text);
				$this->db->or_like('CONCAT(c.numeracion," ",tc.nombre," ",c.nombre)',$text);
			$this->db->group_end();
		}
		$this->query_part_filter_estado_finanzas();

		return $this->db->get();
	}

	public function count_with_filter($text){
		$this->db->select($this->id);
		$this->fn_query_datatable_base();
			$this->db->group_start();
				$this->db->like('a.nombres',$text);
				$this->db->or_like('a.apellido_paterno',$text);
				$this->db->or_like('a.apellido_materno',$text);
				$this->db->or_like('a.documento',$text);
				$this->db->or_like('c.numeracion',$text);
				$this->db->or_like('s.comentario',$text);
				$this->db->or_like('CONCAT(c.numeracion," ",tc.nombre," ",c.nombre)',$text);
			$this->db->group_end();
		return $this->db->get()->num_rows();
	}

	private function fn_query_datatable_base(){
		$this->fn_db_select();
		$this->db->from($this->tbl_solicitud.' s')
		->join('alumno a','s.alumno=a.id_alumno','left')
		->join('curso c' , 's.programa=c.id_curso','left')
		->join('tipo_curso tc' ,'c.idTipo_curso=tc.idTipo_Curso','left')
		->join('estado_finanzas_solicitud ef','s.estado_finanzas_id = ef.id')
		->group_start()
			->where(array(
				's.'.$this->sent.' IS NULL '=>NULL,
			))
		->group_end()
		->order_by('s.'.$this->id,'desc')
		;
	}

	private function fn_db_select(){
		$this->db->select('tc.nombre as nombretipoCurso,'.
		's.idSolicitud as idSolicitud,'.
		's.estado estado,s.programa,'.
		's.alumno as alumno,'.
		's.tipo_financiamiento,'.
		's.estado_finanzas_id,'.
		's.fecha_registro,'.
		'a.documento,'.
		'a.nombres,'.
		'a.apellido_paterno,'.
		'a.apellido_materno,'.
		'c.nombre curso_nombre,'.
		'c.numeracion curso_numeracion ,'.
		's.marcaPago ,'.
		's.comentario ,'.
		'ef.nombre as estado_finanzas,'.
		's.notification_mensaje');
	}

	public function count_sent_less(){
		$this->db->select($this->id)->from($this->tbl_solicitud)->where(array(
			$this->sent.' IS NULL'=>NULL,
		));
		return $this->db->get()->num_rows();
		
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
		$sql = "UPDATE solicitud SET estado='0' WHERE (idSolicitud = ? ) AND  ($this->sent IS NULL)";
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
		$sql = "DELETE FROM `solicitud` WHERE ( idSolicitud = ?) AND ($this->sent IS NULL)";
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

	function countByAlumno($idAlumno){
		$this->db->select($this->id);
		$this->db->from($this->tbl_solicitud);
		$this->db->where($this->alumno_id,$idAlumno);
		$result = $this->db->get();
		return $result->num_rows();
	}

	function getAllByProgramaFilter($idPrograma){
		/*$this->db->select();
		$this->db->from($this->tbl_solicitud);
		$this->db->where($this->id_programa,$idPrograma);*/

		$this->db->select('c.nombre nombrePrograma, a.nombres, a.apellido_paterno, a.apellido_materno, s.fecha_registro');
		$this->db->from('solicitud s');
		$this->db->join('alumno a', 's.alumno=a.id_alumno');
		$this->db->join('curso c', 's.programa=c.id_curso');
		$this->db->where($this->id_programa,$idPrograma);

		/*
		$this->db->select('s.idSolicitud,a.nombres,a.apellido_paterno,a.apellido_materno,a.documento,a.email,c.nombre nombrePrograma,s.estado,tp.nombre tipoPrograma,s.fecha_registro as fecha_complete,DATE_FORMAT(s.fecha_registro,\'%d-%m-%Y\') as fecha_registro');
        $this->db->from('solicitud s');
        $this->db->join('alumno a', 's.alumno=a.id_alumno');
        $this->db->join('curso c', 's.programa=c.id_curso');
        $this->db->join('tipo_curso tp', 'c.idTipo_curso=tp.idTipo_curso');
		*/

		return resultToArray($this->db->get());
	}

	function getAllByPrograma($limit){
		$this->db->select('c.nombre nombrePrograma, a.nombres, a.apellido_paterno, a.apellido_materno, s.fecha_registro');
		$this->db->from('solicitud s');
		$this->db->join('alumno a', 's.alumno=a.id_alumno');
		$this->db->join('curso c', 's.programa=c.id_curso');
		$this->db->limit($limit);
		$this->db->order_by('s.fecha_registro','DESC');

		return resultToArray($this->db->get());
	}

	public function getAllColumnsById($id){
		$result=$this->db->select()->from($this->tbl_solicitud,$id)->where($this->id,$id)->get();
		if($result->num_rows()===1){
			return $result->result_array()[0];
		}else{
			return NULL;
		}
	}
	
	function setCheckSolicitudInscripcion($id){

		$data = array(
		    $this->check_sol_ad => 1
		);

		$this->db->where($this->id, $id);
		$this->db->update($this->tbl_solicitud, $data);
		$result=($this->db->affected_rows()==1)?1:0;

		return ["result"=>$result];
	}

	/**
 	* Set check Proyect of Investigation to 1
 	*/
	function setCheckProyectInvestigacion($id){
		return $this->setCheckColumnByName($id,$this->check_proyect_invs);
	}
	/**
	 * Set a 1 in the @column especificated
	 */
	function setCheckColumnByName($id,$column){
		$data = array(
			$column => 1	
		);

			$this->db->where($this->id, $id);
			$this->db->update($this->tbl_solicitud, $data);
			$result=($this->db->affected_rows()==1)?1:0;
	
			return ["result"=>$result];
		}
	function setCheckHojadatos($id){

		$data = array(
		    $this->check_hdatos =>date('Y/m/d H:i:s')
		);

		$this->db->where($this->id, $id);
		$this->db->update($this->tbl_solicitud, $data);
		$result=($this->db->affected_rows()==1)?1:0;

		return ["result"=>$result];
	}

	public function verify_requeriments($id){
		$conditions=array(
			$this->id=>$id,
			$this->check_sol_ad=>1,
			$this->state=>1
			//Aqui completar condiciones de que hacer a una solicitud este verificada
		);
		$result=$this->db->select()->from($this->tbl_solicitud)->where($conditions)->get();
		$cant_result_rows=$result->num_rows();
		return ($cant_result_rows===1);
	}

	public function set_sent_date($id){
		$data = array(
			$this->sent=>date('Y/m/d H:i:s')
		);

		$this->db->where($this->id, $id);
		$this->db->update($this->tbl_solicitud, $data);
		return $this->db->affected_rows();
	}

	public function get_notification_status($id){
		return $this->notification_mensaje($id)!='';
	}

	public function get_notification_mensaje($id){
		$this->db
			->select($this->notification_mensaje)
			->from($this->tbl_solicitud)
			->where($this->notification_mensaje,$id);
		$result=$this->db->get();
		if($result->num_rows()===1){
			return $result->result_array()[0][$this->notification_mensaje];
		}
		return NULL;
	}

	public function reset_notification_status($id){
		$data=array(
			$this->notification_mensaje=>''
		);
		$this->db->update($this->tbl_solicitud,$data);
		return $this->db->affected_rows()==1;
	}

	public function set_notification_mensaje($id,$mensaje){
		$data=array(
			$this->notification_mensaje=>$mensaje
		);
		$this->db->where($this->id,$id);
		$this->db->update($this->tbl_solicitud,$data);
		return $this->db->affected_rows()==1;
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
		$this->db->update($this->tbl_solicitud,$data);
		return ($this->db->affected_rows()==1);
	}

	public function getOrFail($id){
		$this->db->select()
		->from($this->tbl_solicitud)
		->where($this->id,$id);
		$result=$this->db->get();
		if($result->num_rows()==1){
			$row_result=$result->result_array()[0];
		}else{
			return new Exception("Solicitud no existe");
		}
		return $row_result;
	}

	function query_part_filter_estado_finanzas(){

		$ids=c_extract($this->array_estado_finanzas,'id');
		if(count($this->global_stado_finanzas)>0){
			$this->db->group_start();
			for ($i=0; $i < count($this->global_stado_finanzas); $i++) {
				
				if(in_array($this->global_stado_finanzas[$i],$ids)){
					$this->db->or_where($this->estado_finanzas_id,$this->global_stado_finanzas[$i]);
				}else{
					
					print_r ($ids);
					echo '</pre>';
					exit;
					throw new Exception("Error  se detecto un  estado invalidado en ".__METHOD__);
				}
			}
			$this->db->group_end();
		}else{
			
		}
		
	}
}
