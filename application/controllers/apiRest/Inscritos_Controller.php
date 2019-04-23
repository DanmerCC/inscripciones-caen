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

        if(isset($_GET["size"])){
            $page=isset($_GET["page"])?$_GET["page"]:10;
            $size=$_GET["size"];
            $inscritos=$this->Inscripcion_model->get_page(($size*$page),$size);
        }else{
            $inscritos=$this->Inscripcion_model->get_all();
        }
        
        $this->response($inscritos,200);
    }

    public function getById($id){
        
        if(!$this->verify_token()){
            $this->response("No permitido",401);
        }
        
        $inscrito=$this->Inscripcion_model->get_by_id($id)[0];
        array_push($inscrito,array("sdasd"=>$this->verify_token()));
        $this->response($inscrito,200);
        
    }
}