<?php
class MY_Model extends CI_Model {


	private $public_arguments;

    function __construct()
    {
		parent::__construct();
		$this->setPublicColumns();
	}
	
	private function setPublicColumns(){
		$this->public_arguments=[];
	}

	/**
	 * agrega un string a la lista de columnas publicas
	 * en caso de ya existir devuelve false y true en caso contrario
	 * @method addPublicColumn
	 * 
	 */
	private function addPublicColumn(String $value){
		if(in_array($value,$this->public_arguments)){
			return false;
		}else{
			array_push($this->public_arguments,$value);
			return true;
		}
		
	}

	/**
	 * Devuelve la lista de columnas publicas en forma de array
	 * se puede agregar un alias para devolver las columnas en formato
	 * 			["alias.columna1","alias.columna2",...]
	 */
	private function getPublicColumns($alias=NULL){
		if($alias===NULL){
			return $this->public_arguments;
		}else{
			$arraynew=[];
			for ($i=0; $i < count($this->public_arguments); $i++) { 
				$arraynew[$i]=$alias.'.'.$this->public_arguments[$i];
			}
			return $arraynew;
		}
	}
}
