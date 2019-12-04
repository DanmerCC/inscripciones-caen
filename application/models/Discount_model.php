<?php 



class Discount_model extends MY_Model
{
	protected $table='discounts';
	
	protected $id='id';
	protected $description='description';
	protected $name='name';
	protected $percentage='percentage';


	protected $public_columns=['id','description','name','percentage'];
	
	function __construct()
	{
		parent::__construct();
	}

	public function getOne($id){
		return $this->get($id)->row();
	}

	public function registrar($nombre,$description,$percentage){
		$data=array(
			$this->name => $nombre,
			$this->description => $description,
			$this->percentage => $percentage
		);
		return $this->db->insert($this->table,$data);
	}
	
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
