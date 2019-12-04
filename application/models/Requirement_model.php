<?php 



class Requirement_model extends MY_Model
{
	public $table='requirements';
	
	public $id='id';
	private $name='name';


	private $public_columns=['id','name'];
	
	function __construct()
	{
		parent::__construct();
	}

	public function registrar($nombre){
		$data=array(
			$this->name => $nombre
		);
		$this->db->insert($this->table,$data);
		$ultimoId = $this->db->insert_id();
		return $ultimoId;
	}

/*
	function bySolicitud($id){
		$this->db->select($this->table.'.*');
		$this->db->from($this->table);
		$this->db->join(
			'solicitud_requirement',
			'solicitud_requirement.requirement_id='.$this->table.'.'.$this->id);
		$this->db->where('solicitud_requirement.solicitud_id',$id);
		return $this->db->get()->result_array();
	}

	function byDiscount($id){
		$this->db->select($this->table.'.*');
		$this->db->from($this->table);
		$this->db->join(
			'discount_requirement',
			'discount_requirement.requirement_id='.$this->table.'.'.$this->id);
		$this->db->where('discount_requirement.discount_id',$id);
		return $this->db->get()->result_array();
	}*/

	function bySolicitud($id){
		return $this->byPivot('solicitud','solicitud_id',$id);
	}

	function byDiscount($id){
		return $this->byPivot('discount','discount_id',$id);
	}

	protected function relations(){
		return [
			'discount'=>[
				'pivot_table'=>'discount_requirement',
				'column_relation'=>'requirement_id'
			],
			'solicitud'=>[
				'pivot_table'=>'solicitud_requirement',
				'column_relation'=>'requirement_id'
			],
		];
	}
}
