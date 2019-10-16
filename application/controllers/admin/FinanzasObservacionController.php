<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 
/**
 * 
 */
class FinanzasObservacionController extends MY_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('FinObservaciones_model');
	}

	function get_by_inscripcion_id($id_inscripcion){
		$observacion=$this->FinObservaciones_model->ultimo($id_inscripcion);
		return $this->response($observacion,200);
	}
}
