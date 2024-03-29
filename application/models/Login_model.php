<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('mihelper');
		$this->load->model('Token_model');
		$this->load->model('User_model');
	}

  public function validityEmail_Existence($correo) {
		$tipoAlumno = 1;
		// $sql = "SELECT IF(a.nombres IS NULL ,'nombre-sin-registrar',a.nombres) as firstname, u.correo as email FROM usuario u LEFT JOIN alumno a ON a.id_alumno=u.alumno WHERE u.correo = '{$correo}' AND u.tipousuario = {$tipoAlumno} LIMIT 1";
		$sql = "SELECT id as id_usuario, correo as email FROM usuario WHERE correo = '{$correo}' AND tipousuario = {$tipoAlumno} LIMIT 1";
		$result = $this->db->query($sql);
		$row = $result->row();
	 return ($result->num_rows() === 1 && $row->email) ? $row->id_usuario : false;
    // return ($result->num_rows() === 1 && $row->email) ? $row->firstname : false;
  }

  public function verificarPassword($email, $code){
		$userId=$this->Token_model->verificar_requestHash($code);
		if($userId!=false){
			$this->User_model->cambiarContraseña($userId);
		}
    $sql = "SELECT IF(a.nombres IS NULL ,'nombre-sin-registrar',a.nombres) as firstname, u.correo as email FROM usuario u INNER JOIN alumno a ON a.id_alumno=u.alumno WHERE u.correo = '{$email}' LIMIT 1";
    $result = $this->db->query($sql);
    $row = $result->row();
		
		if($result->num_rows()===1){
			return ($code == md5($this->config->item('salt').$row->firstname)) ? true : false;
		} else {
			return false;
		}
	}

  public function updatePassword($textpassword) {

		$email = $this->input->post('email');
		$hashpassword=password_hash($textpassword, PASSWORD_DEFAULT);
		$sql = "UPDATE usuario SET password = '{$hashpassword}' WHERE correo = '{$email}' LIMIT 1";
		$this->db->query($sql);

		if ($this->db->affected_rows() === 1){
			return true;
		} else {
			return false;
		}
	}
}
