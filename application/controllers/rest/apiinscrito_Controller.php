<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');
// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
//To Solve File REST_Controller not found
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';
class apiinscrito_Controller extends REST_Controller
{

    public function __construct()
	{
		parent::__construct();
        $this->load->library('Nativesession');
        $this->load->model('Inscripcion_model');
		$this->load->helper('url');
    }
    /**
     * get inscritos by id or all inscritos
     */
    public function inscripciones_get(){
        $id=$this->uri->segment(4);
        $result=$this->Inscripcion_model->get_all();
        if(isset($id)){
            $result=$this->Inscripcion_model->get_by_id($id);
        }else{
            $result=$this->Inscripcion_model->get_all($id);
        }
        $this->response($result);
    }

}