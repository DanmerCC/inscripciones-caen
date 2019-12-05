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

	public function update($id,$data){
		return $this->parentUpdate($id,$data);
	}

	function delete($id){
		return $this->parentDelete($id);
	}

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
