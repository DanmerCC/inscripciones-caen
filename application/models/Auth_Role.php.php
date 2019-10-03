<?php 

defined('BASEPATH') OR exit('No direct script access allowed');
                        
class Auth_Role extends MY_Model {

	private $table='auth_rol';
						
	private $columns=[
		'id'=>'id',
		'nombres'=>'nombres'
	];
	
	function __construct()
	{
		parent::__construct();
	}
                                       
	function get($id_user){
		$this->db->select($this->table.'.*');
		$this->db->from('auth_roles_users aru');
		$this->db->join($this->table.' ar','ar.id=aru.auth_roles_id');
		$this->db->where('u.id',$id_user);
	}            
}
                        
/* End of file Auth_Role.php.php */
    
                        