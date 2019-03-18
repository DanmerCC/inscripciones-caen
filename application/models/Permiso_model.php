<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Permiso_model extends CI_Model{

	private $permisions;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('mihelper');
		$this->load->library('Nativesession');
	}

	public function lista($userId){

		$this->db->select('p.url');
		$this->db->from('permisotipousuario ptu');
		$this->db->join('permiso p', 'ptu.permiso=p.idPermiso');
		$this->db->join('usuario u', 'u.tipousuario=ptu.tipoUsuario');
		$this->db->where('u.id',$userId);

		return resultToArray($this->db->get());
	}
	public function getAllByUser(){
		$userId=$this->nativesession->get("idUsuario");
		if($userId==NULL){
			return [];
		}
		$this->db->select('p.url as nombre_permiso');
		$this->db->from('permisotipousuario ptu');
		$this->db->join('permiso p', 'ptu.permiso=p.idPermiso');
		$this->db->join('usuario u', 'u.tipousuario=ptu.tipoUsuario');
		$this->db->where('u.id',$userId);
		return resultToArray($this->db->get());
	}
}
