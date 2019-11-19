<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class EvaluacionesController extends MY_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->library('Nativesession');
		$this->load->library('Mihelper');
		$this->load->library('opciones');
		$this->load->helper('url');
		$this->load->model('Evaluacion_model');
		$this->load->model('Permiso_model');
		$this->load->model('Evaluacion_model');
	}

	function index(){
	if ($this->nativesession->get('tipo')=='admin') {
			$identidad["rutaimagen"]="/dist/img/avatar5.png";
			$identidad["nombres"]=$this->nativesession->get('acceso');
			$opciones["rutaimagen"]=$identidad["rutaimagen"];
			$opciones["menu"]=$this->opciones->segun($this->Permiso_model->lista($this->nativesession->get('idUsuario')),'Evaluaciones');
			$data['cabecera']=$this->load->view('adminlte/linksHead','',TRUE);
			$data['footer']=$this->load->view('adminlte/scriptsFooter','',TRUE);
			$data["mainSidebar"]=$this->load->view('adminlte/main-sideBar',$opciones,TRUE);
			$data['mainHeader']=$this->load->view('adminlte/mainHeader',array("identity"=>$identidad),TRUE);
			$this->load->view('dashboard_evaluaciones',$data);
		}else
		{
			redirect('administracion/login');
		}
	}
	public function datatable(){
		$search=$this->input->post("search[]");
		$start=$this->input->post('start');
		$length=$this->input->post('length');
		$columns=$this->input->post('columns[]');
		$programa_id=($columns[3]["search"]["value"]!='')?$columns[3]["search"]["value"]:null;
		
		$this->Evaluacion_model->programa_id_global_filter=$programa_id;
		$activeSearch=!(strlen($search["value"])==0);
		
		if(strlen($search["value"])>0){
			$rspta = $this->Evaluacion_model->getAllEvaluacionesAndFindTextPage($start,$length,$search["value"]);
		}else{
			$rspta = $this->Evaluacion_model->getAllEvaluaccionesPage($start,$length);
		}
		$query=$this->db->last_query();
		$cantidad=$this->Evaluacion_model->count();
	   //vamos a declarar un array
	   $data = Array();
	   $i=$start;


	   foreach ($rspta as $value) {
		$i++;
		$nombresApellidos=array('nombres'=>$value["nombres"],'apellidos'=>$value["apellido_paterno"].' '.$value["apellido_materno"]);
	           $data[] = array(
					"0" => $activeSearch?"-":(($cantidad-$i)+1),
					"1" => $value["grado_profesion"],
					"2" => $nombresApellidos,
					"3" => $value["nombre"],
					"4" => $value["created"]
				);
	    }        
	   $results = array(
	       "sEcho" => $this->input->post('sEcho'), //Informacion para datatables
	       "iTotalRecords" => $cantidad, //enviamos el total de registros al datatables
	       "iTotalDisplayRecords" => $cantidad, //enviamos total de registros a visualizar
		   "aaData" => $data,
		   "qry"=>$query
		);
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

	public function guardar(){
		
		$this->config->load('file', TRUE);
		$id_inscripcion=$this->input->post('id_inscripcion');

		if($this->hasEvaluacionByIdInscripcion($id_inscripcion)){
			$this->structuredResponse('Ya existe una evaluacion',400);
		}

		if($this->Evaluacion_model->create($id_inscripcion)){
			$config['upload_path']          = $this->config->item('base_uploads_path','file').'/files/eval/';
			$config['allowed_types']        = 'pdf';
			$config['max_size']             = 4048;
			$config['max_width']            = 1024;
			$config['max_height']           = 768;
			$config['file_name']           = $id_inscripcion;

			$this->load->library('upload', $config);

			if (!$this->upload->do_upload('file_evaluacion'))
			{
				$error = array('error' => $this->upload->display_errors());

				$this->structuredResponse($error,500);
			}
			else
			{
				$data = array('upload_data' => $this->upload->data());
				$this->structuredResponse($data);
			}
		}else{
			$this->structuredResponse("ERROR",500);
		}

		
	}


	private function hasEvaluacionByIdInscripcion($id_inscripcion){
		return $this->Evaluacion_model->countByInscripcion($id_inscripcion)>=1;
	}

	/**End class */
	
}
