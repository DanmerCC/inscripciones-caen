<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Solicitud extends CI_Controller
{
	
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
        
        if($activeSearch){
            $rspta = resultToArray($this->Solicitud_model->get_data_for_datatable($start,$length,$search["value"]));
        }else{
            $rspta = resultToArray($this->Solicitud_model->get_data_for_datatable($start,$length));
        }
        $data = Array();
        //echo var_dump($rspta);
        $ii=$start;
        header("Content-type: application/json");
        for ($i=0;$i<count($rspta);$i++) {
            $ii++;
                $data[$i] = array(
                "0" => $activeSearch?"-":(($cantidad-$ii)+1),
                "1" => '<a href="'.base_url()."postulante/pdf/".$rspta[$i]["idSolicitud"].'" class="btn btn-success" target="_blank" onclick=""><i class="fa fa-print"></i></a>'.
                            ' <div class="btn btn-info" data-toggle="modal" data-target="#mdl_datos_alumno" onclick="modalDataAlumno.loadData('.$rspta[$i]["idSolicitud"].');"><i class="fa fa-eye"></i></div>'.
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
                "8" => (($rspta[$i]["marcaPago"]=='0')?' <button class="btn btn-alert"   title="click para marcar como verificado" onclick="marcarPago('.$rspta[$i]["idSolicitud"].')"><i class="fa fa-thumb-tack" aria-hidden="true"></i></button>':
                ' <button class="btn btn-warning" onclick="quitarmarcaPago('.$rspta[$i]["idSolicitud"].')"><i class="fa fa-thumb-tack" aria-hidden="true"></i></button>'),
                "9" => '<textarea class="form-control" onclick="editComent('.$rspta[$i]["idSolicitud"].');" readonly="readonly">'.$rspta[$i]["comentario"].'</textarea>',
                "10" => $rspta[$i]["fecha_registro"],
                "11" => ($rspta[$i]["estado"]=='0')?'<span class="label bg-red">Sin atender</span>':'<span class="label bg-green">Atendido</span>'
            );
         }        
        $results = array(
            "sEcho" =>$this->input->post('sEcho'), //Informacion para datatables
            "iTotalRecords" => $cantidad, //enviamos el total de registros al datatables
            "iTotalDisplayRecords" => ($activeSearch)?$this->Solicitud_model->count_with_filter($search["value"]):$cantidad, //enviamos total de registros a visualizar
            "aaData" => $data);
        echo json_encode($results);
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

}
