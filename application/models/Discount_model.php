<?php 



class Discount_model extends MY_Model
{
	protected $table='discounts';
	
	protected $id='id';
	protected $description='description';
	protected $name='name';
	protected $percentage='percentage';


	protected $public_columns=['id','description','name','percentage'];
	protected $fillable=['description','name','percentage'];

	function __construct()
	{
		parent::__construct();
	}

	public function getOne($id){
		$this->db->select();
		$this->db->from($this->table);
		$this->db->where($this->id,$id);
		$result=$this->db->get();
		if($result->num_rows()==1){
			return $result->result_array()[0];
		}else{
			throw new Exception("Error buscar un discount");
		}
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
			'cursos'=>[
				'pivot_table'=>'cursos_discounts',
				'column_relation'=>'discount_id'
			],
			'solicitud'=>[
				'pivot_table'=>'solicitud_discount',
				'column_relation'=>'discount_id'
			],
		];
	}

	function byCurso($id){
		return $this->byPivot('cursos','curso_id',$id);
	}

	function bySolicitud($id){
		return $this->byPivot('solicitud','solicitud_id',$id);
	}

	function update($id,$values){
		
		return $this->parentUpdate($id,$values);
		
	}

	function delete($id){
		return $this->parentDelete($id);
	}

	function bySolicituds($arrayIds){
		$this->db->select()->from($this->table.'.*')
		->join('solicitud_discount','solicitud_discount.solicitud_id='.$this->table.'.id')
		->where_in($this->table.'.'.$this->id,$arrayIds);
	}

}
