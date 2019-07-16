<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FilesController extends CI_Controller {

    public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('Nativesession');
		$this->load->library('Mihelper');
		$this->load->model('Solicitud_model');
    }
    
    public function get_file_view_as_data(){
		$segmentOfTypeFile=$this->uri->segment(4);
		//$segmentOfNumberDni=$this->uri->segment(5);
		$id=$this->uri->segment(5);
		$data="";
		$pathFile="";

		$this->load->model('Alumno_model');
		$result;
		$idNameAndRegist=NULL;

		switch ($segmentOfTypeFile) {
			case 'cv':
				$result=resultToArray($this->Alumno_model->all($id))[0];
				$pathFile=CC_BASE_PATH."/files/cvs/".$result["documento"].".pdf";
				
				$idNameAndRegist=$result["id_alumno"];
				break;
			case 'dj':
				$result=resultToArray($this->Alumno_model->all($id))[0];
				$pathFile=CC_BASE_PATH."/files/djs/".$result["documento"].".pdf";
				
				$idNameAndRegist=$result["id_alumno"];
				break;
			case 'dni':
				$result=resultToArray($this->Alumno_model->all($id))[0];
				$pathFile=CC_BASE_PATH."/files/dni/".$result["documento"].".pdf";
				
				$idNameAndRegist=$result["id_alumno"];
				break;
			case 'bach':
				$result=resultToArray($this->Alumno_model->all($id))[0];
				$pathFile=CC_BASE_PATH."/files/bachiller/".$result["documento"].".pdf";
				
				$idNameAndRegist=$result["id_alumno"];
				break;
			case 'maes':
				$result=resultToArray($this->Alumno_model->all($id))[0];
				$pathFile=CC_BASE_PATH."/files/maestria/".$result["documento"].".pdf";
				
				$idNameAndRegist=$result["id_alumno"];
				break;
			case 'doct':
				$result=resultToArray($this->Alumno_model->all($id))[0];
				$pathFile=CC_BASE_PATH."/files/doctorado/".$result["documento"].".pdf";
				
				$idNameAndRegist=$result["id_alumno"];
				break;
			case 'sins':
				$result=resultToArray($this->Alumno_model->all($id))[0];
				$pathFile=CC_BASE_PATH."/files/sInscripcion/".$result["documento"].".pdf";
				
				$idNameAndRegist=$result["id_alumno"];
				break;
			case 'hdatos':
				$pathFile=CC_BASE_PATH."/files/hojadatos/".$id.".pdf";
				$result=$this->Solicitud_model->getAllColumnsById($id);
				$idNameAndRegist=$result["idSolicitud"];
				break;
			case 'solad':
				$pathFile=CC_BASE_PATH."/files/sol-ad/".$id.".pdf";
				$result=$this->Solicitud_model->getAllColumnsById($id);
				$idNameAndRegist=$result["idSolicitud"];
				break;
			case 'pinvs':
				$pathFile=CC_BASE_PATH."/files/proinves/".$id.".pdf";
				$result=$this->Solicitud_model->getAllColumnsById($id);
				$idNameAndRegist=$result["idSolicitud"];
				break;
			default:
				$pathFile="";
				show_404();
				die();
				break;
		}

		if($this->nativesession->get('tipo')=='admin'){
			
			if((($pathFile!=""))&&(file_exists($pathFile))){
				
				$data=base64_encode(file_get_contents($pathFile,true));
				$this->load->view("pdf/viewpdf",array('data'=>$data,'id'=>$idNameAndRegist,'typeFile'=>$segmentOfTypeFile));///Load view pdf of only watch
			}else{
				show_404();
			}
		}elseif($this->nativesession->get('tipo')=='alumno'){
			$this->load->model('User_model');
			$usuario=$this->User_model->buscarUsuario($this->nativesession->get('idUsuario'))[0];
			$alumno=resultToArray($this->Alumno_model->all($usuario["alumno"]))[0];
			if($alumno["documento"]==$this->nativesession->get('dni')){
				if((!($pathFile==""))&&(file_exists($pathFile))){
					$data=base64_encode(file_get_contents($pathFile,true));
					$this->load->view("pdf/onlyviewpdf",array('data'=>$data));///Load view pdf for admin marks
				}else{
					show_404();
				}
			}
		}else{
			show_404();
		}
	}
	
	function mark_file_good($id_alumno){

	}

	public function get_fileSolicitud_view_as_data(){
		$segmentOfTypeFile=$this->uri->segment(4);
		//$segmentOfNumberDni=$this->uri->segment(5);
		$id=$this->uri->segment(5);
		$data="";
		$pathFile="";

		switch ($segmentOfTypeFile) {
			case 'hdatos':
				$pathFile=CC_BASE_PATH."/files/hojadatos/".$id.".pdf";
				break;
			case 'solad':
				$pathFile=CC_BASE_PATH."/files/sol-ad/".$id.".pdf";
				break;
			case 'pinvs':
				$pathFile=CC_BASE_PATH."/files/proinves/".$id.".pdf";
				break;
			default:
				$pathFile="";
				show_404();
				die();
				break;
		}

		if($this->nativesession->get('tipo')=='admin'){
				show_404();
		}elseif($this->nativesession->get('tipo')=='alumno'){
			if($this->Solicitud_model->existByIdAndAlumno($id,$this->nativesession->get('idAlumno'))){
				if((!($pathFile==""))&&(file_exists($pathFile))){
					$data=base64_encode(file_get_contents($pathFile,true));
					$this->load->view("pdf/onlyviewpdf",array('data'=>$data));///Load view pdf for admin marks
				}else{
					show_404();
				}
			}
		}else{
			show_404();
		}
		
	}

	public function info($fileName){
		$this->load->model('Alumno_model'); 
		$alumno=$this->Alumno_model->findById($this->nativesession->get('idAlumno'))[0];
		$deletable=false;
		
		$resultModel;
		$resultModel["name"]=NULL;
		$resultModel["urlDeleting"]="#";
		$resultModel["removable"]=false;
		$resultModel["properties"]=[];
		$resultModel["identifier"]=[];

		switch ($fileName) {
			case 'cv':
				$pathFile=CC_BASE_PATH."/files/cvs/".$alumno["documento"].".pdf";
				
				$resultModel["name"]=$this->nativesession->get('idAlumno');
				$resultModel["urlDeleting"]="/file/delete/$fileName/".$alumno["documento"];
				//$resultModel["removable"]=$alumno["check_cv_pdf"];
				$resultModel["removable"]=((!($alumno["check_cv_pdf"]))&&(file_exists($pathFile)));
				$resultModel["properties"]=[];
				$resultModel["identifier"]='cv';
				$resultModel["id"]=$alumno["documento"];
				break;
			case 'dj':
				$pathFile=CC_BASE_PATH."/files/djs/".$alumno["documento"].".pdf";
				
				$resultModel["name"]=$this->nativesession->get('idAlumno');
				$resultModel["urlDeleting"]="/file/delete/$fileName/".$alumno["documento"];
				$resultModel["removable"]=((!($alumno["check_dj_pdf"]))&&(file_exists($pathFile)));
				$resultModel["properties"]=[];
				$resultModel["identifier"]='dj';
				$resultModel["id"]=$alumno["documento"];
				break;
			case 'dni':
				$pathFile=CC_BASE_PATH."/files/dni/".$alumno["documento"].".pdf";
				
				$resultModel["name"]=$this->nativesession->get('idAlumno');
				$resultModel["urlDeleting"]="/file/delete/$fileName/".$alumno["documento"];
				$resultModel["removable"]=((!($alumno["check_dni_pdf"]))&&(file_exists($pathFile)));
				$resultModel["properties"]=[];
				$resultModel["identifier"]='dni';
				$resultModel["id"]=$alumno["documento"];
				break;
			case 'bach':
				$pathFile=CC_BASE_PATH."/files/bachiller/".$alumno["documento"].".pdf";
				
				$resultModel["name"]=$this->nativesession->get('idAlumno');
				$resultModel["urlDeleting"]="/file/delete/$fileName/".$alumno["documento"];
				$resultModel["removable"]=((!($alumno["check_bach_pdf"]))&&(file_exists($pathFile)));
				$resultModel["properties"]=[];
				$resultModel["identifier"]='bach';
				$resultModel["id"]=$alumno["documento"];
				break;
			case 'maes':
				$pathFile=CC_BASE_PATH."/files/maestria/".$alumno["documento"].".pdf";
				
				$resultModel["name"]=$this->nativesession->get('idAlumno');
				$resultModel["urlDeleting"]="/file/delete/$fileName/".$alumno["documento"];
				$resultModel["removable"]=((!($alumno["check_maes_pdf"]))&&(file_exists($pathFile)));
				$resultModel["properties"]=[];
				$resultModel["identifier"]='maes';
				$resultModel["id"]=$alumno["documento"];
				break;
			case 'doct':
				$pathFile=CC_BASE_PATH."/files/doctorado/".$alumno["documento"].".pdf";
				
				$resultModel["name"]=$this->nativesession->get('idAlumno');
				$resultModel["urlDeleting"]="/file/delete/$fileName/".$alumno["documento"];
				$resultModel["removable"]=((!($alumno["check_doct_pdf"]))&&(file_exists($pathFile)));
				$resultModel["properties"]=[];
				$resultModel["identifier"]='doct';
				$resultModel["id"]=$alumno["documento"];
				break;
			case 'sins':
				$pathFile=CC_BASE_PATH."/files/sInscripcion/".$alumno["documento"].".pdf";
				
				$resultModel["name"]=$this->nativesession->get('idAlumno');
				$resultModel["urlDeleting"]="/file/delete/$fileName/".$alumno["documento"];
				$resultModel["removable"]=((!($alumno["check_sins_pdf"]))&&(file_exists($pathFile)));
				$resultModel["properties"]=[];
				$resultModel["identifier"]='sins';
				$resultModel["id"]=$alumno["documento"];
				break;
			case 'hdatos':
				$id=$this->input->post('id');
				$pathFile=CC_BASE_PATH."/files/hojadatos/".$id.".pdf";
				
				$resultModel["name"]=$this->nativesession->get('idAlumno');
				$resultModel["urlDeleting"]="/file/delete/$fileName/$id";
				$resultModel["removable"]=(file_exists($pathFile));
				$resultModel["properties"]=[""];
				$resultModel["identifier"]='hdatos';
				$resultModel["id"]=$id;
				break;
			case 'solad':
				$id=$this->input->post('id');
				$pathFile=CC_BASE_PATH."/files/sol-ad/".$id.".pdf";
				
				$resultModel["name"]=$this->nativesession->get('idAlumno');
				$resultModel["urlDeleting"]="/file/delete/$fileName/$id";
				$resultModel["removable"]=(file_exists($pathFile));
				$resultModel["properties"]=[""];
				$resultModel["identifier"]='solad';
				$resultModel["id"]=$id;
				break;
			case 'pinvs':
				$id=$this->input->post('id');
				$pathFile=CC_BASE_PATH."/files/proinves/".$id.".pdf";
				
				$resultModel["name"]=$this->nativesession->get('idAlumno');
				$resultModel["urlDeleting"]="/file/delete/$fileName/$id";
				$resultModel["removable"]=(file_exists($pathFile));
				$resultModel["properties"]=[""];
				$resultModel["identifier"]='pinvs';
				$resultModel["id"]=$id;
				break;
			default:
				$pathFile="";
				show_404();
				die();
				break;
		}
		echo json_encode($resultModel);
	}

public function eliminar($FileType,$id){
	$this->load->model('Alumno_model'); 
	$alumno=$this->Alumno_model->findById($this->nativesession->get('idAlumno'))[0];
	$pathFile;
	$resultModel;
	$resultModel["state"]=NULL;
	$resultModel["message"]=NULL;
	$nameFile="undefined";
	switch ($FileType) {
		case 'cv':
			$pathFile=CC_BASE_PATH."/files/cvs/".$alumno["documento"].".pdf";
			$nameFile=$alumno["documento"];
			break;
		case 'dj':
			$pathFile=CC_BASE_PATH."/files/djs/".$alumno["documento"].".pdf";
			$nameFile=$alumno["documento"];
			break;
		case 'dni':
			$pathFile=CC_BASE_PATH."/files/dni/".$alumno["documento"].".pdf";
			$nameFile=$alumno["documento"];
			break;
		case 'bach':
			$pathFile=CC_BASE_PATH."/files/bachiller/".$alumno["documento"].".pdf";
			$nameFile=$alumno["documento"];
			break;
		case 'maes':
			$pathFile=CC_BASE_PATH."/files/maestria/".$alumno["documento"].".pdf";
			$nameFile=$alumno["documento"];
			break;
		case 'doct':
			$pathFile=CC_BASE_PATH."/files/doctorado/".$alumno["documento"].".pdf";
			$nameFile=$alumno["documento"];
			break;
		case 'sins':
			$pathFile=CC_BASE_PATH."/files/sInscripcion/".$alumno["documento"].".pdf";
			$nameFile=$alumno["documento"];
			break;
		case 'hdatos':
			$pathFile=CC_BASE_PATH."/files/hojadatos/".$id.".pdf";
			$nameFile=$id;
			break;
		case 'solad':
			$pathFile=CC_BASE_PATH."/files/sol-ad/".$id.".pdf";
			$nameFile=$id;
			break;
		case 'pinvs':
			$pathFile=CC_BASE_PATH."/files/proinves/".$id.".pdf";
			$nameFile=$id;
			break;
		default:
			$pathFile=NULL;
			show_404();
			die();
			break;
	}
	if(rename($pathFile,CC_BASE_PATH."/trash/$nameFile"."_".$FileType."_".date('j-m-y').".pdf")){
		$resultModel["state"]=true;
		$resultModel["message"]="Borrado correctamente";
	}else{
		$resultModel["state"]=false;
		$resultModel["message"]="Error al borrar";
	}
	echo json_encode($resultModel);
}
function uploads_page(){
	$this->load->model('File_model');
	$tipo=$this->uri->segment(4);
	$id=$this->uri->segment(5);
	
	$existFile="";
	$minNameOfClass="";
	$obj;
	switch ($tipo) {
		case CurriculumFile::$min_name:
			$obj=new CurriculumFile();
			$minNameOfClass=CurriculumFile::$min_name;
			break;

		case DeclaracionJuradaFile::$min_name:
			$obj=new DeclaracionJuradaFile();
			$minNameOfClass=DeclaracionJuradaFile::$min_name;
			break;

		case DniFile::$min_name:
			$obj=new DniFile();
			$minNameOfClass=DniFile::$min_name;
			break;

		case BachillerFile::$min_name:
			$obj=new BachillerFile();
			$minNameOfClass=BachillerFile::$min_name;
			break;

		case MaestriaFile::$min_name:
			$obj=new MaestriaFile();
			$minNameOfClass=MaestriaFile::$min_name;
			break;
		case DoctoradoFile::$min_name:
			$obj=new DoctoradoFile();
			$minNameOfClass=DoctoradoFile::$min_name;
			break;
		case SolicitudFile::$min_name:
			$obj=new SolicitudFile();
			$minNameOfClass=SolicitudFile::$min_name;
			break;
		
		case ProyectoInvestigacionFile::$min_name:
			$obj=new ProyectoInvestigacionFile();
			$minNameOfClass=ProyectoInvestigacionFile::$min_name;
			break;

		case HojaDatosFile::$min_name:
			$obj=new HojaDatosFile();
			$minNameOfClass=HojaDatosFile::$min_name;
			break;
		
		default:
			show_404();
			exit;
			break;
		
	}

	$obj->id=$id;
	$data=array(
		'exist'=>file_exists($obj->completePath().'.pdf'),
		'id'=>$id,
		'min_name'=>$minNameOfClass,
	);

	$this->load->view('uploads_document',$data);
}

function recive_file(){
	$this->load->model('File_model');
	$id=$this->input->post('id');
	$type=$this->input->post('type');
	
	$obj=$this->makeObjectByType($type);
	$obj->id=$id;

	$config = array(
		'upload_path' => $obj->path(),
		'allowed_types' => "pdf",
		'overwrite' => TRUE,
		'max_size' => "20048000",
		'file_name' => $id
	);
	$this->load->library('upload', $config);
	$resultado["status"]=0;
	$this->upload->initialize($config);
	if($this->upload->do_upload('file'))
	{
		$resultado["status"]=1;
		$resultado["data"] = array('upload_data' => $this->makeObjectByType($type)->name());
	}else
	{
		$resultado["error"] = array('error' => $this->upload->display_errors());
	}
	echo json_encode($resultado);
}


private function makeObjectByType($type_string):BaseFile{
	$obj;
	switch ($type_string) {
		case CurriculumFile::$min_name:
			$obj=new CurriculumFile();
			break;

		case DeclaracionJuradaFile::$min_name:
			$obj=new DeclaracionJuradaFile();
			break;

		case DniFile::$min_name:
			$obj=new DniFile();
			break;

		case BachillerFile::$min_name:
			$obj=new BachillerFile();
			break;

		case MaestriaFile::$min_name:
			$obj=new MaestriaFile();
			break;
		case DoctoradoFile::$min_name:
			$obj=new DoctoradoFile();
			break;
		case SolicitudFile::$min_name:
			$obj=new SolicitudFile();
			break;
		
		case ProyectoInvestigacionFile::$min_name:
			$obj=new ProyectoInvestigacionFile();
			break;

		case HojaDatosFile::$min_name:
			$obj=new HojaDatosFile();
			break;
		
		default:
			show_404();
			exit;
			break;
		
	}
	return $obj;
}


}
