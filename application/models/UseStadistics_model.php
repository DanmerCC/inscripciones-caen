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
		$result=$this->db->query("SELECT  COUNT(id_inscripcion) as cantidad,DATE(created) AS fecha  FROM inscripcion GROUP BY DAY(created), MONTH(created) , YEAR(created) ORDER BY created asc");
		return $result->result_array();
	}
}
