<?php 
/**
 * 
 */
class Reportes_model extends CI_Model
{
	private $table='informes';

	private $id='id_persona';
	private $nom_apellidos='nombres_apellidos';
	private $email='email';
	private $celular='celular';
	private $centro_laboral='centro_laboral';
	private $tipo_programa='tipo_programa';
	private $programa='programa';
	private $consulta='consulta';
	private $fecha_consul='fecha_consulta';
	private $condicion='condicion';
	
	

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('mihelper');
		//$this->DB2 = $this->load->database('informes', TRUE);
		//$this->load->helper('mihelper');
	}

	private function count($column,$alias,$forColumn,$discriminator){
		$this->db->select('COUNT('.$column.') as '.$alias);
		$this->db->from($this->table);
		$this->db->where($forColumn,$discriminator);
		return $this->db->get();
	}
	
	public function report_person($programa){
		return $this->count($this->id,'cantidad_personas',$this->programa,$programa);
	}

	public function report_person_program($tipo_programa){
		return $this->count($this->programa,'programa',$this->tipo_programa,$tipo_programa);
	}


	public function pruebacontar($tabla){
		if($tabla !="informes"){
			$this->db->where("condicion","1");
		}		
		$resultados=$this->db->get($tabla);
		return $resultados->num_rows();
		
	}	

	public function contDoct($tabla){
		$this->db->where("tipo_programa","1");		
		$resultados=$this->db->get($tabla);
		return $resultados->num_rows();
		
	}

	public function cantMae($tabla){
		$this->db->where("tipo_programa","2");		
		$resultados=$this->db->get($tabla);
		return $resultados->num_rows();
		
	}

	public function cantDiplo($tabla){
		$this->db->where("tipo_programa","3");		
		$resultados=$this->db->get($tabla);
		return $resultados->num_rows();
		
	}

}
