<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ReportesController extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->library('Nativesession');
		$this->load->helper('url');
		$this->load->model('Reportes_model');
		$this->load->library('opciones');
        }
        
	

    public function index(){
    	$this->load->model('Permiso_model');
    	if ($this->nativesession->get('tipo')=='admin') {
			$identidad["rutaimagen"]="/dist/img/avatar5.png";
			$identidad["nombres"]=$this->nativesession->get('acceso');
			$opciones["rutaimagen"]=$identidad["rutaimagen"];
			$opciones["menu"]=$this->opciones->segun($this->Permiso_model->lista($this->nativesession->get('idUsuario')),'Reportes');
			$data['cosarara']=$this->Permiso_model->lista($this->nativesession->get('idUsuario'));
			$data['cabecera']=$this->load->view('adminlte/linksHead','',TRUE);
			$data['footer']=$this->load->view('adminlte/scriptsFooter','',TRUE);
			$data["mainSidebar"]=$this->load->view('adminlte/main-sideBar',$opciones,TRUE);
			$data['mainHeader']=$this->load->view('adminlte/mainHeader',array("identity"=>$identidad),TRUE);
			$data['canEst']=$this->Reportes_model->pruebacontar("persona");
			$data['cantDoc']=$this->Reportes_model->contDoct("persona");
			$data['cantMae']=$this->Reportes_model->cantMae("persona");
			$data['cantDiplo']=$this->Reportes_model->cantDiplo("persona");
			
			$this->load->view('dashboard_reportes',$data);

		
		}else
		{
			redirect('administracion/login');
		}

    }
    

	public function mostrar(){
		$data=array(			
			"cantEst"=>$this->Reportes_model->pruebacontar("persona"),
			"canDoc"=>$this->Reportes_model->contDoct("persona"),
			"canMae"=>$this->Reportes_model->cantMae("persona"),
			"canDiplo"=>$this->Reportes_model->cantDiplo("persona"),

		);
	}

    
}

