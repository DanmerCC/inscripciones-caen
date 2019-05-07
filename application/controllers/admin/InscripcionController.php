<?php
use SebastianBergmann\GlobalState\Exception;

defined('BASEPATH') OR exit('No direct script access allowed');

class InscripcionController extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Nativesession');
		$this->load->helper('url');
		$this->load->model('Inscripcion_model');
		$this->load->model('Permiso_model');
		$this->load->model('Solicitud_model');
		$this->load->library('opciones');
	}

	public function index()
	{
		if ($this->nativesession->get('tipo')=='admin') {
			$identidad["rutaimagen"]="/dist/img/avatar5.png";
			$identidad["nombres"]=$this->nativesession->get('acceso');
			$opciones["rutaimagen"]=$identidad["rutaimagen"];
			$opciones["menu"]=$this->opciones->segun($this->Permiso_model->lista($this->nativesession->get('idUsuario')),'Inscripcion');

			$data['cabecera']=$this->load->view('adminlte/linksHead','',TRUE);
			$data['footer']=$this->load->view('adminlte/scriptsFooter','',TRUE);
			$data["mainSidebar"]=$this->load->view('adminlte/main-sideBar',$opciones,TRUE);
			$data['mainHeader']=$this->load->view('adminlte/mainHeader',array("identity"=>$identidad),TRUE);
			$this->load->view('dashboard_inscritos',$data);
		}else
		{
			redirect('administracion/login');
		}
	}

	public function create(){
		$idSolicitud=$this->input->post('id_sol');
		
		if(empty($idSolicitud)){
			show_error("Error en la espera de un registro");
			die();
		}
		if($this->nativesession->get('tipo')!='admin'){
			show_error("No tiene permisos necesarios");
			die();
		}
		
		$idUsuario=$this->nativesession->get('idUsuario');
		$this->db->trans_start();
		$this->db->trans_strict(FALSE);
			$created=$this->Inscripcion_model->create($idSolicitud,$idUsuario);
			if($created){
				$result2=$this->Solicitud_model->set_sent_date($idSolicitud);
			}else{
				$result2=0;
			}
			
		$this->db->trans_complete();

		$data["result"]=true;
		$data["status"]="";
		header('Content-Type: application/json');
		if ($this->db->trans_status() === FALSE || !$created ||($result2!=1)) {
			# Something went wrong.
			$this->db->trans_rollback();
			$data["result"]=false;
			$data["status"]="500";
		} 
		else {
			$this->db->trans_commit();
			$data["result"]=true;
			$data["status"]="200";
		}
		
		echo json_encode($data);
		
	}

	public function delete(){
		$idInscripcion=$this->input->post('id');
		if(!empty($idInscripcion)){
			
			$row_afected= $this->Inscripcion_model->delete($idInscripcion);
			if($row_afected==1){
				$result['status']="200";
				$result['content']="OK";
				echo  json_encode($result);
				exit;
			}
		}
		//show_404();
		
	}

	public function datatable_dashboard(){
		$search=$this->input->post("search[]");
		$start=$this->input->post('start');
		$length=$this->input->post('length');
		if(strlen($search["value"])>0){
			$rspta = $this->Inscripcion_model->get_page_and_filter($start,$length,$search["value"]);
		}else{
			$rspta = $this->Inscripcion_model->get_page($start,$length);
		}
		$cantidad=$this->Inscripcion_model->count();
		$data = Array();
		//echo var_dump($rspta);
		//exit;
		$i=0;
		foreach ($rspta as $value) {
			$i++;
				$data[] = array(
				"0" => 
					"<button class='btn btn-danger' onclick='ins.cancel(".$value["id_inscripcion"].");'><i class='fa fa-trash-o' aria-hidden='true'></i> Anular</button>".
					'<div class="btn btn-info" data-toggle="modal" data-target="#mdl_datos_inscritos" onclick="modalDataInscrito.loadData('.$value["idSolicitud"].');"><i class="fa fa-eye"></i></div>',
				"1" => $value["nombres"],
				"2" => $value["apellido_paterno"]." ".$value["apellido_materno"],
				"3" => $value["numeracion"]." ".$value["tipo_curso"]." ".$value["nombre_curso"],
				"4" => $value["documento"],
				"5" => $value["email"],
				//"4" => $value["nombre_user"],
				"6" => (isset($value["celular"])?$value["celular"]:" ")." - ".(isset($value["telefono_casa"])?$value["telefono_casa"]:" "),
				"7" => $value["created"]
			);
		}
		$results = array(
			"sEcho" => $this->input->post('sEcho'), //Informacion para datatables
			"iTotalRecords" => $cantidad, //enviamos el total de registros al datatables
			"iTotalDisplayRecords" => $cantidad, //enviamos total de registros a visualizar
			"aaData" => $data);
		echo json_encode($results);
	}

	public function getResumenSolicitudById($id){
		$this->load->model('Alumno_model');

		$solicitud=$this->Solicitud_model->getAllColumnsById($id);
		$alumno=$this->Alumno_model->findById($solicitud['alumno'])[0];
		$data=[];
		$data=$alumno;
		$data["solicitudes"]=$this->Solicitud_model->countByAlumno($solicitud["alumno"]);
		$data["documentosObject"]=[
			[
				"name"=>"curriculum",
				"identifier"=>"cv",
				"statechecked"=>(boolean)$alumno["check_cv_pdf"],
				"stateUpload"=>file_exists(CC_BASE_PATH."/files/cvs/".$alumno["documento"].".pdf"),
				"fileName"=>$solicitud['alumno']
			],
			[
				"name"=>"declaracion jurada",
				"identifier"=>"dj",
				"statechecked"=>(boolean)$alumno["check_dj_pdf"],
				"stateUpload"=>file_exists(CC_BASE_PATH."/files/djs/".$alumno["documento"].".pdf"),
				"fileName"=>$solicitud['alumno']
			],
			[
				"name"=>"dni",
				"identifier"=>"dni",
				"statechecked"=>(boolean)$alumno["check_dni_pdf"],
				"stateUpload"=>file_exists(CC_BASE_PATH."/files/dni/".$alumno["documento"].".pdf"),
				"fileName"=>$solicitud['alumno']
			],
			[
				"name"=>"bachiller",
				"identifier"=>"bach",
				"statechecked"=>(boolean)$alumno["check_bach_pdf"],
				"stateUpload"=>file_exists(CC_BASE_PATH."/files/bachiller/".$alumno["documento"].".pdf"),
				"fileName"=>$solicitud['alumno']
			],
			[
				"name"=>"maestria",
				"identifier"=>"maes",
				"statechecked"=>(boolean)$alumno["check_maes_pdf"],
				"stateUpload"=>file_exists(CC_BASE_PATH."/files/maestria/".$alumno["documento"].".pdf"),
				"fileName"=>$solicitud['alumno']
			],
			[
				"name"=>"Doctorado",
				"identifier"=>"doct",
				"statechecked"=>(boolean)$alumno["check_doct_pdf"],
				"stateUpload"=>file_exists(CC_BASE_PATH."/files/doctorado/".$alumno["documento"].".pdf"),
				"fileName"=>$solicitud['alumno']
			]

		];

		$data["solicitudFiles"]=[
			[
				"name"=>"Solicitud de Admision",
				"identifier"=>"solad",
				"statechecked"=>(boolean)$solicitud["check_sol_ad"],
				"stateUpload"=>file_exists(CC_BASE_PATH."/files/sol-ad/".$solicitud["idSolicitud"].".pdf"),
				"fileName"=>$solicitud["idSolicitud"]
            ],
            [
				"name"=>"Proyecto de Investigacion",
				"identifier"=>"pinvs",
				"statechecked"=>(boolean)$solicitud["check_proyect_invest"],
                "stateUpload"=>file_exists(CC_BASE_PATH."/files/pinvs/".$solicitud["idSolicitud"].".pdf"),
                "fileName"=>$solicitud["idSolicitud"]
            ],
            [
                "name"=>"Hoja de datos",
				"identifier"=>"hdatos",
				"statechecked"=>(boolean)$solicitud["check_hdatos"],
				"stateUpload"=>file_exists(CC_BASE_PATH."/files/hojadatos/".$solicitud["idSolicitud"].".pdf"),
				"fileName"=>$solicitud["idSolicitud"]
			]

		];

		$imagen;
			if(file_exists(CC_BASE_PATH."/files/foto/".$alumno["documento"].".jpg")){
				$imagen="data:image/jpg;base64,".base64_encode(file_get_contents(CC_BASE_PATH."/files/foto/".$alumno["documento"].".jpg"));

			}else if(file_exists(CC_BASE_PATH."/files/foto/".$alumno["documento"].".png")){
				$imagen="data:image/png;base64,".base64_encode(file_get_contents(CC_BASE_PATH."/files/foto/".$alumno["documento"].".png"));

			}else if(file_exists(CC_BASE_PATH."/files/foto/".$alumno["documento"].".gif")){
				$imagen="data:image/gif;base64,".base64_encode(file_get_contents(CC_BASE_PATH."/files/foto/".$alumno["documento"].".gif"));
				
			}else{
				$imagen="/dist/img/avatar5.png";
			}
		$data["fotoData"]=$imagen;
			header("Content-type:application/json");
			echo json_encode([
				"content"=>[],
				"status"=>"OK",
				"result"=>$data
					
			],JSON_UNESCAPED_UNICODE);
	}
	
}
