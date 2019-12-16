<?php 
class TipoUsuario_model extends CI_Model
{
	private $table='tipousuario';
	private $id='id';
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('mihelper');
    }
    /**
	 * obtener los roles de un usuario
	 * 
	 * @var integer id_user 
	 */
	function getTipoUsuarioByUserId($id_user){

		$this->db->select('ti.*');
		$this->db->from($this->table.' ti');
		$this->db->join('usuario u','ti.id=u.tipousuario');
		$this->db->where('u.id',$id_user);

		return $this->db->get()->result_array();
	}    
}