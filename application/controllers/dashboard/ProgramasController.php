<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class ProgramasController extends CI_Controller
{
    public function __construct()
	{
		parent::__construct();
		$this->load->library('Nativesession');
        $this->load->helper('url');
        $this->load->model('Programa_model');
        
    }
    
    public function report(){

        
        $consultas=$this->Programa_model->actives();
        $result["status"]="OK";
        $result["result"]=[
            "cant"=>count($consultas),
            "solicitudes"=>$consultas
        ];
        header("Access-Control-Allow-Origin: *");
        header('Content-Type: application/json');
        echo json_encode($result,JSON_UNESCAPED_UNICODE);
    }
}
