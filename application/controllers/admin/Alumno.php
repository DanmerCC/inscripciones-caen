<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Alumno extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->library('Nativesession');
		$this->load->library('Mihelper');
		$this->load->library('opciones');
		$this->load->helper('url');
		$this->load->model('Alumno_model');
		$this->load->model('Permiso_model');
	}

	function index(){
	if ($this->nativesession->get('tipo')=='admin') {
			$identidad["rutaimagen"]="/dist/img/avatar5.png";
			$identidad["nombres"]=$this->nativesession->get('acceso');
			$opciones["rutaimagen"]=$identidad["rutaimagen"];
			$opciones["menu"]=$this->opciones->segun($this->Permiso_model->lista($this->nativesession->get('idUsuario')),'Alumnos');
			//echo '<pre>';
			//print_r($this->Permiso_model->lista($this->nativesession->get('idUsuario')));
			//echo '</pre>';
			//exit;
			$data['cabecera']=$this->load->view('adminlte/linksHead','',TRUE);
			$data['footer']=$this->load->view('adminlte/scriptsFooter','',TRUE);
			$data["mainSidebar"]=$this->load->view('adminlte/main-sideBar',$opciones,TRUE);
			$data['mainHeader']=$this->load->view('adminlte/mainHeader',array("identity"=>$identidad),TRUE);
			$this->load->view('dashboard_alumnos',$data);
		}else
		{
			redirect('administracion/login');
		}
	}
	public function datatable(){
		$search=$this->input->post("search[]");
		$start=$this->input->post('start');
		$length=$this->input->post('length');
		$activeSearch=!(strlen($search["value"])==0);
		if(strlen($search["value"])>0){
			$rspta = $this->Alumno_model->getAllInscritosAndFindTextPage($start,$length,$search["value"]);
		}else{
			$rspta = $this->Alumno_model->getAllInscritosPage($start,$length);
		}
		$cantidad=$this->Alumno_model->count();
	   //vamos a declarar un array
	   $data = Array();
	   $i=$start;


	   foreach ($rspta as $value) {
		$i++;
		$haveFileCv=file_exists(CC_BASE_PATH."/files/cvs/".$value["documento"].".pdf");
		$haveFileDni=file_exists(CC_BASE_PATH."/files/dni/".$value["documento"].".pdf");
		$haveFileDj=file_exists(CC_BASE_PATH."/files/djs/".$value["documento"].".pdf");
		$haveFileBach=file_exists(CC_BASE_PATH."/files/bachiller/".$value["documento"].".pdf");
		$haveFileMaes=file_exists(CC_BASE_PATH."/files/maestria/".$value["documento"].".pdf");
		$haveFileDoct=file_exists(CC_BASE_PATH."/files/doctorado/".$value["documento"].".pdf");

		$checkCv=($value["check_cv_pdf"])?"<i class='fa fa-check' aria-hidden='true'></i>":"";
		$checkDni=($value["check_dni_pdf"])?"<i class='fa fa-check' aria-hidden='true'></i>":"";
		$checkDj=($value["check_dj_pdf"])?"<i class='fa fa-check' aria-hidden='true'></i>":"";
		$checkBachiller=($value["check_bach_pdf"])?"<i class='fa fa-check' aria-hidden='true'></i>":"";
		$checkMaestria=($value["check_maes_pdf"])?"<i class='fa fa-check' aria-hidden='true'></i>":"";
		$checkDoctorado=($value["check_doct_pdf"])?"<i class='fa fa-check' aria-hidden='true'></i>":"";

	           $data[] = array(
				"0"=>json_encode($value),
				"1" => $activeSearch?"-":(($cantidad-$i)+1),
				"2" => $value["grado_profesion"],
				"3" => $value["nombres"],
				"4" => $value["apellido_paterno"],
				"5" => $value["apellido_materno"],
				"6" => $value["lugar_trabajo"],
				"7" => $value["celular"]." \n ".$value["telefono_casa"],
				"8" => $value["email"],
				"9" => (($haveFileCv)?"<a href='".base_url()."admin/view/pdf/cv/".$value["id_alumno"]."' target='_blank'><button class='btn btn-primary'><strong>Abrir".$checkCv."</strong></button></a>":"<button class='btn btn-light btn-sm'>No subido</button>"),
				"10" => (($haveFileDni)?"<a href='".base_url()."admin/view/pdf/dni/".$value["id_alumno"]."' target='_blank'><button class='btn btn-primary'><strong>Abrir".$checkDni."</strong></button></a>":"<button class='btn btn-light btn-sm'>No subido</button>"),
				"11" => (($haveFileDj)?"<a href='".base_url()."admin/view/pdf/dj/".$value["id_alumno"]."' target='_blank'><button class='btn btn-primary'><strong>Abrir".$checkDj."</strong></button></a>":"<button class='btn btn-light btn-sm'>No subido</button>"),
				"12" => (($haveFileBach)?"<a href='".base_url()."admin/view/pdf/bach/".$value["id_alumno"]."' target='_blank'><button class='btn btn-primary'><strong>Abrir".$checkBachiller."</strong></button></a>":"<button class='btn btn-light btn-sm'>No subido</button>"),
				"13" => (($haveFileMaes)?"<a href='".base_url()."admin/view/pdf/maes/".$value["id_alumno"]."' target='_blank'><button class='btn btn-primary'><strong>Abrir".$checkMaestria."</strong></button></a>":"<button class='btn btn-light btn-sm'>No subido</button>"),
				"14" => (($haveFileDoct)?"<a href='".base_url()."admin/view/pdf/doct/".$value["id_alumno"]."' target='_blank'><button class='btn btn-primary'><strong>Abrir".$checkDoctorado."</strong></button></a>":"<button class='btn btn-light btn-sm'>No subido</button>"),
				"15" => $value["cod_alumno_increment"],
				"16" => $value["cod_alumno_increment"],
				"17" => NULL,
			);
	    }        
	   $results = array(
	       "sEcho" => $this->input->post('sEcho'), //Informacion para datatables
	       "iTotalRecords" => $cantidad, //enviamos el total de registros al datatables
	       "iTotalDisplayRecords" => $cantidad, //enviamos total de registros a visualizar
		   "aaData" => $data);
	   echo json_encode($results);
	}


	public function viewPdfDocument(){
		//$data='data:application/pdf, '.base64_encode(file_get_contents(CC_BASE_PATH."/files/cvs/"."47327529".".pdf",true));
		//echo "";
		$parturl=$this->uri->segment(4);
		$data=base64_encode(file_get_contents(CC_BASE_PATH."/files/cvs/"."47327529".".pdf",true));
		echo var_dump($parturl);
		//echo var_dump($data);
		$this->load->view("pdf/onlyviewpdf",array('data'=>$data,'text'=>var_dump($parturl)));
	}

	public function set_good_file(){
		$this->load->model('Solicitud_model');

		$tipoDocumento=$this->input->post('type');
		$id=$this->input->post('id');//id alumno
		//echo $tipoDocumento;
		if(($this->nativesession->get('tipo')=='admin')||
		((isset($tipoDocumento))||(isset($id)))){

			$result=NULL;
			
			switch ($tipoDocumento) {
				case 'cv':
					$resultOfConsult=$this->Alumno_model->findById($id);
					if(count($resultOfConsult)!=1){
						show_error("Error en el servidor no se encontro usuario",500);
						die();
					};
					$alumno=$resultOfConsult[0];
					$result=$this->Alumno_model->set_check_cvFile($alumno["id_alumno"]);
					break;

				case 'dj':
					$resultOfConsult=$this->Alumno_model->findById($id);
					if(count($resultOfConsult)!=1){
						show_error("Error en el servidor no se encontro usuario",500);
						die();
					};
					$alumno=$resultOfConsult[0];
					$result=$this->Alumno_model->set_check_djFile($alumno["id_alumno"]);
					break;
				
				case 'dni':
					$resultOfConsult=$this->Alumno_model->findById($id);
					if(count($resultOfConsult)!=1){
						show_error("Error en el servidor no se encontro usuario",500);
						die();
					};
					$alumno=$resultOfConsult[0];
					$result=$this->Alumno_model->set_check_dniFile($alumno["id_alumno"]);
					break;
				case 'bach':
					$resultOfConsult=$this->Alumno_model->findById($id);
					if(count($resultOfConsult)!=1){
						show_error("Error en el servidor no se encontro usuario",500);
						die();
					};
					$alumno=$resultOfConsult[0];
					$result=$this->Alumno_model->set_check_bachFile($alumno["id_alumno"]);
					break;
				case 'maes':
					$resultOfConsult=$this->Alumno_model->findById($id);
					if(count($resultOfConsult)!=1){
						show_error("Error en el servidor no se encontro usuario",500);
						die();
					};
					$alumno=$resultOfConsult[0];
					$result=$this->Alumno_model->set_check_maesFile($alumno["id_alumno"]);
					break;
				case 'doct':
					$resultOfConsult=$this->Alumno_model->findById($id);
					if(count($resultOfConsult)!=1){
						show_error("Error en el servidor no se encontro usuario",500);
						die();
					};
					$alumno=$resultOfConsult[0];
					$result=$this->Alumno_model->set_check_doctFile($alumno["id_alumno"]);
					break;
				case 'sins':
					$resultOfConsult=$this->Alumno_model->findById($id);
					if(count($resultOfConsult)!=1){
						show_error("Error en el servidor no se encontro usuario",500);
						die();
					};
					$alumno=$resultOfConsult[0];
					$result=$this->Alumno_model->set_check_sinstFile($alumno["id_alumno"]);
					break;
				case 'solad':
					$solicitud=$this->Solicitud_model->getAllColumnsById($id);
					$cantSolicitud=$this->Solicitud_model->countByAlumno($solicitud["alumno"]);
					$result["solicitudes"]=$cantSolicitud;
					$result=$this->Solicitud_model->setCheckSolicitudInscripcion($solicitud["idSolicitud"]);
					break;
				case 'hdatos':
					$solicitud=$this->Solicitud_model->getAllColumnsById($id);
					$cantSolicitud=$this->Solicitud_model->countByAlumno($solicitud["alumno"]);
					$result["solicitudes"]=$cantSolicitud;
					$result=$this->Solicitud_model->setCheckHojadatos($solicitud["idSolicitud"]);
					break;

				case 'pinvs':
					$solicitud=$this->Solicitud_model->getAllColumnsById($id);
					$cantSolicitud=$this->Solicitud_model->countByAlumno($solicitud["alumno"]);
					$result["solicitudes"]=$cantSolicitud;
					$result["check_pinvs"]=$this->Solicitud_model->setCheckProyectInvestigacion($solicitud["idSolicitud"]);
					break;

				default:
					$result=0;
					break;
			}
			header("Content-type:application/json");
			echo json_encode([
				"content"=>[],
				"status"=>"OK",
				"result"=>$result
				
			],JSON_UNESCAPED_UNICODE);
		}else{
			//show_404();
			//die();
			echo "Error !!!";
		}
	}

	public function getAlumnoById($idAlumno){
		$resultOfConsult=$this->Alumno_model->findAllInnerSolicitudCountById($idAlumno);
		header("Content-type:application/json");
		if(count($resultOfConsult)!=1){
			echo json_encode([
				"content"=>[],
				"status"=>"NO FOUND",
				"result"=>NULL
					
			],JSON_UNESCAPED_UNICODE);
		}else{
			$alumno=$resultOfConsult[0];
			$alumno["documentosObject"]=[
				[
					"name"=>"curriculum",
					"identifier"=>"cv",
					"statechecked"=>(boolean)$alumno["check_cv_pdf"],
					"stateUpload"=>file_exists(CC_BASE_PATH."/files/cvs/".$alumno["documento"].".pdf"),
					"fileName"=>$idAlumno
				],
				[
					"name"=>"declaracion jurada",
					"identifier"=>"dj",
					"statechecked"=>(boolean)$alumno["check_dj_pdf"],
					"stateUpload"=>file_exists(CC_BASE_PATH."/files/djs/".$alumno["documento"].".pdf"),
					"fileName"=>$idAlumno
				],
				[
					"name"=>"dni",
					"identifier"=>"dni",
					"statechecked"=>(boolean)$alumno["check_dni_pdf"],
					"stateUpload"=>file_exists(CC_BASE_PATH."/files/dni/".$alumno["documento"].".pdf"),
					"fileName"=>$idAlumno
				],
				[
					"name"=>"bachiller",
					"identifier"=>"bach",
					"statechecked"=>(boolean)$alumno["check_bach_pdf"],
					"stateUpload"=>file_exists(CC_BASE_PATH."/files/bachiller/".$alumno["documento"].".pdf"),
					"fileName"=>$idAlumno
				],
				[
					"name"=>"maestria",
					"identifier"=>"maes",
					"statechecked"=>(boolean)$alumno["check_maes_pdf"],
					"stateUpload"=>file_exists(CC_BASE_PATH."/files/maestria/".$alumno["documento"].".pdf"),
					"fileName"=>$idAlumno
				],
				[
					"name"=>"Doctorado",
					"identifier"=>"doct",
					"statechecked"=>(boolean)$alumno["check_doct_pdf"],
					"stateUpload"=>file_exists(CC_BASE_PATH."/files/doctorado/".$alumno["documento"].".pdf"),
					"fileName"=>$idAlumno
				],
				[
					"name"=>"Solicitud de Inscripcion",
					"identifier"=>"sins",
					"statechecked"=>(boolean)$alumno["check_sins_pdf"],
					"stateUpload"=>file_exists(CC_BASE_PATH."/files/sInscripcion/".$alumno["documento"].".pdf"),
					"fileName"=>$idAlumno
				],

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

			$alumno["fotoData"]=$imagen;
			header("Content-type:application/json");
			echo json_encode([
				"content"=>[],
				"status"=>"OK",
				"result"=>$alumno
					
			],JSON_UNESCAPED_UNICODE);
		}
		

	}


	/**End class */
	
}
