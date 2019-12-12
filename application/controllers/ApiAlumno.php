<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class ApiAlumno extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('Nativesession');
		$this->load->helper('url');
	}

	public function index()
	{
		if($this->nativesession->get("estado")=="logeado"){
			$this->load->model('Alumno_model');
			$alumno=$this->Alumno_model->all($this->nativesession->get("idAlumno"));
			if($alumno->num_rows()==1){
				$result=[];
				$i=0;
				foreach ($alumno->result_array() as $row){
		            $result[$i]=$row;
        		}
        		echo json_encode($result,JSON_UNESCAPED_UNICODE);
			}else{
				show_error("Error en los datos del servidor", 401, $heading = 'Ocurrio un error');
			}

		}else{
			
			redirect(base_url().'login','refresh');
		}

	}

	public function solicitudes(){
		$this->load->model('Alumno_model');
		$solicitudes=$this->Alumno_model->solicitudes($this->nativesession->get("idAlumno"));

		$result=[];
		$i=0;

		$haveBachillerFile=file_exists(CC_BASE_PATH."/files/bachiller/".$this->nativesession->get("dni").".pdf");
		$haveDoctoradoFile=file_exists(CC_BASE_PATH."/files/doctorado/".$this->nativesession->get("dni").".pdf");
		$haveMaestriaFile=file_exists(CC_BASE_PATH."/files/maestria/".$this->nativesession->get("dni").".pdf");

		foreach ($solicitudes->result_array() as $row){
			$hasHojaDatos=file_exists(CC_BASE_PATH."/files/hojadatos/".$row["idSolicitud"].".pdf");

			//verify if have a document Incomplete
			$requiredFile=false;
			$message="";
			switch ($row["idTipoCurso"]) {
				case 1:
					$requiredFile=true;
					break;
				case 2:
					$requiredFile=$haveBachillerFile;
					if(!$haveBachillerFile){
						$message="No olvides cargar tu Bachiller";
					}
					break;
				case 3:
					$requiredFile=$haveMaestriaFile;
					if(!$haveMaestriaFile){
						$message="No olvides cargar tu Maestria";
					}
					break;
				
				default:
					# code...
					break;
			}

			$row["msgUploadFile"]=$message;
			$row["completeFile"]=$requiredFile;
			$row["hasFile"]=$hasHojaDatos;
			$result[$i]=$row;
            $i++;
		}



		echo json_encode($result,JSON_UNESCAPED_UNICODE);
	}

	

	public function solicitud($id){
		$this->load->model('Alumno_model');
		$solicitudes=$this->Alumno_model->solicitudes($this->nativesession->get("idAlumno"));

		$result=[];
		$i=0;

		foreach ($solicitudes->result_array() as $row){
            $result[$i]=$row;
		}
		echo json_encode($result,JSON_UNESCAPED_UNICODE);
	}


	public function documents(){
		$result=[];
		header('Content-Type: application/json');
		
		if($this->nativesession->get("estado")=="logeado"){
			$result=[
				"content"=>[
					"cv"=>file_exists('files/cvs/'.$this->nativesession->get("dni").".pdf"),
					"copy"=>file_exists('files/dnis/'.$this->nativesession->get("dni").".pdf"),
					"dj"=>file_exists('files/djs/'.$this->nativesession->get("dni").".pdf")
				],
				"status"=>"OK"
				
			];
		}else{
			$result=[
				"content"=>[],
				"status"=>"ERROR"
			];
		}
		echo json_encode($result,JSON_UNESCAPED_UNICODE);
	}
} 
