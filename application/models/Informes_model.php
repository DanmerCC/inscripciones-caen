<?php 
/**
 * 
 */
class Informes_model extends CI_Model
{
	private $table='informes';
	private $consulta='consulta';
	private $fecha='fecha_consulta';
	private $nombres='nombres_apellidos';
	private $programa='programa';
	private $condicion='condicion';

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('mihelper');
	}


	public function all(){
		$this->db->select();
		$this->db->from($this->table);
		$result=$this->db->get();
		return resultToArray($result);
	}
	
	public function marcarInfo($id_solicitud){
	    
	    $data = array(
	        'condicion'=>1
        );
        $this->db->where('id_persona', $id_solicitud);
        return $this->db->update($this->table, $data);
	    
	}
	
	public function quitarMarcaInfo($id_solicitud){
	    
	    $data = array(
	        'condicion'=>0
        );
        $this->db->where('id_persona', $id_solicitud);
        return $this->db->update($this->table, $data);
	    
	}

	public function count(){
		$query = $this->db->query('SELECT * FROM '.$this->table);
		return $query->num_rows();
	}

	public function countByFilter($columnFilter,$value){
		$filters=[
			$this->condicion,
		];
		if(in_array($columnFilter,$filters)){
			$result=$this->db->select()->from($this->table)->where($columnFilter,$value)->get();
			return $result->num_rows();
		}
		return NULL;
	}
	
	public function getLastQueries($limit){
		$this->db->select($this->consulta.','.$this->fecha.','.$this->nombres.','.$this->programa.','.$this->condicion);
		$this->db->from($this->table);
		$this->db->limit($limit);
		$this->db->order_by($this->fecha,'DESC');
		return resultToArray($this->db->get());
	}	
	
	public function save(
			$nombres_ap,
			$email,
			$celular,
			$centro_laboral,
			$programa,
			$opt,
			$consulta
		){
		
		$data=array(
			'nombres_apellidos'=>$nombres_ap,
			'email'=>$email,
			'celular'=>$celular,
			'centro_laboral'=>$centro_laboral,
			'tipo_programa'=>$programa,
			'programa'=>$opt,
			'consulta'=>$consulta
		);
		$result=$this->db->insert($this->table,$data);
		return $this->db->affected_rows()==1;
	}

}
