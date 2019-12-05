<?php 



class Discount_model extends MY_Model
{
	protected $table='discounts';
	
	protected $id='id';
	protected $description='description';
	protected $name='name';
	protected $percentage='percentage';


	private $public_columns=['id','description','name','percentage'];
	
	function __construct()
	{
		parent::__construct();
	}

	public function registrar($nombre,$description,$percentage){
		$data=array(
			$this->name => $nombre,
			$this->description => $description,
			$this->percentage => $percentage
		);
		$this->db->insert($this->table,$data);
		$ultimoId = $this->db->insert_id();
		return $ultimoId;
	}
/*
	function byCurso($id){
		$this->db->select($this->table.'.*');
		$this->db->from($this->table);
		$this->db->join(
			'cursos_discount',
			'cursos_discount.discount_id='.$this->table.'.'.$this->id);
		$this->db->where('cursos_discount.curso_id',$id);
		return $this->db->get()->result_array();
	}

	function bySolicitud($id){
		$this->db->select($this->table.'.*');
		$this->db->from($this->table);
		$this->db->join(
			'solicitud_discount',
			'solicitud_discount.discount_id='.$this->table.'.'.$this->id);
		$this->db->where('solicitud_discount.solicitud_id',$id);
		return $this->db->get()->result_array();
	}
*/
	protected function relations(){
		return [
			'curso'=>[
				'pivot_table'=>'curso_discounts',
				'column_relation'=>'discount_id'
			],
			'solicitud'=>[
				'pivot_table'=>'solicitud_discount',
				'column_relation'=>'discount_id'
			],
		];
	}

	function byCurso($id){
		return $this->byPivot('curso','curso_id',$id);
	}

	function bySolicitud($id){
		return $this->byPivot('solicitud','solicitud_id',$id);
	}
}
