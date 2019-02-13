<?php 
/**
 * 
 */
class Reportes_model extends CI_Model
{
	private $table='persona';

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
		$this->DB2 = $this->load->database('dbinformes', TRUE);
		$this->load->helper('mihelper');
	}

	private function count($column,$alias,$forColumn,$discriminator){
		$this->DB2->select('COUNT('.$column.') as '.$alias);
		$this->DB2->from($this->table);
		$this->DB2->where($forColumn,$discriminator);
		return $this->DB2->get();
	}
	
	public function report_person($programa){
		return $this->count($this->id,'cantidad_personas',$this->programa,$programa);
	}

	public function report_person_program($tipo_programa){
		return $this->count($this->programa,'programa',$this->tipo_programa,$tipo_programa);
	}


	public function pruebacontar($tabla){
		if($tabla !="persona"){
			$this->DB2->where("condicion","1");
		}		
		$resultados=$this->DB2->get($tabla);
		return $resultados->num_rows();
		
	}	

	public function contDoct($tabla){
		$this->DB2->where("tipo_programa","1");		
		$resultados=$this->DB2->get($tabla);
		return $resultados->num_rows();
		
	}

	public function cantMae($tabla){
		$this->DB2->where("tipo_programa","2");		
		$resultados=$this->DB2->get($tabla);
		return $resultados->num_rows();
		
	}

	public function cantDiplo($tabla){
		$this->DB2->where("tipo_programa","3");		
		$resultados=$this->DB2->get($tabla);
		return $resultados->num_rows();
		
	}

}