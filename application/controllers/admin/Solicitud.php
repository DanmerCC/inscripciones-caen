<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Solicitud extends CI_Controller
{
	private $usuario_actual;
	
	public function __construct()

	{
		parent::__construct();
		$this->load->library('Nativesession');
		$this->load->library('Mihelper');
		$this->load->helper('url');
		$this->load->model('Solicitud_model');
        $this->load->library('opciones');
        $this->load->library('Pdf');
		$this->load->model('Permiso_model');
		$this->load->helper('mihelper');
		$this->load->model('Notificacion_model');
		$this->load->model('EstadoFinanzasSolicitud_model');
		$this->load->model('FinObservacionesSolicitud_model');
		$this->estado_finanzas=$this->EstadoFinanzasSolicitud_model->all();
		$this->usuario_actual=$this->nativesession->get('idUsuario');
	}
    public function index(){
		
        if ($this->nativesession->get('tipo')=='admin') {
            $identidad["rutaimagen"]="/dist/img/avatar5.png";
            $identidad["nombres"]=$this->nativesession->get('acceso');
            $opciones["rutaimagen"]=$identidad["rutaimagen"];
            $opciones["menu"]=$this->opciones->segun($this->Permiso_model->lista($this->nativesession->get('idUsuario')),'Solicitudes');
            $data['cabecera']=$this->load->view('adminlte/linksHead','',TRUE);
            $data['footer']=$this->load->view('adminlte/scriptsFooter','',TRUE);
            $data["mainSidebar"]=$this->load->view('adminlte/main-sideBar',$opciones,TRUE);
			$data['mainHeader']=$this->load->view('adminlte/mainHeader',array("identity"=>$identidad),TRUE);
			$data['notificaciones']=$this->Notificacion_model->fromSolicitud(16);
			$data['estados_finanzas']=$this->estado_finanzasSolicitud;
			
            $this->load->view('dashboard_solicitud',$data);
        }else
        {
            redirect('administracion/login');
        }
    }

	public function pdf($id){
	$this->load->model('Alumno_model');
        $this->load->model('Solicitud_model');
        $alumno=$this->Alumno_model->all($this->nativesession->get("idAlumno"));

        $solicitud= null;
        /*Verificacion del tipo de session sin es admin le permitira cualquier recuperar cuaqluier ficha*/
        if($this->nativesession->get('tipo')=='admin'){
            $solicitud=$this->Solicitud_model->getFichaDataEspecifico($id);
        }else{
            $solicitud=$this->Solicitud_model->getFichaData($this->nativesession->get("idAlumno"),$id);
        }

        $data["datosAlumno"]=$solicitud;

        
        $pdf = new Pdf('P', 'mm', 'A4', false, 'UTF-8', false);
        //$pdf->SetAuthor('Author');
        $pdf->SetDisplayMode('real', 'default');
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $html = $this->load->view('pdf/ficha',$data,true);
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output('My-File-Name.pdf', 'I');
	}

    public function dataTable(){
        $search=$this->input->post("search[]");
		$start=$this->input->post('start');
		$length=$this->input->post('length');
        $activeSearch=((strlen($search["value"])!=0))||empty($search);
		$cantidad=$this->Solicitud_model->count_sent_less();
		$columns=$this->input->post('columns');
		$column_filtros=$columns[2]["search"]["value"];
		$estados=($column_filtros=="")?[]:explode(',',$column_filtros);
		$this->load->model('Auth_Permisions');
		
		$can_edit_finanzas_solicitud=$this->Auth_Permisions->can('change_solicitud_estado_finanzas');
		
		$this->Solicitud_model->global_stado_finanzas=$estados;

        if($activeSearch){
            $rspta = resultToArray($this->Solicitud_model->get_data_for_datatable($start,$length,$search["value"]));
        }else{
            $rspta = resultToArray($this->Solicitud_model->get_data_for_datatable($start,$length));
		}
        $data = Array();
		//echo var_dump($rspta);
		$solicitud_ids=c_extract($rspta,'idSolicitud');
		
		$notifications_by_solicituds=$this->Notificacion_model->notifications_id_by_solicituds($solicitud_ids);

		for ($i=0; $i < count($rspta); $i++) {
			$rspta[$i]['cuan_noti']=0;
			for ($e=0; $e < count($notifications_by_solicituds); $e++) { 
				if($rspta[$i]['idSolicitud']==$notifications_by_solicituds[$e]['idSolicitud']){
					$rspta[$i]['cuan_noti']=$notifications_by_solicituds[$e]['cant'];
				}
			}
		}
        $ii=$start;
        header("Content-type: application/json");
        for ($i=0;$i<count($rspta);$i++) {
			$ii++;
			$hasNotification=$rspta[$i]["notification_mensaje"]!=="";
			$hasPersonales=$rspta[$i]["cuan_noti"]>0;
                $data[$i] = array(
                "0" => $activeSearch?"-":(($cantidad-$ii)+1),
                "1" => '<a href="'.base_url()."postulante/pdf/".$rspta[$i]["idSolicitud"].'" class="btn btn-success" target="_blank" onclick=""><i class="fa fa-print"></i></a>'.
				' <div style="position:relative" class="btn btn-info '.($hasNotification || $hasPersonales?'beating-button':'').'" data-toggle="modal" data-target="#mdl_datos_alumno" onclick="modalDataAlumno.loadData('.$rspta[$i]["idSolicitud"].');"><i class="fa fa-eye"></i>'.
								
							'  '.($hasPersonales?'<span style="position:absolute;top:-5px;right:-10px;" class="label label-danger">'.$rspta[$i]["cuan_noti"].'</span>':'').'</div>'.
                            (
                                ($rspta[$i]["estado"]=='0')?
                                    ' <button class="btn btn-alert"   title="click para marcar como verificado" onclick="marcar('.$rspta[$i]["idSolicitud"].')"><i class="fa fa-square-o" aria-hidden="true"></i></button>':
                                    ' <button class="btn btn-primary" onclick="quitarmarca('.$rspta[$i]["idSolicitud"].')"><i class="fa fa-check-square-o" aria-hidden="true"></i></button>'
                            ).
                            ' <button class="btn btn-warning" onclick="request_bootbox('.
                                $rspta[$i]["idSolicitud"].
                            ');">'.
							'<i class="fa fa-user-plus" aria-hidden="true"></i></button>'
                            ,
                "2" => $rspta[$i]["nombres"],
                "3" => $rspta[$i]["apellido_paterno"],
                "4" => $rspta[$i]["apellido_materno"],
                "5" => $rspta[$i]["tipo_financiamiento"],
                "6" => $rspta[$i]["documento"],
				"7" => $rspta[$i]["curso_numeracion"]."".$rspta[$i]["nombretipoCurso"]." ".$rspta[$i]["curso_nombre"],
				"8" => "<div class='input-group-btn'>".
						($can_edit_finanzas_solicitud?	
							$this->HTML_drop_down(
								$rspta[$i]["idSolicitud"],
								$rspta[$i]["estado_finanzas"],
								$rspta[$i]["estado_finanzas_id"]
							):
							$this->HTML_btn_default($rspta[$i]["estado_finanzas"],$rspta[$i]["estado_finanzas_id"])
						).$this->HTML_details_icon($rspta[$i]["idSolicitud"],$rspta[$i]["estado_finanzas_id"])."</div>",

                "9" => (($rspta[$i]["marcaPago"]=='0')?' <button class="btn btn-alert"   title="click para marcar como verificado" onclick="marcarPago('.$rspta[$i]["idSolicitud"].')"><i class="fa fa-thumb-tack" aria-hidden="true"></i></button>':
                ' <button class="btn btn-warning" onclick="quitarmarcaPago('.$rspta[$i]["idSolicitud"].')"><i class="fa fa-thumb-tack" aria-hidden="true"></i></button>'),
                "10" => '<textarea class="form-control" onclick="editComent('.$rspta[$i]["idSolicitud"].');" readonly="readonly">'.$rspta[$i]["comentario"].'</textarea>',
                "11" => $rspta[$i]["fecha_registro"],
                "12" => ($rspta[$i]["estado"]=='0')?'<span class="label bg-red">Sin atender</span>':'<span class="label bg-green">Atendido</span>'
            );
         }    
        $results = array(
            "sEcho" =>$this->input->post('sEcho'), //Informacion para datatables
            "iTotalRecords" => $cantidad, //enviamos el total de registros al datatables
            "iTotalDisplayRecords" => ($activeSearch)?$this->Solicitud_model->count_with_filter($search["value"]):$cantidad, //enviamos total de registros a visualizar
            "aaData" => $data);
        echo json_encode($results);
	}

	private function HTML_details_icon($idSolicitud,$estado_finanzas_id=null){
		$is_obserbated=false;
		if($estado_finanzas_id!=null){
			$is_obserbated=($this->EstadoFinanzasSolicitud_model->OBSERVADO!=$estado_finanzas_id);
		}
		$disabled_html=$is_obserbated?' disabled '."onclick='' ":" onclick='load_details_state_finanzas_solicitud(".$idSolicitud.")' ";
		$details_icon="<a class='btn btn-social-icon btn-instagram' $disabled_html ><i class='fa fa-fw fa-info-circle'></i></a>";
		return $details_icon;
	}

	private function HTML_btn_default($text,$estado_finanzas_id){
		$is_validated=$this->EstadoFinanzasSolicitud_model->VALIDADO==$estado_finanzas_id;
		$class_if_is_validated=$is_validated?' text-green':'';

		return "<button type='button' style='cursor: default;' class='btn btn-default $class_if_is_validated'>$text</button>";
	}

	public function changeEstadoFinanzas(){
		$solicitudId=$this->input->post('id');
		$id_estado=$this->input->post('estado_id');
		$comentario=$this->input->post('comentario');
		
		if(empty($solicitudId)||(empty($id_estado))){
			return show_error('Solicitud erronea faltan datos');
		}
		$result=$this->Solicitud_model->setEstadoFinanzas($solicitudId,$id_estado);
		if($id_estado==$this->EstadoFinanzasSolicitud_model->OBSERVADO){
			$result2=$this->FinObservacionesSolicitud_model->create($solicitudId,$this->usuario_actual,$comentario);
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

	private function HTML_drop_down($id,$text,$estado_finanzas_id=null,$other_html_elelemt=''){
		$list="";
		$is_obserbated=false;
		if($estado_finanzas_id!=null){
			$is_obserbated=($this->EstadoFinanzasSolicitud_model->OBSERVADO!=$estado_finanzas_id);
		}
		$disabled_html=$is_obserbated?' disabled '."onclick='' ":" onclick='load_details_state_finanzas_solicitud(".$id.")' ";
		$details_icon="<a class='btn btn-social-icon btn-instagram' $disabled_html ><i class='fa fa-fw fa-info-circle'></i></a>";
		
		for ($i=0; $i < count($this->estado_finanzasSolicitud); $i++) {
			$is_green=$this->EstadoFinanzasSolicitud_model->VALIDADO==$this->estado_finanzasSolicitud[$i]['id'];
			$class_if_is_validado=$is_green?' text-green ':'';
			$nombre=$this->estado_finanzasSolicitud[$i]['nombre'];
			$id_estado=$this->estado_finanzasSolicitud[$i]['id'];
			$list=$list."<li onclick='sol.change_estado($id,$id_estado,".'"'.$nombre.'"'.")'><a class='$class_if_is_validado' href='#'>$nombre</a></li>";
		}
		$btn_is_green=$estado_finanzas_id==$this->EstadoFinanzasSolicitud_model->VALIDADO;
		$if_validate_class=$btn_is_green?' text-green ':'';
		return "
                  <button type='button' class='$if_validate_class btn btn btn-default dropdown-toggle' data-toggle='dropdown' aria-expanded='false'>$text
                    <span class='fa fa-caret-down'></span></button>
                  <ul class='dropdown-menu'>
                    $list
				  </ul>".
				 ($other_html_elelemt). 
                "";
	}

        public function dataTableAtendidas(){
        $rspta = $this->mihelper->resultToArray($this->Solicitud_model->atendidas());
        //vamos a declarar un array
        $data = Array();
        header("Content-type: application/json");
        $i=0;
        foreach ($rspta as $value) {
                    $data[] = array(
                    "0" => '<a href="'.base_url()."postulante/pdf/".$value["idSolicitud"].'" class="btn btn-success" target="_blank" onclick=""><i class="fa fa-print"></i></a>'.
                ' <button class="btn btn-primary" onclick="nuevaMatricula('.$value["idSolicitud"].')"><i class="fa fa-user-plus"></i></button>',
                "1" => $value["nombres"],
                "2" => $value["apellido_paterno"],
                "3" => $value["apellido_materno"],
                "4" => $value["tipo_financiamiento"],
                "5" => $value["documento"],
                "6" => $value["curso_numeracion"]." ".$value["curso_nombre"],
                "7" => $value["fecha_registro"],
                "8" => ($value["estado"]=='0')?'<span class="label bg-red">Sin atender</span>':'<span class="label bg-green">Atendido</span>'
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

        public function marcar(){
                $id_solicitud=$this->input->post('id');
                $resultado=$this->Solicitud_model->marcar($id_solicitud);
                echo $this->input->post('id');
        }

        public function quitarMarca(){
                $id_solicitud=$this->input->post('id');
                $resultado=$this->Solicitud_model->quitarMarca($id_solicitud);
                echo $this->input->post('id');
        }

///Marcas de pago

        public function marcarPago(){
                $id_solicitud=$this->input->post('id');
                $resultado=$this->Solicitud_model->marcarPago($id_solicitud);
                echo $this->input->post('id');
        }

        public function quitarMarcaPago(){
                $id_solicitud=$this->input->post('id');
                $resultado=$this->Solicitud_model->quitarMarcaPago($id_solicitud);
                echo $this->input->post('id');
        }

        public function get($id){
            header('Content-Type: application/json');
            $result=$this->mihelper->resultToArray($this->Solicitud_model->solicitud_porId($id));
            echo json_encode($result);
        }
        public function getComentario($id){
            header("Content-type: application/json");
            echo json_encode($this->Solicitud_model->getComentarioArray($id));
        }
        public function setComentario($id){
            header("Content-type: application/json");
            $comentario=$this->input->post('commet');
            echo json_encode($this->Solicitud_model->setComentarioArray($id,$comentario));
        }

	public function getResumenSolicitudById($id){
		$this->load->model('Alumno_model');
		
		$solicitud=$this->Solicitud_model->getAllColumnsById($id);
		$alumno=$this->Alumno_model->findById($solicitud['alumno'])[0];
		$this->Solicitud_model->reset_notification_status($id);
		$notificaciones = $this->Notificacion_model->fromSolicitud($id);
		$documentStatus = [1=>false,2=>false,3=>false,4=>false,5=>false,6=>false];
		foreach ($notificaciones as $key => $notificacion) {
			if(isset($documentStatus[$notificacion['action_id']])){
				$documentStatus[$notificacion['action_id']] = true;
			}
		}
		$data=[];
		$data=$alumno;
		$data["solicitudes"]=$this->Solicitud_model->countByAlumno($solicitud["alumno"]);
		$data["documentosObject"]=[
			[
				"name"=>"curriculum",
				"identifier"=>"cv",
				"statechecked"=>(boolean)$alumno["check_cv_pdf"],
				"stateUpload"=>file_exists(CC_BASE_PATH."/files/cvs/".$alumno["documento"].".pdf"),
				"fileName"=>$solicitud['alumno'],
				"notification"=>$documentStatus[1]
			],
			[
				"name"=>"declaracion jurada",
				"identifier"=>"dj",
				"statechecked"=>(boolean)$alumno["check_dj_pdf"],
				"stateUpload"=>file_exists(CC_BASE_PATH."/files/djs/".$alumno["documento"].".pdf"),
				"fileName"=>$solicitud['alumno'],
				"notification"=>$documentStatus[2]
			],
			[
				"name"=>"dni",
				"identifier"=>"dni",
				"statechecked"=>(boolean)$alumno["check_dni_pdf"],
				"stateUpload"=>file_exists(CC_BASE_PATH."/files/dni/".$alumno["documento"].".pdf"),
				"fileName"=>$solicitud['alumno'],
				"notification"=>$documentStatus[3]
			],
			[
				"name"=>"bachiller",
				"identifier"=>"bach",
				"statechecked"=>(boolean)$alumno["check_bach_pdf"],
				"stateUpload"=>file_exists(CC_BASE_PATH."/files/bachiller/".$alumno["documento"].".pdf"),
				"fileName"=>$solicitud['alumno'],
				"notification"=>$documentStatus[4]
			],
			[
				"name"=>"maestria",
				"identifier"=>"maes",
				"statechecked"=>(boolean)$alumno["check_maes_pdf"],
				"stateUpload"=>file_exists(CC_BASE_PATH."/files/maestria/".$alumno["documento"].".pdf"),
				"fileName"=>$solicitud['alumno'],
				"notification"=>$documentStatus[5]
			],
			[
				"name"=>"Doctorado",
				"identifier"=>"doct",
				"statechecked"=>(boolean)$alumno["check_doct_pdf"],
				"stateUpload"=>file_exists(CC_BASE_PATH."/files/doctorado/".$alumno["documento"].".pdf"),
				"fileName"=>$solicitud['alumno'],
				"notification"=>$documentStatus[6]
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


	public function test($id){
		$this->verify_login_or_fail();
		$this->load->model('Documentrender_model');
		$nuva_solicitud=new SolicitudDocument($id);
		$this->Documentrender_model->setType($nuva_solicitud);
		$this->Documentrender_model->loadDocument();
		
		/*
		$this->load->library('mergerpdf');
		$this->mergerpdf->addFile(CC_BASE_PATH."/PDF1.pdf");
		$this->mergerpdf->addFile(CC_BASE_PATH."/PDF2.pdf");
		$this->mergerpdf->setFileName("PDFCombinado.pdf");
		//header("Content-type:application/pdf");
		//header("Content-Disposition:attachment;filename=$this->name");
		$resultado= $this->mergerpdf->getMergedFiles();
		$que_paso=file_put_contents(CC_BASE_PATH."/completado.pdf",$resultado);
		echo $que_paso;
		*/
	}

	public function generarLegajo($idSolicitud){
		$this->load->model('Legajo_model');
		$solicitud=resultToArray($this->Solicitud_model->solicitud_porId($idSolicitud));
		//$this
		//$this->Legajo_model->insert();

	}

	public function generarLegajoPdf($documentos,$newFile){
		$this->load->library('mergerpdf');
		$this->mergerpdf->setFileName($newFile["nombre"]);
		for ($i=0; $i < count($documentos); $i++) { 
			$this->mergerpdf->addFile($documentos[i]->path);
		}

		$resultado= $this->mergerpdf->getMergedFiles();
		if(file_put_contents(CC_BASE_PATH."/".$this->mergerpdf->getFileName().".pdf",$resultado)===FALSE){
			$output["result"]="correcto";
			$output["content"]=array(
				"texto"=>"Documentos creado correctamente ".$this->mergerpdf->getNameFile()
			);
			$output["status"]="200";
			return $output;
		}else{
            $output["result"]="Error";
            $output["content"]="";
			$output["status"]="500";
			return $output;
		}
	}

	public function verify_login_or_fail(){
		if($this->nativesession->get("estado")!="logeado"){
			show_error("No tiene acceso a ese documento",501);
			exit;
		}
	}

	public function have_notification_simbol($content=''){
		return "<div class='viewPoint'>".($content)."</div>";
	}

}
