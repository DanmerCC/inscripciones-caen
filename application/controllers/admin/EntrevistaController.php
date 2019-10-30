<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 
/**
 * 
 */
class EntrevistaController extends MY_Controller
{
	
	function __construct()
	{
        parent::__construct();
        $this->load->model('InterviewProgramed_model');
        $this->load->library('NativeSession');
    }



    /***
     * 
     */
	function byInscripcion($idInscripcion){
		//$result=$this->InterviewProgramed_model->byIdInscripcion($idInscripcion);
		$result=$this->InterviewProgramed_model->lastedById($idInscripcion);
		$this->response($result);
	}
}
