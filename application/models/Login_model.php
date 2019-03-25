<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model
{
    public function emailExists($correo) {
        $sql = "SELECT a.nombres, u.correo FROM usuario u INNER JOIN alumno a ON a.id_alumno=u.alumno WHERE u.correo = '{$correo}' LIMIT 1";
        $result = $this->db->query($sql);
        $row = $result->row();

        return ($result->num_rows() == 1 && $row->correo) ? $row->nombres : false;
    }
}