<?php 



class Cursosdiscount_model extends MY_Model
{
	protected $table='cursos_discounts';
	
	protected $id='id';
	protected $curso_id='curso_id';
	protected $discount_id='discount_id';


	protected $public_columns=['id','curso_id','discount_id'];
	protected $fillable=['curso_id','discount_id'];

	function __construct()
	{
		parent::__construct();
	}

	public function getOneDataByDiscountAndCursos($discount_id,$curso_id)
	{
		return $this->db->from($this->table)
				->where($this->curso_id,$curso_id)
				->where($this->discount_id,$discount_id)
				->get()
				->row();
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

	public function registrar($discount_id,$curso_id){
		$data=array(
			$this->discount_id => $discount_id,
			$this->curso_id => $curso_id
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

	function update($id,$values){
		
		return $this->parentUpdate($id,$values);
		
	}

	function delete($id){
		return $this->parentDelete($id);
	}
}
