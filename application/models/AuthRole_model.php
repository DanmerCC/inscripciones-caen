<?php 

defined('BASEPATH') OR exit('No direct script access allowed');
                        
class AuthRole_model extends MY_Model {

	private $table='auth_rol';
						
	private $columns=[
		'id'=>'id',
		'nombres'=>'nombres'
	];
	
	function __construct()
	{
		parent::__construct();
	}

	/**
	 * obtener los roles de un usuario
	 * 
	 * @var integer id_user 
	 */
	function getRolesByUserId($id_user){

		$this->db->select('ar.*');
		$this->db->from('auth_roles_users aru');
		$this->db->join($this->table.' ar','ar.id=aru.auth_roles_id');
		$this->db->where('aru.users_id',$id_user);

		return $this->db->get()->result_array();
	}            
}
                        
/* End of file Auth_Role.php.php */
    
                        