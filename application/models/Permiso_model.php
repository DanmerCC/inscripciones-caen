<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Permiso_model extends CI_Model{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('mihelper');
	}

	public function lista($userId){

		$this->db->select('p.url');
		$this->db->from('permisotipousuario ptu');
		$this->db->join('permiso p', 'ptu.permiso=p.idPermiso');
		$this->db->join('usuario u', 'u.tipousuario=ptu.tipoUsuario');
		$this->db->where('u.id',$userId);

		return resultToArray($this->db->get());
	}
}