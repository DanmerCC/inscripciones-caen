li<?php
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


    public function report($idPrograma){
        $consultas=$this->Solicitud_model->getAllByPrograma($idPrograma);
        $result["status"]="OK";
        $result["result"]=[
            "solicitudes"=>$consultas
        ];
        header("Access-Control-Allow-Origin: *");
        header('Content-Type: application/json');
        echo json_encode($result,JSON_UNESCAPED_UNICODE);
    }
}