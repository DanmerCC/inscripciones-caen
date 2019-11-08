<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 
/**
 * 
 */
class InformeController extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('Nativesession');
		$this->load->helper('url');
		$this->load->model('Informes_model');
		$this->load->library('opciones');
	}
	public function dataTable(){
        $rspta = $this->Informes_model->all();
        //vamos a declarar un array
        $data = Array();
        header("Content-type: application/json");
        $i=0;
        foreach ($rspta as $value) {
                $data[] = array(
                "0" => $i+1,   
                "1" => $value["nombres_apellidos"],
                "2" => $value["email"],
                "3" => $value["celular"],
                "4" => $value["centro_laboral"],
                "5" => $value["consulta"],
                "6" => $value["programa"],
                "7" => $value["fecha_consulta"],
                "8" => ($value["condicion"]=="0")?"<button class='btn btn-alert' title='click para marcar como verificado' onclick='marcarInfo(".$value["id_persona"].")'><i class='fa fa-thumb-tack' aria-hidden='true'></i></button>":"<button class='btn btn-primary' title='click para marcar como no verificado' onclick='quitarmarcaInfo(".$value["id_persona"].")'><i class='fa fa-thumb-tack' aria-hidden='true'></i></button>"
            );
            $i++;
         }        
        $results = array(
            "sEcho" => 1, //Informacion para datatables
            "iTotalRecords" => count($data), //enviamos el total de registros al datatables
            "iTotalDisplayRecords" => count($data), //enviamos total de registros a visualizar
            "aaData" => $data);
        echo json_encode($results);
    }

    public function index(){
    	$this->load->model('Permiso_model');
    	if ($this->nativesession->get('tipo')=='admin') {
			$identidad["rutaimagen"]="/dist/img/avatar5.png";
			$identidad["nombres"]=$this->nativesession->get('acceso');
			$opciones["rutaimagen"]=$identidad["rutaimagen"];
			$opciones["menu"]=$this->opciones->segun($this->Permiso_model->lista($this->nativesession->get('idUsuario')),'Interesados');
			
			$data['cabecera']=$this->load->view('adminlte/linksHead','',TRUE);
			$data['footer']=$this->load->view('adminlte/scriptsFooter','',TRUE);
			$data["mainSidebar"]=$this->load->view('adminlte/main-sideBar',$opciones,TRUE);
			$data['mainHeader']=$this->load->view('adminlte/mainHeader',array("identity"=>$identidad),TRUE);
			$this->load->view('dashboard_informes',$data);
		}else
		{
			redirect('administracion/login');
		}

    }
    
        public function marcaInfo(){
                $id_solicitud=$this->input->post('id');
                $resultado=$this->Informes_model->marcarInfo($id_solicitud);
                echo $this->input->post('id');
        }

        public function quitarMarcaInfo(){
                $id_solicitud=$this->input->post('id');
                $resultado=$this->Informes_model->quitarMarcaInfo($id_solicitud);
                echo $this->input->post('id');
        }
    
    
}
