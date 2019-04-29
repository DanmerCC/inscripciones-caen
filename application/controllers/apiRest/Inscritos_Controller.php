<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inscritos_Controller extends MY_Controller {

	public function __construct(){
        parent::__construct();
        $this->load->model('Inscripcion_model');

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
            $page=isset($_GET["page"])?$_GET["page"]:10;
            $size=$_GET["size"];
            $inscritos=$this->Inscripcion_model->get_page_api(($size*$page),$size);
        }else{
            $inscritos=$this->Inscripcion_model->get_all_api();
        }
        
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
            $this->response($inscrito,200);
        }else{
            $this->response(array("response"=>"No encontrado"),404);
        }
        
    }
}