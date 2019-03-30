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
		//create a new register
		$hash_state = 0;
		$data = array(
			$this->id_usuario => $id_usu,
			$this->state => $hash_state
		);
		$this->db->trans_start();
			$this->db->insert($this->table, $data);
			$lastid = $this->db->insert_id();
			
			//get a new register
			$this->db->select();
			$this->db->from($this->table);
			$this->db->where($this->id,$lastid);
			$result = $this->db->get();
			$row = $result->row();

			//update register with a hash md5
			$this->db->where($this->id,$lastid);
			$tokendata=array(
				$this->hash_create=>md5($row->id . $row->id_usuario . $row->time_stamp)
			);
			$this->db->update($this->table,$tokendata);

			//Select a register complete from table
			$this->db->select();
			$this->db->from($this->table);
			$this->db->where($this->id,$lastid);
			$complete_record = $this->db->get();
			$row_complete_record = $complete_record->row();
		$this->db->trans_complete();
		return ($complete_record->num_rows() === 1) ? $row_complete_record->hash_create : false;
	}

	public function verificar_requestHash($code){
		
		$result = $this->db->select("*,time_stamp > '".date('Y-m-d H:i:s', strtotime('-30 minute'))."' as calculo ,'".date('Y-m-d H:i:s', strtotime('-30 minute'))."'")->from($this->table)->where(
					array(
						$this->hash_create=>$code,
						$this->state=>0,
						$this->time_stamp." > "=>date('Y-m-d H:i:s', strtotime('-30 minute'))
					)
				)->get();
		$row = $result->row();
		if($result->num_rows()===1){
			$this->db->where($this->id,$row->id);
			$this->db->update($this->table,array(
				$this->state=>1
			));
			return $row->id;
		} else {
			return false;
		}
	}
}
