<?php 
/**
 * 
 */
class UseStadistics_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	function count_inscripcions_day_month(){
		$result=$this->db->query("SELECT  COUNT(id_inscripcion) as cantidad,MONTH(created)as mes,DAY(created) as dia FROM inscripcion GROUP BY DAY(created), MONTH(created)");
		return $result->result_array();
	}
}
