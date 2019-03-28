<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Token_model extends CI_Model
{
    private $table =  'hash_request';

    private $id = 'id';
    private $id_usuario = 'id_usuario';
    private $time_stamp = 'time_stamp';
    private $state = 'state';
    private $hash_create = 'hash_create';

    public function create_requestHash($id_usu){
		$hash_state = 0;
		$data = array(
			$this->id_usuario => $id_usu,
			$this->state => $hash_state
		);
		$this->db->insert($this->table, $data);
        $lastid = $this->db->insert_id();
        echo $lastid;
		$sql2 = "SELECT * FROM $this->table WHERE $this->id = '{$lastid}'";
		$result = $this->db->query($sql2);
		$row = $result->row();

		return ($result->num_rows() === 1) ? md5($row->id . $row->id_usuario . $row->time_stamp) : false;
	}

	public function verificar_requestHash($code){
		$hashstate_one = 0;
		$lastid = $this->db->insert_id();
		$first_query = "SELECT * FROM $this->table WHERE $this->state = '{$hashstate_one}' AND $this->id='{$lastid}'";
        $result = $this->db->query($first_query);
		$row = $result->row();
		
		if($result->num_rows()===1){
			$hashstate_two = 1;
			$second_query = "UPDATE $this->table SET $this->state = {$hashstate_two}, $this->hash_create = '{$code}' WHERE $this->id='{$lastid}'";
			$this->db->query($second_query);
			return true;
		} else {
			return false;
		}
	}
}