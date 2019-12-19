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

	function haveRowsBySolicitud($solicitud_id)
	{
		$result = $this->db->get_where('solicitud_discount',array('solicitud_id'=>$solicitud_id));
		if($result->num_rows()>=1){
			return true;
		}else{
			return false;
		}
	}

	function bySolicituds($arrayIds){
		$this->db->select($this->table.'.*,solicitud_discount.solicitud_id,curso.nombre,curso.numeracion,t.nombre as tipo')->from($this->table)
		->join('solicitud_discount','solicitud_discount.discount_id='.$this->table.'.'.$this->id)
		->join('solicitud','solicitud.idSolicitud=solicitud_discount.solicitud_id')
		->join('curso','solicitud.programa=curso.id_curso')
		->join('tipo_curso t','t.idTipo_curso=curso.idTipo_curso')
		->where_in('solicitud_discount.solicitud_id',$arrayIds);
		return $this->db->get()->result_array();
	}

	function hasRequirement($idDiscount){
		$this->db->select('COUNT(id) as cantidad')
		->from('discount_requirement')
		->where('discount_id',$idDiscount);
		$cantidad=$this->db->get();
		return $cantidad->row()->cantidad>0;
	}

	function hasSolicitud($idDiscount){
		$this->db->select('COUNT(id) as cantidad')
		->from('solicitud_discount')
		->where('solicitud_id',$idDiscount);
		$cantidad=$this->db->get();
		return $cantidad->row()->cantidad>0;
	}
	
}
