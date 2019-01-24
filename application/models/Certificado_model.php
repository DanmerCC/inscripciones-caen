<?php 



class Certificado_model extends CI_Model
{
    
	private $table='participante';
	private $DB2;
	function __construct()
	{
		parent::__construct();
		$this->DB2 = $this->load->database('dbcasede', TRUE);
	}

	public function verificar($hash){
		$this->DB2->select();
		$this->DB2->from($this->table);
		$this->DB2->where('idmd5Badge',$hash);
		return $this->DB2->get();
		
	
	}

}