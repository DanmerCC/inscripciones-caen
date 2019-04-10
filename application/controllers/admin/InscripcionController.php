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
		$this->load->model('Solicitud_model');
		$rows_afected=$this->Solicitud_model->set_sent_date($idSolicitud);
		
		if($rows_afected!=1){
			show_error("Error al establecer como inscrito");
			die();
		}
		if(empty($idSolicitud)){
			show_error("Error en la espera de un registro");
			die();
		}
		if($this->nativesession->get('tipo')!='admin'){
			show_error("No tiene permisos necesarios");
			die();
		}
		$data["result"]=true;
		$data["status"]="";

		if($this->Inscripcion_model->create($idSolicitud,$this->nativesession->get('idUsuario'))){
			header('Content-Type: application/json');
			$data["result"]=true;
			$data["status"]="200";
		}else{
			$data["result"]=false;
			$data["status"]="500";
		}
		echo json_encode($data);
		
	}

	public function delete($idInscripcion){
		$this->Inscripcion_model->delete($idInscripcion);
		
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
		$data=Array();
		$i=0;
		foreach ($rspta as $value) {
			$i++;
	
				$data[] = array(
				"0" => "$i",
				"1" => $value["nombres"],
				"2" => $value["apellido_paterno"]." ".$value["apellido_materno"],
				"3" => $value["nombre_curso"],
				"4" => "",
				"5" => ""
			);
		}
		$results = array(
			"sEcho" => $this->input->post('sEcho'), //Informacion para datatables
			"iTotalRecords" => $cantidad, //enviamos el total de registros al datatables
			"iTotalDisplayRecords" => $cantidad, //enviamos total de registros a visualizar
			"aaData" => $data);
		echo json_encode($results);
	}

	
}