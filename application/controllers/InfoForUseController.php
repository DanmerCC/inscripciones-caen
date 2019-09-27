<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class InfoForUseController extends MY_Controller
{
	
	public function __construct()
	{

		parent::__construct();
		$this->load->model('UseStadistics_model');
	}

	public function index()
	{
		if($this->verify_token()){
			$result=$this->UseStadistics_model->count_inscripcions_day_month();
			$this->response($result,200);
		}else{
			$this->response("Error",401);
		}
		
	}




} 
