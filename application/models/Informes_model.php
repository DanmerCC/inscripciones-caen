<?php 
/**
 * 
 */
class Informes_model extends CI_Model
{
	private $table='persona';
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
	
	
	

}