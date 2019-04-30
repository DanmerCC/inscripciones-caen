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
}
