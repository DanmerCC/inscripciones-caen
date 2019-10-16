<?php
use SebastianBergmann\GlobalState\Exception;

defined('BASEPATH') OR exit('No direct script access allowed');

class InscripcionController extends CI_Controller {

	private $estado_finazas;
	private $usuario_actual;

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Nativesession');
		$this->load->helper('url');
		$this->load->model('Inscripcion_model');
		$this->load->model('Permiso_model');
		$this->load->model('Solicitud_model');
		$this->load->library('opciones');
		$this->load->model('EstadoFinanzas_model');
		$this->estado_finanzas=$this->EstadoFinanzas_model->all();
		$this->load->model('FinObservaciones_model');
		$this->usuario_actual=$this->nativesession->get('idUsuario');
		
	}

	/**
	 * @var 
	 */
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
			$data['estados_finanzas']=$this->estado_finanzas;
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
		$columns=$this->input->post('columns');
		$deletes=(boolean)($columns[8]["search"]["value"]==='true');
		$column_nine=$columns[9]["search"]["value"];
		$estados=($column_nine=="")?[]:explode(',',$column_nine);
		
		$this->load->model('Auth_Permisions');
		
		$can_edit_finanzas=$this->Auth_Permisions->can('change_inscripcion_estado_finanzas');
		$this->Inscripcion_model->global_stado_finanzas=$estados;

		if(strlen($search["value"])>0){
			
			$cantidad = $this->Inscripcion_model->get_count_and_filter($search["value"],$deletes);
			$rspta = $this->Inscripcion_model->get_page_and_filter($start,$length,$search["value"],$deletes);
			
		}else{
			
			$cantidad = $this->Inscripcion_model->get_count($deletes);
			$rspta = $this->Inscripcion_model->get_page($start,$length,$deletes);
		}
		$data = Array();
		$i=0;
		foreach ($rspta as $value) {
			$i++;
			$is_anulated=!isset($value["f_anulado"]);
				$data[] = array(
				"0" => 
				($is_anulated?"<button class='btn btn-danger' onclick='ins.cancel(".$value["id_inscripcion"].");'><i class='fa fa-trash-o' aria-hidden='true'></i> Anular</button>":"").
					($is_anulated?'<div class="btn btn-info" data-toggle="modal" data-target="#mdl_datos_inscritos" onclick="modalDataInscrito.loadData('.$value["idSolicitud"].');"><i class="fa fa-eye"></i></div>':'').
					($is_anulated?('<a href="'.base_url()."postulante/pdf/".$value["idSolicitud"].'" class="btn btn-success" target="_blank" onclick=""><i class="fa fa-print"></i></a>'):''),
				"1" => $value["nombres"],
				"2" => $value["apellido_paterno"]." ".$value["apellido_materno"],
				"3" => $value["numeracion"]." ".$value["tipo_curso"]." ".$value["nombre_curso"],
				"4" => $value["documento"],
				"5" => $value["email"],
				"6" => (isset($value["celular"])?$value["celular"]:" ")." - ".(isset($value["telefono_casa"])?$value["telefono_casa"]:" "),
				"7" => $value["created"],
				"8" => $can_edit_finanzas?$this->HTML_drop_down($value["id_inscripcion"],$value["estado_finanzas"]):$this->HTML_btn_default($value["estado_finanzas"]),
				"9" => $is_anulated?"<span class='label label-success'>Cargado</span>":"<span class='label label-danger'>Anulado</span>"
			);
		}
		$results = array(
			"sEcho" => $this->input->post('sEcho'), //Informacion para datatables
			"iTotalRecords" => $cantidad, //enviamos el total de registros al datatables
			"iTotalDisplayRecords" => $cantidad, //enviamos total de registros a visualizar
			"aaData" => $data,
			"query"=>$this->db->last_query()
		);
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


	public function changeEstadoFinanzas(){
		$id_inscripcion=$this->input->post('id');
		$id_estado=$this->input->post('estado_id');
		$comentario=$this->input->post('comentario');
		
		if(empty($id_inscripcion)||(empty($id_estado))){
			return show_error('Solicitud erronea faltan datos');
		}
		$result=$this->Inscripcion_model->setEstadoFinanzas($id_inscripcion,$id_estado);
		if($id_estado==$this->EstadoFinanzas_model->OBSERVADO){
			$result2=$this->FinObservaciones_model->create($id_inscripcion,$this->usuario_actual,$comentario);
		}
		if($result){
			$result=array(
				"content"=>"OK",
			);
			echo json_encode($result);
		}else{
			echo "No actualizado";
		}
	}

	private function HTML_drop_down($id,$text){
		$list="";

		$details_icon="<a class='btn btn-social-icon btn-instagram' onclick='load_details_state_finanzas(".$id.")'><i class='fa fa-commenting'></i></a>";
		
		for ($i=0; $i < count($this->estado_finanzas); $i++) {
			$nombre=$this->estado_finanzas[$i]['nombre'];
			$id_estado=$this->estado_finanzas[$i]['id'];
			$list=$list."<li onclick='ins.change_estado($id,$id_estado,".'"'.$nombre.'"'.")'><a href='#'>$nombre</a></li>";
		}
		return "<div class='input-group-btn'>
                  <button type='button' class='btn btn btn-default dropdown-toggle' data-toggle='dropdown' aria-expanded='false'>$text
                    <span class='fa fa-caret-down'></span></button>
                  <ul class='dropdown-menu'>
                    $list
				  </ul>".
				 ($details_icon). 
                "</div>";
	}

	private function HTML_btn_default($text){
		return "<button type='button' class='btn btn-default'>$text</button>";
	}

	private function estado_archivos_by_solicitud($solicitud_id){
		$solicitud=$this->Solicitud_model->getAllColumnsById($solicitud_id);
		$data=[];

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
		return $data;
	}

	private function estado_archivos_by_alumno($alumno_id){
		$this->load->model('Alumno_model');
		$alumno=$this->Alumno_model->findById($alumno_id)[0];
		$data=[];
		$data=$alumno;
		$data["documentosObject"]=[
			[
				"name"=>"curriculum",
				"identifier"=>"cv",
				"statechecked"=>(boolean)$alumno["check_cv_pdf"],
				"stateUpload"=>file_exists(CC_BASE_PATH."/files/cvs/".$alumno["documento"].".pdf"),
				"fileName"=>$alumno['documento']
			],
			[
				"name"=>"declaracion jurada",
				"identifier"=>"dj",
				"statechecked"=>(boolean)$alumno["check_dj_pdf"],
				"stateUpload"=>file_exists(CC_BASE_PATH."/files/djs/".$alumno["documento"].".pdf"),
				"fileName"=>$alumno['documento']
			],
			[
				"name"=>"dni",
				"identifier"=>"dni",
				"statechecked"=>(boolean)$alumno["check_dni_pdf"],
				"stateUpload"=>file_exists(CC_BASE_PATH."/files/dni/".$alumno["documento"].".pdf"),
				"fileName"=>$alumno['documento']
			],
			[
				"name"=>"bachiller",
				"identifier"=>"bach",
				"statechecked"=>(boolean)$alumno["check_bach_pdf"],
				"stateUpload"=>file_exists(CC_BASE_PATH."/files/bachiller/".$alumno["documento"].".pdf"),
				"fileName"=>$alumno['documento']
			],
			[
				"name"=>"maestria",
				"identifier"=>"maes",
				"statechecked"=>(boolean)$alumno["check_maes_pdf"],
				"stateUpload"=>file_exists(CC_BASE_PATH."/files/maestria/".$alumno["documento"].".pdf"),
				"fileName"=>$alumno['documento']
			],
			[
				"name"=>"Doctorado",
				"identifier"=>"doct",
				"statechecked"=>(boolean)$alumno["check_doct_pdf"],
				"stateUpload"=>file_exists(CC_BASE_PATH."/files/doctorado/".$alumno["documento"].".pdf"),
				"fileName"=>$alumno['documento']
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
		
		return $data;
	}


	public function get_estado_archivos($id){
		$solicitud=$this->estado_archivos_by_solicitud($id);
		$estado_archivos_solicitud=$this->estado_archivos_by_solicitud($solicitud['idSolicitud']);
		header("Content-type:application/json");
		echo json_encode([
			"content"=>[],
			"status"=>"OK",
			"result"=>($estado_archivos_solicitud)
				
		],JSON_UNESCAPED_UNICODE);
	}

	public function get_estado_archivos_solicitud_include_person_files($id){
		$solicitud=$this->Solicitud_model->getOrFail($id);
		$estado_archivos_solicitud=$this->estado_archivos_by_solicitud($solicitud['idSolicitud']);
		$estado_archivos_persona=$this->estado_archivos_by_alumno($solicitud['alumno']);
		header("Content-type:application/json");
		echo json_encode([
			"content"=>[],
			"status"=>"OK",
			"result"=>($estado_archivos_solicitud)
				
		],JSON_UNESCAPED_UNICODE);
	}

}
