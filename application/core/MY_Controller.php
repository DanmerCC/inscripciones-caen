<?php 

defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class MY_Controller extends CI_Controller
{
    const OK = 200;
    const NO_FOUND = 404;
    const SERVER_ERROR = 500;
    const UNAUTHORIZED = 401;

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
            show_error($data,self::SERVER_ERROR);
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
	
	function setHttpHeaderByCode($code = NULL) {

		if ($code !== NULL) {

			$text=$this->getTextHttpCode($code);

			$protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');

			header($protocol . ' ' . $code . ' ' . $text);
		}

		return $code;

	}

    protected function verify_token(){
        if(isset($_GET["TOKEN_CAEN"])){
            return $this->Apitoken_model->exist($_GET["TOKEN_CAEN"]);
        }else{
            return false;
        }
	}
	
	protected function verifyBearerToken($token){
		return $this->Apitoken_model->exist($token);
	}

	public function structuredResponse($data,$codeStatus=200){
		$this->setHttpHeaderByCode($codeStatus);
		$structure=array(
			'data'=>$data,
			'status'=>$this->getTextHttpCode($codeStatus)
		);
		$this->response($structure);
	}


	private function getTextHttpCode($code){
		$text='';
		switch ($code) {
			case 100: $text = 'Continue'; break;
			case 101: $text = 'Switching Protocols'; break;
			case 200: $text = 'OK'; break;
			case 201: $text = 'Created'; break;
			case 202: $text = 'Accepted'; break;
			case 203: $text = 'Non-Authoritative Information'; break;
			case 204: $text = 'No Content'; break;
			case 205: $text = 'Reset Content'; break;
			case 206: $text = 'Partial Content'; break;
			case 300: $text = 'Multiple Choices'; break;
			case 301: $text = 'Moved Permanently'; break;
			case 302: $text = 'Moved Temporarily'; break;
			case 303: $text = 'See Other'; break;
			case 304: $text = 'Not Modified'; break;
			case 305: $text = 'Use Proxy'; break;
			case 400: $text = 'Bad Request'; break;
			case 401: $text = 'Unauthorized'; break;
			case 402: $text = 'Payment Required'; break;
			case 403: $text = 'Forbidden'; break;
			case 404: $text = 'Not Found'; break;
			case 405: $text = 'Method Not Allowed'; break;
			case 406: $text = 'Not Acceptable'; break;
			case 407: $text = 'Proxy Authentication Required'; break;
			case 408: $text = 'Request Time-out'; break;
			case 409: $text = 'Conflict'; break;
			case 410: $text = 'Gone'; break;
			case 411: $text = 'Length Required'; break;
			case 412: $text = 'Precondition Failed'; break;
			case 413: $text = 'Request Entity Too Large'; break;
			case 414: $text = 'Request-URI Too Large'; break;
			case 415: $text = 'Unsupported Media Type'; break;
			case 500: $text = 'Internal Server Error'; break;
			case 501: $text = 'Not Implemented'; break;
			case 502: $text = 'Bad Gateway'; break;
			case 503: $text = 'Service Unavailable'; break;
			case 504: $text = 'Gateway Time-out'; break;
			case 505: $text = 'HTTP Version not supported'; break;
			default:
				$text= 'Unknown http status code "' . htmlentities($code) . '"';
			break;
		}
		return $text;
	}

	public function issetRequestInputs($method,...$varsNames){
		for ($i=0; $i <count($varsNames) ; $i++) { 
			if(!$this->input->{$method}($varsNames[$i])){
				return false;
			}
		}
		return true;
	}
}
