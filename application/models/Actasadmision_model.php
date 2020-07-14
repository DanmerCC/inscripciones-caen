<?php 

/*
Modelo de action acciones relacionadas a una notificacion
*/

class Actasadmision_model extends MY_Model
{
	private $table='acta_admision';

	private $id='id';
	private $filename='filename';
	private $uploaded='uploaded';///timestamp
	
	private $FILE_PATH = 'actaadmids';

	function __construct()
	{
		parent::__construct();
		$this->load->helper('mihelper');
		
	}

	public static function generateFileName(){
		return 'actaadmin_'.str_replace('.','_',microtime(true));
	}

	public function create($inputname){

		$newname = $this->generateFileName().".pdf";

		if(move_uploaded_file($_FILES[$inputname]["tmp_name"],CC_BASE_PATH."/".$this->FILE_PATH."/" . $newname)){

			$this->db->insert($this->table,[
				'filename'=>$newname
			]);

			if($this->db->affected_rows()==1){
				return $this->db->insert_id();
			}else{
				throw new Exception("Error al registrar el acta");
			}

		}else{
			throw new Exception("Error al guardar el archivo");
		}
	}

	function find($id){
		return $this->db->select()->from($this->table)->where('id',$id)->get()->result_object();
	}

	function getContents($id){
		$acta = $this->find($id);
		return file_get_contents(CC_BASE_PATH."/".$this->FILE_PATH."/" . $acta->filename);
	}

	function getPath(){
		return CC_BASE_PATH."/".$this->FILE_PATH."/";
	}
	
}
