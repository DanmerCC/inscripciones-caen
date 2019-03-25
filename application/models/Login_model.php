<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model
{
    public function emailExists($correo) {
        $sql = "SELECT a.nombres as firstname, u.correo as email FROM usuario u INNER JOIN alumno a ON a.id_alumno=u.alumno WHERE u.correo = '{$correo}' LIMIT 1";
        $result = $this->db->query($sql);
        $row = $result->row();

        return ($result->num_rows() === 1 && $row->email) ? $row->firstname : false;
    }

    public function verificarPassword($email, $code){
        $sql = "SELECT a.nombres as firstname, u.correo as email FROM usuario u INNER JOIN alumno a ON a.id_alumno=u.alumno WHERE u.correo = '{$email}' LIMIT 1";
        $result = $this->db->query($sql);
        $row = $result->row();
		
		if($result->num_rows()===1){
			return ($code == md5($this->config->item('salt').$row->firstname)) ? true : false;
		} else {
			return false;
		}
    }
    
    public function updatePassword() {
		$email = $this->input->post('email');
		$password = sha1($this->config->item('salt').$this->input->post('password'));

		$sql = "UPDATE usuario SET password = '{$password}' WHERE correo = '{$email}' LIMIT 1";
		$this->db->query($sql);

		if ($this->db->affected_rows() === 1){
			return true;
		} else {
			return false;
		}
	}
}