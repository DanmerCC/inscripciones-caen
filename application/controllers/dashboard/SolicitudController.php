<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class SolicitudController extends CI_Controller
{
	
	public function __construct()
	{

		parent::__construct();
		$this->load->library('Nativesession');
        $this->load->helper('url');
        $this->load->model('Solicitud_model');
    }

    public function reportFilter($idPrograma){
        $consultas=$this->Solicitud_model->getAllByProgramaFilter($idPrograma);
        $result["status"]="OK";
        $result["result"]=[
            "solicitudes"=>$consultas
        ];
        header("Access-Control-Allow-Origin: *");
        header('Content-Type: application/json');
        echo json_encode($result,JSON_UNESCAPED_UNICODE);
    }

    public function report(){
        $pageDefault=10;
        $consultas=$this->Solicitud_model->getAllByPrograma($pageDefault);
        $result["status"]="OK";
        $result["result"]=[
            /*"cant"=>$cantidad,*/
            "solicitudes"=>$consultas
        ];
        header("Access-Control-Allow-Origin: *");
        header('Content-Type: application/json');
        echo json_encode($result,JSON_UNESCAPED_UNICODE);
    }
}