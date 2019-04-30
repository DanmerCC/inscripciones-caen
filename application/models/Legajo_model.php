<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Legajo_model extends MY_Model
{
	private $id_legajo='';
	private $nombre='';
	private $fecha_creado='';
	private $fecha_borrado='';
	private $solicitud_id='';
	private $fecha_modificado='';
	private $autor_id;
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('mihelper');
	}


	private function setPublicColumns(){
		$this->addPublicColumn($this->id);
		$this->addPublicColumn($this->nombre);
		$this->addPublicColumn($this->fecha_creado);
		$this->addPublicColumn($this->autor_id);
	}

	public function insert($nombre,$autor_id,$solicitud_id){

		//verificamos que no existe el registro y si existe establecemos como eliminado
		$this->db->select()->from($this->table)->where(
			array(
				$this->id=>$solicitud_id,
				$this->fecha_borrado." IS NULL"=>NULL
			)
		)->limit(1);
		$sol_anterior=$this->db->get();
		if($sol_anterior->num_rows()==1){
			$solicitud=$sol_anterior->result();
			$this->delete($solicitud[$this->id]);
		}

		//procedemos a crear el nuevo registro
		$data=array(
			$this->nombre=>$nombre,
			$this->fecha_creado=>date('Y/m/d H:i:s'),
			$this->fecha_borrado=>NULL,
			$this->solicitud_id=>$solicitud_id,
			$this->autor_id=>$autor_id
		);
		$this->db->insert($this->table,$data);
		$cant_affected=$this->db->affected_rows();

		
		return ($cant_affected==1);
	}

	/**
	 * busca el legajo usando el id de la solicitud
	 */
	public function get($id_solicitud){
		$this->db->select($this->getPublicColumns());
		$this->db->from($this->table);
		$this->db->where($this->fecha_borrado." IS NULL",NULL);
		return resultToArray($this->db->get());
	}

	/**
	 * elimina el legajo usando el id del legajo
	 * @param id_legajo id de legajo model
	 */
	public function delete($id_legajo){
		$data=array(
			$this->fecha_borrado=>date('Y/m/d H:i:s')
		);
		$this->db->where($this->id,$id_legajo);
		return $this->db->update($this->table, $data);
	}
	
}
