<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 
/**
 * 
 */
class FinanzasTipoAutorizacionController extends MY_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('FinanzasTipoAuthorization_model');
	}

	function all(){
		$observacion=$this->FinanzasTipoAuthorization_model->all();
		return $this->response($observacion,200);
	}
}
