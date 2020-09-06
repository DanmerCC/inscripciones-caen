<?php 
class Codalumno_model extends CI_Model
{
    
	private $table='alumno';

	protected $write_app_key = '134555123';
	
	function __construct()
	{
		parent::__construct();
	}

	public function crear($dataarray){
		
		if(!$this->all_is_valid(array_column($dataarray,'id_alumno'))){
			return false;
		}

		if(!$this->adminCodeNoexist(array_column($dataarray,'cod_student_admin'))){
			return false;
		}

		$this->db->select('MAX(cod_alumno_increment) as maximo');
		$this->db->from($this->table);
		$result =  $this->db->get()->result_array();
		$value = $result[0]["maximo"];
		$maximo = $value==NULL?0:$value;

		$batch_udpate = [];

		$currentdate = date('Y-m-d h:i:s a', time());
		
		for ($i=0; $i < count($dataarray); $i++) {

			$row = [
				"cod_alumno_created"=>$currentdate,
				"id_alumno"=>$dataarray[$i]['id_alumno'],
				"cod_student_admin"=>$dataarray[$i]['cod_student_admin'],
				"cod_alumno_increment"=>($maximo+$i+1)
			];

			array_push($batch_udpate,$row);
		}
		

		$result = $this->db->update_batch($this->table, $batch_udpate, 'id_alumno');
		
		return $result;
		
	}

	public function all_is_valid($id_alumnos){
		$this->db->select('COUNT(cod_alumno_increment) as created');
		$this->db->from($this->table);
		$this->db->where_in('id_alumno',$id_alumnos);
		$result = $this->db->get()->result_array()[0];
		return (int)$result["created"] == 0;
	}

	public function adminCodeNoexist($codes=[]){
		$this->db->select('COUNT(cod_student_admin) as cantidad');
		$this->db->from($this->table);
		$this->db->where_in('cod_student_admin',$codes);
		$result = $this->db->get()->result_array()[0];
		return (int)$result["cantidad"] == 0;
	}

	public function getLastCorrelative(){
		$this->db->select('COUNT(cod_alumno_increment) as created');
		$this->db->from($this->table);
		$result = $this->db->get()->result_array()[0];
		return (int)$result["created"];
	}

	public function maxCodeAmdin(){
		$this->db->select('MAX(cod_student_admin) as cod_student_admin_count');
		$this->db->from($this->table);
		$result = $this->db->get()->result_array()[0];
		return (int)$result["cod_student_admin_count"];
	}

}
