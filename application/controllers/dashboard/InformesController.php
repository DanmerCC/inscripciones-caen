<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class InformesController extends CI_Controller
{
    public function __construct()
	{
		parent::__construct();
		$this->load->library('Nativesession');
        $this->load->helper('url');
        $this->load->model('Informes_model');
    }
    
    public function report(){
        $pageDefault=10;
        $cantidad=$this->Informes_model->count();
        $atendidos=$this->Informes_model->countByFilter('condicion',1);
        $consultas=$this->Informes_model->getLastQueries($pageDefault);
        $result["status"]="OK";
        $result["result"]=[
            "cant"=>$cantidad,
            "sol_atend"=>$atendidos,
            "solicitudes"=>$consultas
        ];
        header("Access-Control-Allow-Origin: *");
        header('Content-Type: application/json');
        echo json_encode($result,JSON_UNESCAPED_UNICODE);
    }
}
