<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Persona_Controller extends MY_Controller {
	private $base_url;

	public function __construct(){
        parent::__construct();
		$this->load->model('Alumno_model');
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
            $inscritos=$this->Alumno_model->get_page_api(($size*$page),$size);
        }else{
			
			$start_person=isset($_GET["sp_id"])?$_GET["sp_id"]:0;
			if($start_person!=0){
				$this->Alumno_model->setStartId($start_person);
			}
            $inscritos=$this->Alumno_model->get_all_api();
		}
		
        for ($i=0; $i < count($inscritos); $i++) {
			$inscritos[$i]["files_personal"]=$this->array_get_data_files($inscritos[$i]);
			$inscritos[$i]["photo_personal"]=$this->get_photo_object($inscritos[$i]);
		}
        $this->response($inscritos,200);
    }

	/***
	 * @param array de alumno
	 */
	private function array_get_data_files($alumno){
		$data;
		if($alumno!=NULL){
			$data["documentosObject"]=[
				[
					"name"=>"curriculum",
					"identifier"=>"cv",
					"statechecked"=>(boolean)$alumno["check_cv_pdf"],
					"stateUpload"=>file_exists(CC_BASE_PATH."/files/cvs/".$alumno["documento"].".pdf"),
					"fileName"=>$alumno["documento"],
					"urldownload"=>$this->base_url."files/cv/".$alumno["id_alumno"]
				],
				[
					"name"=>"declaracion jurada",
					"identifier"=>"dj",
					"statechecked"=>(boolean)$alumno["check_dj_pdf"],
					"stateUpload"=>file_exists(CC_BASE_PATH."/files/djs/".$alumno["documento"].".pdf"),
					"fileName"=>$alumno["documento"],
					"urldownload"=>$this->base_url."files/dj/".$alumno["id_alumno"]
				],
				[
					"name"=>"dni",
					"identifier"=>"dni",
					"statechecked"=>(boolean)$alumno["check_dni_pdf"],
					"stateUpload"=>file_exists(CC_BASE_PATH."/files/dni/".$alumno["documento"].".pdf"),
					"fileName"=>$alumno["documento"],
					"urldownload"=>$this->base_url."files/dni/".$alumno["id_alumno"]
				],
				[
					"name"=>"bachiller",
					"identifier"=>"bach",
					"statechecked"=>(boolean)$alumno["check_bach_pdf"],
					"stateUpload"=>file_exists(CC_BASE_PATH."/files/bachiller/".$alumno["documento"].".pdf"),
					"fileName"=>$alumno["documento"],
					"urldownload"=>$this->base_url."files/bach/".$alumno["id_alumno"]
				],
				[
					"name"=>"maestria",
					"identifier"=>"maes",
					"statechecked"=>(boolean)$alumno["check_maes_pdf"],
					"stateUpload"=>file_exists(CC_BASE_PATH."/files/maestria/".$alumno["documento"].".pdf"),
					"fileName"=>$alumno["documento"],
					"urldownload"=>$this->base_url."files/maes/".$alumno["id_alumno"]
				],
				[
					"name"=>"Doctorado",
					"identifier"=>"doct",
					"statechecked"=>(boolean)$alumno["check_doct_pdf"],
					"stateUpload"=>file_exists(CC_BASE_PATH."/files/doctorado/".$alumno["documento"].".pdf"),
					"fileName"=>$alumno["documento"],
					"urldownload"=>$this->base_url."files/doct/".$alumno["id_alumno"]
				]
	
			];
		}
		return $data["documentosObject"];
	}

	/**
	 * photo_object
	 *
	 * @return void
	 */
	private function get_photo_object($alumno){
		$state=false;
		$extension = "none";
		$imagen;
			if(file_exists(CC_BASE_PATH."/files/foto/".$alumno["documento"].".jpg")){
				$extension = "jpg";
				$state=true;
				$imagen="data:image/jpg;base64,".base64_encode(file_get_contents(CC_BASE_PATH."/files/foto/".$alumno["documento"].".jpg"));

			}else if(file_exists(CC_BASE_PATH."/files/foto/".$alumno["documento"].".png")){
				$extension = "jpg";
				$state=true;
				$imagen="data:image/png;base64,".base64_encode(file_get_contents(CC_BASE_PATH."/files/foto/".$alumno["documento"].".png"));

			}else if(file_exists(CC_BASE_PATH."/files/foto/".$alumno["documento"].".gif")){
				$extension = "jpg";
				$state=true;
				$imagen="data:image/gif;base64,".base64_encode(file_get_contents(CC_BASE_PATH."/files/foto/".$alumno["documento"].".gif"));
				
			}else{
				$extension = "none";
				$imagen="#";
			}
		return 
		[
			"extension" => $extension,
			"name"=>"Foto",
			"identifier"=>"foto",
			"stateUpload"=>$state,
			"fileName"=>$alumno["documento"],
			"urldownload"=>$this->base_url."files/foto/".$alumno["id_alumno"]
		];
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
		$inscrito["files_personal"]=$this->array_get_data_files($inscrito);
		$inscrito["photo_personal"]=$this->get_photo_object($inscrito);
        if(isset($inscrito)){
            $this->response($inscrito,200);
        }else{
            $this->response(array("response"=>"No encontrado"),404);
        }
		
		
		
    }
}
