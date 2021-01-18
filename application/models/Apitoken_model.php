<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Apitoken_model extends CI_Model
{
	private $table='keys';

	private $id='id';
    private $nombre='level';
    private $ignore_limits='ignore_limits';
    private $date_created='date_created';
    private $key='key';


	function __construct()
	{
		parent::__construct();
		$this->load->helper('mihelper');
	}


	public function exist($token){
        $this->db->select($this->id);
        $this->db->from($this->table);
        $this->db->where($this->key,$token);
        $result=$this->db->get();
        return ($result->num_rows()===1);
	}

	public function create(){

		$random_part = random_int(1000,9999);
		$token = time();

		$resulttoken = $random_part.$token;

		$data = array(
			$this->key => $resulttoken,
			'level' => 1,
			'date_created' => time()
		);
		
		$this->db->insert($this->table, $data);
		
		return $resulttoken;
	}
	
	public function use($token){
		$this->db->where($this->key,$token);
		return $this->db->delete($this->table);
	}
}
