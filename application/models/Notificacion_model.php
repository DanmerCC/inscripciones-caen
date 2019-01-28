<?php 

/*
Modelo de notificaciones
*/

class Notificacion_model extends CI_Model
{
	private $table='notifications';

	private $id='id_notificacion';
	private $notificador='id_usuario';
	private $notificado='id_usuario';
	private $estado='estado_notificacion';
	private	$fecha='fecha_notificado';
	private $contenido='contenido_notification';

	function __construct()
	{
		parent::__construct();
		$this->load->helper('mihelper');
		
	}

	function get_notificaciones_nuevas($id_usuario){
		$this->db->select(
			$this->id,
			$this->notificador,
			$this->estado,
			$this->contenido
		);
		$this->db->from($this->table);
		$this->db->where($this->notificado,$id_usuario);
		return resultToArray($this->db->get());
	}

	function set_nueva_notificacion($notificador,$id_user_notificado,$contenido){
		$data=array(
			$this->notificador=>$notificador,
			$this->notificado=>$id_user_notificado,
			$this->estado=>0,
			$this->contenido=$contenido
		);
		$result=$this->db->insert($this->table,$data);
		return $result;
	}
}
