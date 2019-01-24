<?php 



class Beneficio_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	public function registrar($nombre,$porcentaje,$monto,$idTipoBeneficio,$idCreador){
		$data=array(
			'idBeneficio' => NULL,
			'nombrebeneficio' => "$nombre",
			'porcentajeBeneficio' => "$porcentaje",
			'montoBeneficio' => "$monto",
			'idTipoBeneficio' => "$idTipoBeneficio",
			'creador'=>"$idCreador"
		);
		$this->db->insert('beneficio',$data);
		$ultimoId = $this->db->insert_id();
		return $ultimoId;
	}


	public function all(){
		$this->db->select('b.idBeneficio,b.nombrebeneficio,b.porcentajeBeneficio,b.montoBeneficio,t.idTipoBeneficio,t.descripcion as nombreTipoBeneficio');    
		$this->db->from('beneficio b');
		$this->db->join('tipobeneficio t', 'b.idTipoBeneficio = t.idTipoBeneficio');
		$query = $this->db->get();
		return $query;
	}
}