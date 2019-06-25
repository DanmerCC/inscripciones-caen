<?php 
/**
 * 
 */
class User_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('mihelper');
	}


	public function registrar($idusuario,$correo,$contraseña,$alumno){

		$data=array(
			'id' => NULL,
			'acceso' => "$idusuario",
			'password' => password_hash($contraseña,PASSWORD_DEFAULT),
			'alumno' => "$alumno",
			'correo' => "$correo"
		);
		$this->db->insert('usuario',$data);
		return !($this->db->affected_rows()==0);
		 
	}


	public function buscarUsuario($user){
		$this->db->select('acceso,password,alumno,tipo');
		$this->db->from('usuario');
		$this->db->where('usuario.id',$user);
		$result = $this->db->get();
		return resultToArray($result);
	}

	public function validarContraseña($pwd,$id){
		$this->db->select('acceso,password,alumno,tipo');
		$this->db->from('usuario');
		$this->db->where('id',$id);
		$result = $this->db->get();
		$arrayResultado=resultToArray($result);
		return password_verify($pwd,$arrayResultado[0]["password"]);
		//return $arrayResultado;
	}

	public function cambiarContraseña($pwd,$id){
		$data=array(
			'password' => password_hash($pwd,PASSWORD_DEFAULT)
		);
		$this->db->where('id',$id);
		$this->db->update('usuario',$data);
		return ($this->db->affected_rows()==1);
	}

	public function byAlumno($id_alumno){
		$this->db->select('id,acceso,alumno,tipo,tipousuario')
		->from('usuario')
		->where('alumno',$id_alumno);
		$result=$this->db->get();
		if($result->num_rows()!=1){
			return null;
		}
		return $result->result_array()[0];
	}


}


 ?>