<?php 

/*
Modelo de notificaciones
*/

class Notificacion_model extends MY_Model
{
	private $table='notifications';

	private $id='id';
	private $tipo_usuario_id='tipo_usuario_id';
	private $action_id='action_id';
	private $mensaje='mensaje';

	function __construct()
	{
		parent::__construct();
		$this->load->helper('mihelper');
		$this->load->library('Nativesession');
		
	}

	function create($array){
		$this->db->insert($this->table,$array);
		return $this->db->affected_rows()===1;
	}

	function createAndReturnId($array){
		$this->db->insert($this->table,$array);
		if ($this->db->affected_rows()===1) {
			return $this->db->insert_id();
		}
		return 0;
	}

	function types(){
		$this->load->model('Action_model');
		return $this->Action_model->all();
	}

	function readNotificatiom($idNotification){
		$data=array(
			'usuario_id'=>(int)$this->nativesession->get('idUsuario'),
			'notification_id'=>$idNotification
		);
		$this->db->insert('read_notifications',$data);
		return $this->db->affected_rows()===1;
	}

	/**
	 * Crear tabla notifications_solicituds
	 * @param array los campos como solicitud_id y notificacion id
	 */
	function createNotificationSolicitud($array){
		$this->db->insert("notifications_solicituds",$array);
	}

	/**
	 * overriding the method
	 */
	function all(){
	
		$idUsuario=$this->nativesession->get('idUsuario');
		$actual_config=$this->getConfig();

		$this->db->select('notifications.*')
		->from('notifications')
		->join('usuario', 'usuario.tipousuario = notifications.tipo_usuario_id', 'left')
		->join('read_notifications', 'read_notifications.notification_id = notifications.id', 'left')
		->where('usuario.id',$idUsuario)
		->where('notifications.time >',$actual_config)
		->where('read_notifications.notification_id IS NULL',NULL)
		->order_by('notifications.time','desc')
		->limit(20);
		$result= $this->db->get();
		$result=$result->result_array();
		return $result;
	}


	function getConfig(){
		$idUsuario=$this->nativesession->get('idUsuario');
		$result=$this->db
			->select('init_watch')
			->from('notification_configs')
			->where('usuario_id',$idUsuario)
			->limit(1)->get();
		if($result->num_rows()===1){
			return $result->result_array()[0]['init_watch'];
		}else{
			$currentTime=date('Y-m-d H:i:s');
			$data=array(
				'usuario_id'=>$idUsuario,
				'init_watch'=>date('Y-m-d H:i:s')
			);
			$this->db->insert('notification_configs',$data);
			return $currentTime;
		}
	}


	function fromSolicitud($idSolcitud){

		$idUsuario=$this->nativesession->get('idUsuario');
		$actual_config=$this->getConfig();

		$this->db->select('notifications.*')
			->from('notifications')
			->join('notifications_solicituds', 'notifications.id = notifications_solicituds.notifications_id', 'rigth')
			->join('usuario', 'usuario.tipousuario = notifications.tipo_usuario_id', 'left')
			->join('read_notifications', 'read_notifications.notification_id = notifications.id', 'left')
			->where('usuario.id',$idUsuario)
			->where('notifications.time >',$actual_config)
			->where('read_notifications.notification_id IS NULL',NULL)
			->where('notifications_solicituds.solicitud_id',$idSolcitud);

		$result= $this->db->get();
		return $result->result_array();
	}

	function fromSolicitudAlumno($idSolcitud,$action_id){

		//$idUsuario=$this->nativesession->get('idUsuario');
		//$actual_config=$this->getConfig();
		$this->db->select('notifications.*')
			->from('notifications')
			->join('notifications_solicituds', 'notifications.id = notifications_solicituds.notifications_id')
			//->join('usuario', 'usuario.tipousuario = notifications.tipo_usuario_id', 'left')
			->join('read_notifications', 'read_notifications.notification_id = notifications.id', 'left')
			->join('action','action.id=notifications.action_id','left')
			//->where('usuario.id',$idUsuario)
			->where('notifications.action_id',$action_id)
			//->where('notifications.time >',$actual_config)
			->where('read_notifications.notification_id IS NULL',NULL)
			->where('notifications_solicituds.solicitud_id',$idSolcitud);

		$result= $this->db->get();
		return $result->result_array();
	}

	public function getActionById($id){
		$action = $this->db->where('id',$id)->get('action')->row();
		if($action!=null){
			return $action;
		}
		return null;
	} 

	public function readByTipo($solicitud_id,$action_id){
		$notifications=$this->fromSolicitudAlumno($solicitud_id,$action_id);

	}

	public function reads(){
		$id_user=$this->nativesession->get('idUsuario');
		$this->select()->from($this->table)->where('usuario_id',$id_user)->get()->result_array();
	}
	public function reads_id(){
		$id_user=$this->nativesession->get('idUsuario');
		$this->db->select('id')
		->from($this->table)
		->where('usuario_id',$id_user)
		->get()
		->result_array();
	}

	public function notifications_id_by_solicituds($arrays_id){
		$id_user=$this->nativesession->get('idUsuario');
		$actual_config=$this->getConfig();
		return $this->db->select('notifications.*')
		->from('notifications')
		->join('usuario', 'usuario.tipousuario = notifications.tipo_usuario_id', 'left')
		->join('read_notifications', 'read_notifications.notification_id = notifications.id', 'left')
		->join('notifications_solicituds', 'notifications_solicituds.notifications_id = notifications.id')
		/*->where('usuario.id',$id_user)*/
		->where('notifications.time >',$actual_config)
		//->where('read_notifications.notification_id IS NULL',NULL)
		->where_in('notifications_solicituds.solicitud_id',$arrays_id)
		//->group_by('notifications_solicituds.solicitud_id')
		->order_by('notifications.time','desc')
		->get()->result_array();
	}
}
