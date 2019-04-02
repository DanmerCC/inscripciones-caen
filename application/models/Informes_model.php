<?php 
/**
 * 
 */
class Informes_model extends CI_Model
{
	private $table='persona';
	private $consulta='consulta';
	private $fecha='fecha_consulta';
	private $nombres='nombres_apellidos';
	private $programa='programa';
	private $condicion='condicion';

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('mihelper');
		$this->DB2 = $this->load->database('dbinformes', TRUE);
		$this->load->helper('mihelper');
	}


	public function all(){
		$this->DB2->select();
		$this->DB2->from($this->table);
		$result=$this->DB2->get();
		return resultToArray($result);
	}
	
	public function marcarInfo($id_solicitud){
	    
	    $data = array(
	        'condicion'=>1
        );
        $this->DB2->where('id_persona', $id_solicitud);
        return $this->DB2->update($this->table, $data);
	    
	}
	
	public function quitarMarcaInfo($id_solicitud){
	    
	    $data = array(
	        'condicion'=>0
        );
        $this->DB2->where('id_persona', $id_solicitud);
        return $this->DB2->update($this->table, $data);
	    
	}

	public function count(){
		$query = $this->DB2->query('SELECT * FROM '.$this->table);
		return $query->num_rows();
	}
	
	public function getLastQueries($limit){
		$this->DB2->select($this->consulta.','.$this->fecha.','.$this->nombres.','.$this->programa.','.$this->condicion);
		$this->DB2->from($this->table);
		$this->DB2->limit($limit);
		$this->DB2->order_by($this->fecha,'DESC');
		return resultToArray($this->DB2->get());
	}	
	

}