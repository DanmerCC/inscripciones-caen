<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EstadoFinanzas_Controller extends MY_Controller {

	public $base_url;
	public function __construct(){
        parent::__construct();
		$this->load->model('EstadoFinanzas_model');
		$this->base_url=base_url()."api/v1/";

    }
    
    /**
     * @var page evalua 0 como la primera pagina
     * 
     */
    public function get(){
        $estados_finanzas=NULL;
        if(!$this->verify_token()){
            $this->response("No permitido",401);
        }
		$estados_finanzas=$this->EstadoFinanzas_model->all();
        $this->response($estados_finanzas,200);
    }

    public function getById($id){
        
        if(!$this->verify_token()){
            $this->response("No permitido",401);
        }
        
        $estado=$this->EstadoFinanzas_model->get_one($id);
        if(isset($estado)){
			
			$this->response($estado,200);
        }else{
            $this->response(array("response"=>"No encontrado"),404);
        }
        
    }

    
}
