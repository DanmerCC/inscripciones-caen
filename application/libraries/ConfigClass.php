<?php
/**
* 
*/

class ConfigClass 
{
	function objetoConfiguracion(){
		return new Config_Acordion();
	}

}
class Config_Acordion{

    
    public static $first_acordion='first_acordion';
    public static $second_acordion='second_acordion';
    public static $third_acordion='third_acordion';
    public static $quarter_acordion='quarter_acordion';
    public static $fifth_acordion='fifth_acordion';
    public static $sixth_acordion='sixth_acordion';
    public static $seventh_acordion='seventh_acordion';
    public static $eighth_acordion='eighth_acordion';
	public static $nineth_acordion='nineth_acordion';
	
	public $values=array();

    function  __construct(){
		$this->values=array();
		$this->reset();

    }

	public function select($acordion){
		$this->values[$acordion]=true;
	}
    private function como_array(){
		$r=new ReflectionClass (get_class($this));
		return $r->getStaticProperties();
	}
	
	private function reset(){
		$names=$this->como_array();
		foreach ($names as  $name) {
			
			$this->values[$name]=false;
		}
	}
}
