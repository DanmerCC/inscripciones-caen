<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 
/**
 * 
 */
class EntrevistaController extends MY_Controller
{
	
	function __construct()
	{
        parent::__construct();
        $this->load->model('InterviewProgramed_model');
        $this->load->model('StateInterviewProgramed_model');
        $this->load->model('Permiso_model');
		$this->load->library('NativeSession');
		$this->load->library('opciones');
    }

	public function index(){
		$identidad["rutaimagen"]="/dist/img/avatar5.png";
		$identidad["nombres"]=$this->nativesession->get('acceso');
		$opciones["rutaimagen"]=$identidad["rutaimagen"];
		$opciones["menu"]=$this->opciones->segun($this->Permiso_model->lista($this->nativesession->get('idUsuario')),'Entrevistas');

		$data['cabecera']=$this->load->view('adminlte/linksHead','',TRUE);
		$data['footer']=$this->load->view('adminlte/scriptsFooter','',TRUE);
		$data["mainSidebar"]=$this->load->view('adminlte/main-sideBar',$opciones,TRUE);
		$data['mainHeader']=$this->load->view('adminlte/mainHeader',array("identity"=>$identidad),TRUE);
		$this->load->view('dashboard_entrevistas',$data);
	}

    /***
     * 
     */
	function byInscripcion($idInscripcion){
		$tempEntrevista=$this->InterviewProgramed_model->getByInscripcion($idInscripcion);
		$entrevista=null;
		if($tempEntrevista!=null){
			$tempEntrevista["estado"]=$this->StateInterviewProgramed_model->loadFromMemoryById($tempEntrevista["estado_id"]);
			$entrevista=$tempEntrevista;
		}else{
			$entrevista=new stdClass;
		}
		$this->response($entrevista);
	}

	function create(){
		$id_inscripcion_id=$this->input->post('id_inscripcion');
		$fecha_programado=$this->input->post('fecha_programado');
		
		$correct=$this->InterviewProgramed_model->create($id_inscripcion_id,$fecha_programado);
		if($correct){
			$id=$this->db->insert_id();
			$entrevista=$this->InterviewProgramed_model->getByInscripcion($id_inscripcion_id);
			$data=$entrevista;
		}else{
			$data=new stdClass;
		}
		$resultado=[
			"status"=>$correct?'OK':'ERROR',
			"data"=>$data
		];
		$this->response($resultado);
	}

	function list(){
		
		$this->response($this->InterviewProgramed_model->getAll());
	}

	function changeDate(){
		$idEntrevista=$this->input->post('id_entrevista');
		$fecha_programado=$this->input->post('fecha_programado');
		
		$success=$this->InterviewProgramed_model->changeDate($idEntrevista,$fecha_programado);
		if($success){
			$this->response("OK");
		}else{
			$this->response(NULL,500);
		}
	}

	function getBuildable(){
		$filter_programa_id=$this->input->get('filter_programa_id');
		$buildables=$this->InterviewProgramed_model->getBuildables($filter_programa_id);
		
		$this->response($buildables);
	}


	function delete(){
		$id=$this->input->post('id_inscripcion');
		$success=$this->InterviewProgramed_model->delete($id);
		$this->structuredResponse($success);
	}

	function getFullDatails($id){
		$this->load->model('Inscripcion_model');
		$this->load->model('Solicitud_model');
		$this->load->model('Programa_model');
		$entrevista=$this->InterviewProgramed_model->get($id);
		$inscripcion=$this->Inscripcion_model->getOneOrFail($entrevista['inscripcion_id']);
		$solicitud=$this->Solicitud_model->getOrFail($inscripcion['solicitud_id']);
		$programa=$this->Programa_model->getOneOrFail($solicitud['programa']);

		$solicitud["programa"]=$programa;
		$inscripcion["solicitud"]=$solicitud;
		$entrevista["inscripcion"]=$inscripcion;
		$structure=$entrevista;
		$this->structuredResponse($structure);
	}

	function update(){
		$entrevista_id=$this->input->post('entrevista_id');
		$estado_id=$this->input->post('estado_id');
		$success=$this->InterviewProgramed_model->update($entrevista_id,$estado_id);
		if($success){
			return $this->structuredResponse($success);
		}else{
			return $this->structuredResponse("Error",500);
		}
	}
}
