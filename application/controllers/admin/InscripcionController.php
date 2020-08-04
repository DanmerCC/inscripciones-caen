<?php
use SebastianBergmann\GlobalState\Exception;

defined('BASEPATH') OR exit('No direct script access allowed');



class InscripcionController extends MY_Controller {

	private $estado_finanzas;
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
		$this->load->model('FinanzasAuthorization_model');
		$this->load->model('EstadoFinanzasSolicitud_model');
		$this->load->model('FinanzasTipoAuthorization_model');
		$this->load->model('User_model');
		$this->usuario_actual=$this->nativesession->get('idUsuario');
		$this->load->model('EstadoAdmisionInscripcion_model');
        $this->load->model('StateInterviewProgramed_model');
        $this->load->model('Auth_Permisions');
		
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
			$data['estados_admision']=$this->EstadoAdmisionInscripcion_model->all();
			$data['can_change_to_admision']=$this->Auth_Permisions->can('change_inscription_to_admision');

			$this->load->view('dashboard_inscritos',$data);
		}else
		{
			redirect('administracion/login');
		}
	}

	public function dowloadFilter()
	{
		$this->load->helper('Report');
		
		$value=$this->input->get("search");
		$deletes=(boolean)($this->input->get('anulado')==='true');
		$column_nine=$this->input->get('estados');
		$estados=($column_nine=="")?[]:explode(',',$column_nine);
		$this->load->model('Auth_Permisions');

		$this->Inscripcion_model->global_stado_finanzas=$estados;

		if(strlen($value)>0){
			$rspta = $this->Inscripcion_model->get_all_to_export_and_filter($value,$deletes);
		}else{
			$rspta = $this->Inscripcion_model->get_all_to_export($deletes);
		}
		$cuerpo = array();
		foreach ($rspta as $key => $item) {
			$cuerpo[] = array(
				($key+1),
				$item['nombres'],
				$item['apellido_paterno']." ".$item['apellido_materno'],
				$item['documento'],
				$item['fecha_nac'],
				$item['distrito_nac'],
				$item['provincia'],
				$item['email'],
				$item['celular']."-".$item['telefono_casa'],
				$item['nombre_user'],
				$item['numeracion']." ".$item['tipo_curso']." ".$item['nombre_curso'],
				$item['grado_profesion'],
				$item['estado_civil'],
				$item['created'],
			);
		}
		$headers = ["N°","NOMBRES","APELLIDOS","DOCUMENTO","NACIMIENTO","DIST NAC","PROVINCIA","CORREO","TELEFONOS","USUARIO","PROGRAMAS","GRADO PROFESION","ESTADO CIVIL","FECHA DE REGISTRO"];

		process_and_export_excel($headers,$cuerpo);
		
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
		$solicitud=$this->Solicitud_model->getOrFail($idSolicitud);
		/*
		if($solicitud["estado_finanzas_id"]==$this->EstadoFinanzasSolicitud_model->VALIDADO){
			
		}*/
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

		$value_estados_admision=$columns[10]["search"]["value"];
		$filters_values_estados_admision=($value_estados_admision=="")?[]:explode(',',$value_estados_admision);
		$this->load->model('Auth_Permisions');
		
		$can_edit_finanzas=$this->Auth_Permisions->can('change_inscripcion_estado_finanzas');
		
		$this->Inscripcion_model->global_stado_finanzas=$estados;
		$this->Inscripcion_model->filter_estado_admision_ids=$filters_values_estados_admision;

		if(strlen($search["value"])>0){
			
			$cantidad = $this->Inscripcion_model->get_count_and_filter($search["value"],$deletes);
			$rspta = $this->Inscripcion_model->get_page_and_filter($start,$length,$search["value"],$deletes);
			
		}else{
			
			$cantidad = $this->Inscripcion_model->get_count($deletes);
			$rspta = $this->Inscripcion_model->get_page($start,$length,$deletes);
		}
		$query=$this->db->last_query();
		$data = Array();
		$i=0;
		foreach ($rspta as $value) {
			$i++;
			$is_anulated=!isset($value["f_anulado"]);
				$data[] = array(
				"0"=>json_encode($value),
				"1" => $this->innerInscripcionOptionsComponet($value,$is_anulated),
				"2" => $value["nombres"],
				"3" => $value["apellido_paterno"]." ".$value["apellido_materno"],
				"4" => $value["numeracion"]." ".$value["tipo_curso"]." ".$value["nombre_curso"],
				"5" => $value["documento"],
				"6" => $value["email"],
				"7" => (isset($value["celular"])?$value["celular"]:" ")." - ".(isset($value["telefono_casa"])?$value["telefono_casa"]:" "),
				"8" => $value["created"],
				"9" => "<div class='input-group-btn'>".
							($can_edit_finanzas?
											
												$this->HTML_drop_down_estado_finanzas(
													$value["id_inscripcion"],
													$value["estado_finanzas"],
													$value["estado_finanzas_id"],
													$value["apellido_paterno"]." ".$value["apellido_materno"]." ".$value["nombres"]
												):
												$this->HTML_btn_default($value["estado_finanzas"],$value["estado_finanzas_id"])
							).
							$this->HTML_details_icon($value["id_inscripcion"],$value["estado_finanzas_id"]).
						"</div>",
				"10" => $is_anulated?"<span class='label label-success'>Cargado</span>":"<span class='label label-danger'>Anulado</span>",
				"11" => array("id"=>$value["estado_admisions_id"],"nombre"=>$value["nombre_estado_admision"]),
				"12"=>$this->StateInterviewProgramed_model->loadFromMemoryById($value["state_interview_id"])
			);
		}
		$results = array(
			"sEcho" => $this->input->post('sEcho'), //Informacion para datatables
			"iTotalRecords" => $cantidad, //enviamos el total de registros al datatables
			"iTotalDisplayRecords" => $cantidad, //enviamos total de registros a visualizar
			"aaData" => $data,
			"query"=>":)"
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
                "stateUpload"=>file_exists(CC_BASE_PATH."/files/proinves/".$solicitud["idSolicitud"].".pdf"),
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
		
		$result_autorizacion=false;
		if($id_estado==$this->EstadoFinanzas_model->AUTORIZADO){
			$tipo=$this->input->post('tipo_id');
			$result_autorizacion=$this->FinanzasAuthorization_model->create($this->usuario_actual,$id_inscripcion,$tipo,$comentario);
		}

		if($result || $result_autorizacion){
			$result=array(
				"content"=>"OK",
			);
			echo json_encode($result);
		}else{
			echo "No actualizado";
		}
	}

	private function HTML_drop_down_estado_finanzas($id,$text,$estado_finanzas_id=null,$descripcion,$other_html_elelemt=''){
		$list="";
		$is_obserbated=false;
		if($estado_finanzas_id!=null){
			$is_obserbated=($this->EstadoFinanzas_model->OBSERVADO!=$estado_finanzas_id);
		}
		$disabled_html=$is_obserbated?' disabled '."onclick='' ":" onclick='load_details_state_finanzas(".$id.")' ";
		$details_icon="<a class='btn btn-social-icon btn-instagram' $disabled_html ><i class='fa fa-fw fa-info-circle'></i></a>";
		
		for ($i=0; $i < count($this->estado_finanzas); $i++) {
			$isgreen=$this->estado_finanzas[$i]['id']==$this->EstadoFinanzas_model->AUTORIZADO;
			$if_is_green_class=$isgreen?' text-green ':'';
			$nombre=$this->estado_finanzas[$i]['nombre'];
			$id_estado=$this->estado_finanzas[$i]['id'];
			$list=$list."<li  onclick='ins.change_estado($id,$id_estado,".'"'.$nombre.'",'.'"'.$descripcion.'"'.")'><a class='$if_is_green_class' href='#'>$nombre</a></li>";
		}

		$btn_is_green=$estado_finanzas_id==$this->EstadoFinanzas_model->AUTORIZADO;
		$if_validate_class=$btn_is_green?' text-green ':'';
		return "
				  <button type='button' class='btn btn btn-default dropdown-toggle $if_validate_class' data-toggle='dropdown' aria-expanded='false'>
				  $text
                    <span class='fa fa-caret-down'></span></button>
                  <ul class='dropdown-menu'>
                    $list
				  </ul>".
				 ($other_html_elelemt). 
                "";
	}

	/**
	 * @var array options
	 */
	private function HTML_drop_down_opciones($options=[],$default_option,$gray=false){
		$optionConcat="";
		for ($i=0; $i < count($options) ; $i++) { 
			$optionConcat.="<li>".$options[$i]."</li>";
		}
		return "<div class='btn-group'>
		<button type='button' class='btn btn-default'>
			$default_option
		</button>
		<button type='button' class='btn btn-default dropdown-toggle' data-toggle='dropdown' aria-expanded='false'>
		  <span class='caret'></span>
		  <span class='sr-only'>Toggle Dropdown</span>
		</button>
		<ul class='dropdown-menu ".($gray?'bg-gray':'')."' role='menu'>
		  ".((count($options)>0)?$optionConcat:'')."
		</ul>
	  </div>";
	}

	public function innerInscripcionOptionsComponet($inscripcion,$is_anulated){
		$optionsToContainer=[
			($is_anulated?"<button class='btn btn-danger' onclick='ins.cancel(".$inscripcion["id_inscripcion"].");'><i class='fa fa-trash-o' aria-hidden='true'></i> Anular</button>":""),
			($is_anulated?('<button class="btn "><a href="'.base_url()."postulante/pdf/".$inscripcion["idSolicitud"].'" class="btn btn-success" target="_blank" onclick=""><i class="fa fa-print"></i></a></button>'):''),
			($is_anulated?"<button class='btn btn-success' onclick='MDL_ENTREVISTAS_INSCRIPCION.open(".$inscripcion["id_inscripcion"].");'><i class='fa fa-fw fa-calendar-check-o' aria-hidden='true'></i> Entrevista</button>":"")
		];
		$detailsOption=($is_anulated?'<div onclick="modalDataInscrito.loadData('.$inscripcion["idSolicitud"].');"><i class="fa fa-eye"></i></div>':'');
		$optionsContainer=$this->HTML_drop_down_opciones($optionsToContainer,$detailsOption);
		return $optionsContainer;
		}

	private function HTML_details_icon($id_inscripcion,$estado_finanzas_id=null){
		$is_disableted=false;
		if($estado_finanzas_id!=null){
			$is_disableted=!(($this->EstadoFinanzas_model->OBSERVADO==$estado_finanzas_id)||($this->EstadoFinanzas_model->AUTORIZADO==$estado_finanzas_id));
		}
		$disabled_html=$is_disableted?' disabled '."onclick='' ":" onclick='load_details_state_finanzas(".$id_inscripcion.")' ";
		$details_icon="<a class='btn btn-social-icon btn-instagram' $disabled_html ><i class='fa fa-fw fa-info-circle'></i></a>";
		return $details_icon;
	}

	private function HTML_btn_default($text,$estado_id){
		$if_is_green_class='';
		if($estado_id!=null){
			if($estado_id==$this->EstadoFinanzas_model->AUTORIZADO){
				$if_is_green_class=' text-green ';
			}
		}
		
		return "<button type='button' style='cursor: default;' class='btn btn-default $if_is_green_class'>$text</button>";
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

	public function get_details($id_inscripcion){
		$inscripcion=$this->Inscripcion_model->find_by_id($id_inscripcion);
		if($inscripcion!=NULL){

			$ultima_observacion=$this->FinObservaciones_model->ultimo($id_inscripcion);
			$ultima_autorizacion=$this->FinanzasAuthorization_model->ultimo($id_inscripcion);

			if($ultima_autorizacion!=""){
				$author=$this->User_model->findOrFail($ultima_autorizacion["author_usuario_id"]);
				$tipo_autorizacion=$this->FinanzasTipoAuthorization_model->getOrFail($ultima_autorizacion['tipo_id']);
				$ultima_autorizacion["autor"]=$author;
				$ultima_autorizacion["tipo"]=$tipo_autorizacion;
			}
			$inscripcion["ultima_observacion"]=$ultima_observacion==""?new stdClass:$ultima_observacion;
			$inscripcion["ultima_autorizacion"]=$ultima_autorizacion==""?new stdClass:$ultima_autorizacion;
		}
		/*** */
		header('Content-Type: application/json');
		echo json_encode($inscripcion);
		exit;
	}

	function getEvaluables(){
		$search=$this->input->get('term');
		$evaluables=$this->Inscripcion_model->evaluables($search,5);
		$this->response($evaluables,200);
		
	}

}
