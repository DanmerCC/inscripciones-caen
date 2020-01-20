<?php 
/**
 * 
 */
class StateInterviewProgramed_model extends MY_Model
{
	
	public $table='intvw_state_programmed_interviews';
	public $id='id';

	private $states_preload=null;

	public $PENDIENTE=1;
	public $REALIZADA=2;

	function __construct()
	{
		parent::__construct();
		$this->states_preload=$this->all();
	}

	function loadFromMemory(){
		return $this->states_preload;
	}

	function loadFromMemoryById($id=null){
		
		$states=$this->loadFromMemory();
		$state_finded=null;
		if(empty($id)){
			return null;
		}
		for ($i=0; $i < count($states); $i++) { 
			if($states[$i][$this->id]==$id){
				$state_finded=$states[$i];
			}
		}
		return $state_finded;
	}


	/***
	 * @return array con todos los registros y columnas de un modelo  
	*/
	  function all(){
		$result=$this->db->select()->from($this->table)->get();
		return $result->result_array();
	}
}
