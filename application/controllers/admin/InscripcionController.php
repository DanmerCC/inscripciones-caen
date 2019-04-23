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
		$i=0;
		foreach ($rspta as $value) {
			$i++;
	
				$data[] = array(
				"0" => "<button class='btn btn-danger' onclick='ins.cancel(".$value["id_inscripcion"].");'><i class='fa fa-trash-o' aria-hidden='true'></i> Anular</button>",
				"1" => $value["nombres"],
				"2" => $value["apellido_paterno"]." ".$value["apellido_materno"],
				"3" => $value["numeracion"]." ".$value["tipo_curso"]." ".$value["nombre_curso"],
				"4" => $value["nombre_user"],
				"5" => $value["created"],
				"6" => ""
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
