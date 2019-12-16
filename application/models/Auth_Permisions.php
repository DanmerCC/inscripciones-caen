<?php 

defined('BASEPATH') OR exit('No direct script access allowed');
                        
class Auth_Permisions extends MY_Model {


	const ADMINTRATOR = 2;

	private $table='auth_permisos';
						
	private $columns=[
		'id'=>'id',
		'nombres'=>'nombres'
	];
	
	function __construct()
	{
		//parent::__construct();
		$this->load->library('Nativesession');
		$this->load->model('AuthRole_model');
		$this->load->helper('mihelper');
	}
		 
	/**
	 * get permisos desde una lista de ids des roles
	 * @var array array_roles
	 */
	function get_roles_array($array_roles){
		
		$this->db->select('p.*');
		$this->db->from($this->table.' p');
		$this->db->join('auth_roles_permisos rp','p.id=rp.auth_permisos_id');
		$this->db->where_in('rp.auth_roles_id',$array_roles);

		return $this->db->get()->result_array();
	}
	
	function get_by_user($id_user){
		/*echo '<pre>';
		print_r(c_extract($this->AuthRole_model->getRolesByUserId($id_user),'id'));
		echo '</pre>';
		exit;*/
		/*$this->db->select('auth_roles_users.auth_roles_id');
		$this->db->from('auth_roles_users');
		$this->db->where('users_id',$id_user);
		$sub=$this->db->get_compiled_select();*/

		$ids=$this->AuthRole_model->getRolesByUserId($id_user);
		if(count($ids)>0){
			$this->db->select('p.*');
			$this->db->from($this->table.' p');
			$this->db->join('auth_roles_permisos rp','p.id=rp.auth_permisos_id');
			$this->db->where_in('rp.auth_roles_id',c_extract($ids,'id'));
			return $this->db->get()->result_array();
		}else{
			return [];
		}
		

	}

	function can($name){

		$id_user=$this->nativesession->get('idUsuario');
		if($this->config->item('app_env') == 'local'){
			$tipoUsers = $this->AuthRole_model->getRolesByUserId($id_user);
			if($this->verifiIfIsAdmin($tipoUsers)) {
				return true;
			}
		}
		
		$permisos=$this->get_by_user($id_user);
		$permisos_nombres=c_extract($permisos,'nombre');
		return in_array($name,$permisos_nombres);
	}
	private function verifiIfIsAdmin($tipoUsers) : bool
	{
		$status = false;
		foreach ($tipoUsers as $key => $value) {
			if ($value['id']==$this::ADMINTRATOR) {
				$status = true;
			}
		}
		return $status;
	}

	function getPermisionCurrentUser(){
		$id_user=$this->nativesession->get('idUsuario');
		$permisos=$this->get_by_user($id_user);
		$permisos_nombres=c_extract($permisos,'nombre');
		return $permisos_nombres;
	}
}
                        
/* End of file Auth_Role.php.php */
    
                        