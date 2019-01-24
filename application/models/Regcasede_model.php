<?php 
/**
 * 
 */
class Regcasede_model extends CI_Model
{
	private $table='log_participante';
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('mihelper');
		$this->DB2 = $this->load->database('dbcasede', TRUE);
		$this->load->helper('mihelper');
	}


	public function insert_new_reg($reg_user, $reg_table, $reg_query_action, $reg_id_registro){
	    $data = array(
            'reg_user' => $reg_user,
            'reg_table' => $reg_table,
            'reg_query' => $reg_query_action,
            'reg_id_registro'=>$reg_id_registro
        );

        $this->DB2->insert($this->table, $data);
	}
}