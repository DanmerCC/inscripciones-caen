<?php 

defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class MY_Controller extends CI_Controller
{
    public const OK = 200;
    public const NO_FOUND = 404;
    public const SERVER_ERROR = 500;
    public const UNAUTHORIZED = 401;

    function __construct()
	{
		parent::__construct();
		$this->load->library('Nativesession');
		$this->load->library('Mihelper');
        $this->load->model('Permiso_model');
        $this->load->model('Apitoken_model');
    }
    
    function response($data,$status=200){


        if($status===self::NO_FOUND){
            show_404();
            exit;
        }

        if($status===self::SERVER_ERROR){
            show_error(SERVER_ERROR,"Error interno en el servidor");
            exit;
        }

        if($status===self::UNAUTHORIZED){
            show_error(401,"Sin permiso");
            exit;
        }

        if($status===self::OK){
            header('Content-Type: application/json');
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            exit;
        }
        
    }

    protected function verify_token(){
        if(isset($_GET["TOKEN_CAEN"])){
            return $this->Apitoken_model->exist($_GET["TOKEN_CAEN"]);
        }else{
            return false;
        }
    }
}