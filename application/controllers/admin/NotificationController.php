<?php
use SebastianBergmann\GlobalState\Exception;

defined('BASEPATH') OR exit('No direct script access allowed');

class NotificationController extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Nativesession');
		$this->load->helper('url');
		$this->load->model('Notificacion_model');
	}
	public function index()
	{
		if ($this->nativesession->get('tipo')=='admin') {
			$this->response($this->Notificacion_model->all());
		}else
		{
			redirect('administracion/login');
		}
	}

	public function read(){
		$id=$this->input->post('notificacion_id');
		$this->Notificacion_model->readNotificatiom($id);

	}


	
}
