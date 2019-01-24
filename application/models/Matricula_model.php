<?php 



class Matricula_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('mihelper');
	}


	function all(){

		$query='SELECT m.id_matricula, m.id_alumno, m.id_ciclo, m.fecha_pago, m.costo, m.Descripcion, m.condicion, m.usr_creador, m.usr_modificador, m.fecha_creador, m.fecha_modificado,a.nombres,a.apellido_paterno,a.apellido_materno ,a.documento FROM matricula m left JOIN alumno a on m.id_alumno=a.id_alumno';

		return resultToArray($this->db->query($query)); 
	}

	function insertar($alumno,$ciclo,$fecha_pago,$costo,$descripcion){
		$data = array(
	        'id_alumno' => "$alumno",
	        'id_ciclo' => "$ciclo",
			'fecha_pago' => "$fecha_pago",
			'costo'=>"$costo",
			'Descripcion'=>"$descripcion"
		);
		$this->db->insert('matricula', $data);
		return $this->db->affected_rows()==1;
	}
}