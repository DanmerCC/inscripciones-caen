<?php 
/**
 * 
 */
class StateInterviewProgramed_model extends MY_Model
{
	
	private $states_preload;

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
}
