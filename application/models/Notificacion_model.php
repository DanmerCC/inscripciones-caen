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

	function readNotificatiom($idNotification,$idUsuario){
		$data=array(
			'usuario_id'=>$idUsuario,
			'notification_id'=>$idNotification
		);
		$this->db->insert($this->table,$data);
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

		$this->db->query("SELECT notifications.* FROM notifications
		 INNER JOIN usuario on usuario.tipousuario=usuario.tipousuario 
		 WHERE (usuario.id=11) 
		 and ( notifications.time > '$actual_config') 
		 and ( notifications.id NOT IN (
			SELECT read_notifications.notification_id  FROM read_notifications WHERE read_notifications.usuario_id=$idUsuario)
			)");
		$result= $this->db->get();
		return $result->result_array();
	}


	function getConfig(){
		$idUsuario=$this->nativesession->get('idUsuario');
		$result=$this->db
			->select('init_watch')
			->from('notification_configs')
			->where('usuario_id',$idUsuario)
			->limit(1);
		if($result->num_rows()===1){
			return $result[0]['init_watch'];
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
}
