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
	 * overriding the method
	 */
	function all(){
		/**
		 * SELECT * FROM notifications 
		 * INNER JOIN usuario on usuario.tipousuario=usuario.tipousuario
		 * WHERE (usuario.id=11) and ( notifications.time > '2019-08-06 12:42:34')
		 * and (notifications.id NOT IN 
		 * 	(
		 * 		SELECT read_notifications.notification_id  FROM read_notifications WHERE read_notifications.usua
		 * 	)
		 * )
		 */
		
			$idUsuario=$this->nativesession->get('idUsuario');
			$actual_config=$this->getConfig();
/*
			$this->db->query("SELECT notifications.* FROM notifications
			INNER JOIN usuario on usuario.tipousuario=usuario.tipousuario 
			WHERE (usuario.id=11) 
			and ( notifications.time > '$actual_config') 
			and ( notifications.id NOT IN (
				SELECT read_notifications.notification_id  FROM read_notifications WHERE read_notifications.usuario_id=$idUsuario)
				)");
		*/

		/**
		 * 
		 * SELECT notifications.* FROM notifications 
         * LEFT JOIN usuario on usuario.tipousuario=notifications.tipo_usuario_id
         * LEFT JOIN read_notifications on read_notifications.notification_id=notifications.id
         * WHERE (usuario.id=11) and ( notifications.time > '2019-08-06 11:42:34')
         * and read_notifications.notification_id IS NULL
		 */

		$this->db->select('notifications.*')
		->from('notifications')
		->join('usuario', 'usuario.tipousuario = notifications.tipo_usuario_id', 'left')
		->join('read_notifications', 'read_notifications.notification_id = notifications.id', 'left')
		->where('usuario.id',$idUsuario)
		->where('notifications.time >',$actual_config)
		->where('read_notifications.notification_id IS NULL',NULL);

		$result= $this->db->get();
		return $result->result_array();
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

}
