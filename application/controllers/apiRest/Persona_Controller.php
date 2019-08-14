<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Persona_Controller extends MY_Controller {

	public function __construct(){
        parent::__construct();
        $this->load->model('Alumno_model');
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
            $inscritos=$this->Alumno_model->get_page_api(($size*$page),$size);
        }else{
			
			$start_person=isset($_GET["sp_id"])?$_GET["sp_id"]:0;
			if($start_person!=0){
				$this->Alumno_model->setStartId($start_person);
			}
            $inscritos=$this->Alumno_model->get_all_api();
        }
        
        $this->response($inscritos,200);
    }

    /**
     * 
     */
    public function getById($id){
        
        if(!$this->verify_token()){
            $this->response("No permitido",401);
        }
        if(COUNT($this->Alumno_model->get_one_api($id))==1){
            $inscrito=$this->Alumno_model->get_one_api($id)[0];
        }
        
        if(isset($inscrito)){
            $this->response($inscrito,200);
        }else{
            $this->response(array("response"=>"No encontrado"),404);
        }
        
    }
}
