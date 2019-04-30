<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Restserver\Libraries\REST_Controller;
// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
//To Solve File REST_Controller not found
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';
class apipersona_Controller extends REST_Controller
{

    public function __construct()
	{
		parent::__construct();
        $this->load->library('Nativesession');
        $this->load->model('Alumno_model');
		$this->load->helper('url');
    }

    /**
     * get inscritos by id or all inscritos
     */
    public function persona_get(){
        $id=$this->uri->segment(4);
        $result=$this->Alumno_model->get_all();
        if(isset($id)){
            $result=$this->Alumno_model->get_by_id($id);
        }else{
            $result=$this->Alumno_model->get_all($id);
        }
        $this->response($result);
    }

}