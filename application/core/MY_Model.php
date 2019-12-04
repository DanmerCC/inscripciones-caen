<?php
class MY_Model extends CI_Model {

	
	private $public_arguments;

	function __construct()
	{
		parent::__construct();
		$this->load->library('Nativesession');
		$this->setPublicColumns();
	}
	
	/***
	 * for use override this method
	 */
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

	private function get($id=null){
		$this->db->select(
			implode(',',$this->getPublicColumns())
		)->from($this->table);
		if($id!=null){
			$this->db->where($this->id,$id);
		}
		return $this->db->get();
	}
	/*
	private function save($data,$id){
		$this->where($this->id,$id);
		$this->db->update($data);
	}

	private function delete(){
		
	}
	 */


	 /***
	  * @return array con todos los registros y columnas de un modelo  
	  */
	function all(){
		$result=$this->db->select()->from($this->table)->get();
		return $result->result_array();
	}

	function isLoged(){
		return empty($this->nativesession->get('idUsuario'));
	}

	protected function by($column,$value){
		$this->db->select();
		$this->db->from($this->table);
		$this->db->where($column,$value);
		$result=$this->db->get();
		return $result->result_array();
	}

	protected function byPivot($relation_pivot_name,$pivot_column_name,$pivot_column_value){
		if(!isset($this->relations()[$relation_pivot_name])){
			throw new Exception("la $relation_pivot_name relacion no esta definida");
		}
		$relation=$this->relations()[$relation_pivot_name];
		$this->db->select($this->table.'.*');
		$this->db->from($this->table);
		$this->db->join(
			$relation['pivot_table'],
			$relation['pivot_table'].'.'.$relation['column_relation'].'='.$this->table.'.'.$this->id);
		$this->db->where($relation['pivot_table'].'.'.$pivot_column_name,$pivot_column_value);
		return $this->db->get()->result_array();
	}

	protected function relations(){
		return [];
	}
}
