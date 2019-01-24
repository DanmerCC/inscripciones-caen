<?php 



class Programa_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	public function all(){
		return $this->db->query('SELECT c.id_curso,c.nombre,c.duracion,c.costo_total,c.vacantes,c.fecha_inicio,c.fecha_final,c.idTipo_curso,c.estado,c.numeracion,t.nombre as tipoNombre FROM curso c left join tipo_curso t on c.idTipo_curso = t.idTipo_curso');
	}

    public function allActives(){
		return $this->db->query('SELECT c.id_curso,c.nombre,c.duracion,c.costo_total,c.vacantes,c.fecha_inicio,c.fecha_final,c.idTipo_curso,c.estado,c.numeracion,t.nombre as tipoNombre FROM curso c left join tipo_curso t on c.idTipo_curso = t.idTipo_curso where c.estado=1');
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
}