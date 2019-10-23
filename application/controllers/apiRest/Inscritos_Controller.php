<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inscritos_Controller extends MY_Controller {

	public $base_url;
	public function __construct(){
        parent::__construct();
		$this->load->model('Inscripcion_model');
		$this->base_url=base_url()."api/v1/";

    }
    
    /**
     * @var page evalua 0 como la primera pagina
     * 
     */
    public function get(){
        $inscritos=NULL;
        if(!$this->verify_token()){
            $this->response("No permitido",401);
        }

        if(isset($_GET["size"])){
            $page=isset($_GET["page"])?$_GET["page"]:0;
            $size=$_GET["size"];
            $inscritos=$this->Inscripcion_model->get_page_api(($size*$page),$size);
        }else{
            $inscritos=$this->Inscripcion_model->get_all_api();
        }
        $inscritos=$this->add_info_files($inscritos);
        $this->response($inscritos,200);
    }

    public function getById($id){
        
        if(!$this->verify_token()){
            $this->response("No permitido",401);
        }
        if(COUNT($this->Inscripcion_model->get_one_api($id))==1){
            $inscrito=$this->Inscripcion_model->get_one_api($id)[0];
        }
        
        if(isset($inscrito)){
			
			$inscrito=$this->add_info_files($inscrito,true);
			$this->response($inscrito,200);
        }else{
            $this->response(array("response"=>"No encontrado"),404);
        }
        
    }

    public function byPrograma($id_programa){
        if(!$this->verify_token()){
            $this->response("No permitido",401);
        }

        if(isset($_GET["size"])){
            $page=isset($_GET["page"])?$_GET["page"]:10;
            $size=$_GET["size"];
            $inscritos=$this->Inscripcion_model->get_page_api_by_program(($size*$page),$size,$id_programa);
        }else{
            $inscritos=$this->Inscripcion_model->get_all_api_by_program($id_programa);
        }
        $inscritos=$this->add_info_files($inscritos);
        $this->response($inscritos,200);

	}

	/**
	 * array de inscritos
	 * devuelve el mismo array con los datos de los documentos agregado
	 * @return array 
	 * @param array inscritos
	 * @param boolean unique
	 */
	private function add_info_files($inscritos,$unique=false){
		if($unique){
			$inscritos["solicitud_files"]=$this->array_get_data_files($inscritos["solicitud_id"]);
		}else{
			for ($i=0; $i < count($inscritos) ; $i++) {
					$inscritos[$i]["solicitud_files"]=$this->array_get_data_files($inscritos[$i]["solicitud_id"]);
			}
		}
		
		return $inscritos;
	}
	
	private function array_get_data_files($id_solicitud){

		$result=array(
			[
			"name"=>"Hoja de datos",
			"identifier"=>"hdatos",
			'stateUpload'=>file_exists(CC_BASE_PATH."/files/hojadatos/".$id_solicitud.".pdf"),
			'urldownload'=>$this->base_url."files/hdatos/".$id_solicitud
			]
			,
			[
			"name"=>"Solicitud de Inscripcion",
			"identifier"=>"solad",
			'stateUpload'=>file_exists(CC_BASE_PATH."/files/sol-ad/".$id_solicitud.".pdf"),
			'urldownload'=>$this->base_url."files/solad/".$id_solicitud
			]
			,
			[
			"name"=>"Proyecto de investigacion",
			"identifier"=>"pinvs",
			'stateUpload'=>file_exists(CC_BASE_PATH."/files/proinves/".$id_solicitud.".pdf"),
			'urldownload'=>$this->base_url."files/pinvs/".$id_solicitud
			]
		);
		return $result;
	}

	public function changeStateInscripcion($inscripcionId){
		
		header('Access-Control-Allow-Origin: *');
		
		$estadoId=$this->input->post('estado_id');
		
		$token=$this->getBearerToken();
		if($token==null){
			echo "Error al verificar el token".var_dump($token);
			$this->setCustomResponseStatusHeader(401,"No authorizado");
			exit;
		}
		if($this->verifyBearerToken($token)){
			$updated=$this->Inscripcion_model->changeState($inscripcionId,$estadoId);
		}else{
			$this->setCustomResponseStatusHeader(401,"No authorizado");
			echo "Token invalido".var_dump($token);
			exit;
		}

		if($updated){
			echo "Actualizado correctamente";
			exit;
		}else{
			echo "No se actualizado";
			exit;
		}
	}

	private function setCustomResponseStatusHeader($code,$text){
		$protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');
		header($protocol . ' ' . $code . ' ' . $text);
	}

	public function verifyBearerToken($token){
		return true;
	}
	public function decoded($number){
		return $number;
		//return hexdec($number);
	}

	public function encode($number){
		
		return $number;
		//return dechex($number);
	}

	/** 
	 * Get header Authorization
	 * */
	function getAuthorizationHeader(){
		$headers = null;
		if (isset($_SERVER['Authorization'])) {
			$headers = trim($_SERVER["Authorization"]);
		}
		else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
			$headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
		} elseif (function_exists('apache_request_headers')) {
			$requestHeaders = apache_request_headers();
			// Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
			$requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
			//print_r($requestHeaders);
			if (isset($requestHeaders['Authorization'])) {
				$headers = trim($requestHeaders['Authorization']);
			}
		}
		return $headers;
	}

	/**
	 * get access token from header
	 * */
	function getBearerToken() {
		$headers = $this->getAuthorizationHeader();
		// HEADER: Get the access token from the header
		if (!empty($headers)) {
			if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
				return $matches[1];
			}
		}
		return null;
	}
	
}
