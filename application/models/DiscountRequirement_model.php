<?php 



class DiscountRequirement_model extends MY_Model
{
	protected $table='discount_requirement';
	
	protected $id='id';
	protected $requirement_id='requirement_id';
	protected $discount_id='discount_id';

	protected $public_columns=['id','requirement_id','discount_id'];
	protected $fillable=['requirement_id','discount_id'];

	function __construct()
	{
		parent::__construct();
	}

	public function getOneDataByDiscountAndRequirements($discount_id,$requirement_id)
	{
		return $this->db->from($this->table)
				->where($this->requirement_id,$requirement_id)
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
			throw new Exception("Error buscar un Discount requirement");
		}
	}

	public function registrar($discount_id,$requirement_id){
		$data=array(
			$this->discount_id => $discount_id,
			$this->requirement_id => $requirement_id
		);
		return $this->db->insert($this->table,$data);
	}

	function update($id,$values){
		
		return $this->parentUpdate($id,$values);
		
	}

	function delete($id){
		return $this->parentDelete($id);
	}
}
