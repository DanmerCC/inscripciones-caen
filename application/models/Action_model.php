<?php 

/*
Modelo de action acciones relacionadas a una notificacion
*/

class Action_model extends MY_Model
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
		
	}
}
