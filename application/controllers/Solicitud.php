<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Solicitud extends MY_Controller
{
	
	public function __construct()
	{

		parent::__construct();
		$this->load->library('Nativesession');
		$this->load->helper('url');
		$this->load->library('Pdf');
		//$this->load->library('Pdf2');
		$this->load->model('Solicitud_model');
		$this->load->model('Notificacion_model');
	}
	
	public function index(){
		echo "controlador vacio";
	}
// Pdf
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
		$pdf->AutoPrint(true);
		$pdf->AddPage();
		
		$html = $this->load->view('pdf/ficha',$data,true);
		$pdf->writeHTML($html, true, false, true, false, '');
		$pdf->Output('My-File-Name.pdf', 'I');

	}
//devuelve el modelo pdf en html
	public function html($id){
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

		$data["datosAlumno"]=$solicitud;
		$this->load->view('pdf/ficha',$data);

	}
//devuelve los datos
	public function data($id){
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

		echo "<pre>",var_dump($data),"</pre>";

	}
// generacion de codigo qr
	public function qrCode(){
		$this->load->library('ciqrcode');
		$params['data'] = "Abelardo";
		$params['level'] = 'H';
		$params['size'] = 20;

		$params['savename'] = FCPATH.'/files/qrcode.png';

		$this->ciqrcode->generate($params);
		echo '<img src="'.base_url().'/files/qrcode.png" />';
	}

	public function delete($id){
		$this->load->model('Solicitud_model');
		//echo $this->Solicitud_model->delete($id);
		$respuesta="";

		$this->eliminarAllNotifications($id);

		if($this->Solicitud_model->delete($id)){
			$respuesta="Solicitud eliminada exitosamente";
		}else{
			$respuesta="La solicitud no se pudo eliminar";
		}
		$data["heading"]="Redireccionando";
        $data["message"]=$respuesta;
        $data["seconds"]="3";
        $data["url"]="/postulante";
        $this->load->view('errors/custom/flash_msg',$data);
	}

	private function eliminarAllNotifications($solicitud_id)
	{
		$notifications = $this->Notificacion_model->getAllNotification($solicitud_id);
		if($notifications!=null)
		{
			foreach ($notifications as $key => $item) {
				$this->Notificacion_model->deleteReadNoificationByNotification($item->notification_id);
				$this->Notificacion_model->deleteNotificationSolicitud($solicitud_id);
				$this->Notificacion_model->delete($item->notification_id);
			}
		}
	}

    public function test(){
    
        // Add a page from a PDF by file path.
    $pdf->setSourceFile('/SolicitudBase.pdf');
    
    // Import the bleed box (default is crop box) for page 1.
    //$tplidx = $pdf->importPage(1, '/BleedBox');
    $size = $pdf->getTemplatesize($tplidx);
    $orientation = ($size['w'] > $size['h']) ? 'L' : 'P';
    
    $pdf->AddPage($orientation);
    
    // Set page boxes from imported page 1.
    $pdf->setPageFormatFromTemplatePage(1, $orientation);
    
    // Import the content for page 1.
    $pdf->useTemplate($tplidx);
    
    // Import the annotations for page 1.
    $pdf->importAnnotations(1);
	}
	
	public function stateFile($id){
		$result=[];
		header('Content-Type: application/json');
		
		if($this->nativesession->get("estado")=="logeado"){
			$result=[
				"content"=>[
					"hdatos"=>file_exists(CC_BASE_PATH.'/files/hojadatos/'.$id.".pdf"),
					"nameFiles"=>$id
				],
				"status"=>"OK"
				
			];
		}else{
			$result=[
				"content"=>[],
				"status"=>"ERROR"
			];
		}
		echo json_encode($result,JSON_UNESCAPED_UNICODE);
	}

	public function stateFile_sol_admision($id){
		$result=[];
		header('Content-Type: application/json');
		
		if($this->nativesession->get("estado")=="logeado"){
			$result=[
				"content"=>[
					"solad"=>file_exists(CC_BASE_PATH.'/files/sol-ad/'.$id.".pdf"),
					"nameFiles"=>$id
				],
				"status"=>"OK"
				
			];
		}else{
			$result=[
				"content"=>[],
				"status"=>"ERROR"
			];
		}
		echo json_encode($result,JSON_UNESCAPED_UNICODE);
	}

	public function uploadHojaDeDatos($id){
		$idAlumno=$this->nativesession->get("idAlumno");
		if(!isset($idAlumno)){
			show_404();
			exit;
		}
		$solicitud=$this->Solicitud_model->byIdAndAlumno($id,$idAlumno);
		if(count($solicitud)!=0){
			$mensaje='se subio una hoja de datos';
			$this->Solicitud_model->set_notification_mensaje($id,$mensaje);
			echo $this->uploadFile('cv',$id,"hojadatos");//send result to view
		}else{
			show_404();
			exit;
		}
	}

	public function upload_pro_inves($id){
		$idAlumno=$this->nativesession->get("idAlumno");
		if(!isset($idAlumno)){
			show_404();
			exit;
		}
		$solicitud=$this->Solicitud_model->byIdAndAlumno($id,$idAlumno);
		if(count($solicitud)!=0){
			$mensaje='se subio un proyecto de investigacion';
			$this->Solicitud_model->set_notification_mensaje($id,$mensaje);
			echo $this->uploadFile('cv',$id,"proinves");//send result to view
		}else{
			show_404();
			exit;
		}
	}

	public function stateFile_spro_inves($id){
		$result=[];
		header('Content-Type: application/json');
		
		if($this->nativesession->get("estado")=="logeado"){
			$result=[
				"content"=>[
					"pinvs"=>file_exists(CC_BASE_PATH.'/files/proinves/'.$id.".pdf"),
					"nameFiles"=>$id
				],
				"status"=>"OK"
				
			];
		}else{
			$result=[
				"content"=>[],
				"status"=>"ERROR"
			];
		}
		echo json_encode($result,JSON_UNESCAPED_UNICODE);
	}

	public function upload_sol_admision($id){
		$idAlumno=$this->nativesession->get("idAlumno");
		if(!isset($idAlumno)){
			show_404();
			exit;
		}
		$solicitud=$this->Solicitud_model->byIdAndAlumno($id,$idAlumno);
		if(count($solicitud)!=0){
			$mensaje='se subio una solicitud de admision';
			$this->Solicitud_model->set_notification_mensaje($id,$mensaje);
			echo $this->uploadFile('cv',$id,"sol-ad");//send result to view
		}else{
			show_404();
			exit;
		}
	}

	private function uploadFile($nameInput,$fileName,$path){

		$config['upload_path'] = CC_BASE_PATH."/files/$path/";
        
       	//Tipos de ficheros permitidos
        $config['allowed_types'] = 'pdf';
		$config['overwrite'] = true;
        //nombre de imagen
		$config['file_name'] = $fileName;
		
		$this->load->library('upload',$config);
		header('Content-Type: application/json');
		if(!$this->upload->do_upload($nameInput)){
            /*Si al subirse hay algún error lo meto en un array para pasárselo a la vista*/
			$error=array('error' => $this->upload->display_errors());
			//echo  var_dump($error);
			//$this->load->view('subir_view', $error);
			//echo "error al subir el archivo";
			//redirect(base_url().'postulante', 'refresh');
			$result=[
				"content"=>[],
				"status"=>"ERROR_UPDATING_FILE",
				"error"=>$error
			];
			return json_encode($result,JSON_UNESCAPED_UNICODE);
		}elseif($this->nativesession->get("estado")!="logeado"){
			$result=[
				"content"=>[],
				"status"=>"UNAUTHORIZED"
			];
			return json_encode($result,JSON_UNESCAPED_UNICODE);
		}
		else{
            //Datos del fichero subido
            $datos["img"]=$this->upload->data();
 
            //Podemos acceder a todas las propiedades del fichero subido 
            $datos["img"]["file_name"];
			
			//echo var_dump($datos);

            //Cargamos la vista y le pasamos los datos
            //para asegurarse que la imagen nueva se cargue en la vista se agregara un header
            //header("Cache-Control: no-cache, must-revalidate");
			//header("Expires: Sat, 1 Jul 2000 5:00:00 GMT");
			$result=[
				"content"=>[
					"dataextra"=>$this->upload->data(),
					"file_name"=> $datos["img"]["file_name"]
				],
				"status"=>"OK"
			];
			return json_encode($result,JSON_UNESCAPED_UNICODE);
        }
	}

	/**
	 * genera un documento a partir de los datos de la persona
	 */
	public function generate_document($id){
		$this->verify_login_or_fail();
			$idUser=$this->nativesession->get('idUsuario');
		$this->load->model('Documentrender_model');
		$nuva_solicitud=new SolicitudDocument($id);

		/**Verifica si es dueño de la solicitud */
		$solicitud=$this->Solicitud_model->getAllColumnsById($id);
		$idAlumno=$this->nativesession->get('idAlumno');
		if(!($idAlumno===$solicitud["alumno"])){
			show_error("Permiso denegado",401);
			exit;
		}
		$this->Documentrender_model->setType($nuva_solicitud);
		$this->Documentrender_model->loadDocument();
	}

	public function verify_login_or_fail(){
		if($this->nativesession->get("estado")!="logeado"){
			show_404();
			exit;
		}
	}

	public function storeSolicitudDiscount()
	{
		if (isset($_FILES['file_requirement'])) {
			$filesData = $this->do_upload();
			$this->db->trans_start();
			try {
				$solicitud_discount_data = array(
					'solicitud_id' => $this->input->post('solicitud_idd'),
					'discount_id' => $this->input->post('tipodescuento_idd')
				);
				$this->Solicitud_model->saveSDolicitudDiscount($solicitud_discount_data);
				for ($i=0; $i < count($filesData); $i++) { 
					$array = array(
						'requirement_id'=> $filesData[$i]['requirement_id'],
						'solicitud_id'=> $this->input->post('solicitud_idd'),
						'discount_id'=> $this->input->post('tipodescuento_idd'),
						'file'=>$filesData[$i]['file_name']
					);
					$this->Solicitud_model->addRequirement($array);
				}
			} catch (\Exception $th) {
				$this->db->trans_rollback();
				$this->structuredResponse(array('message'=>$th->getMessage()),500);
			}
			
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE)
			{
				$this->db->trans_rollback();
				$this->structuredResponse(array('message'=>"Error al guardar "),500);
			}
			else
			{
				$this->db->trans_commit();
				$this->structuredResponse(array('message'=>""),200);
			}


		} else{
			$this->structuredResponse(array('message'=>"Subir todos los documentos"),500);
		}
	}

	private function do_upload()
	{
		$this->load->library('upload');
		$newFilesData = array();
		$files = $_FILES;
		foreach ($_FILES['file_requirement']['name'] as $key => $itemFile) {

			$_FILES['file_requirement']['name']= $files['file_requirement']['name'][$key];
			$_FILES['file_requirement']['type']= $files['file_requirement']['type'][$key];
			$_FILES['file_requirement']['tmp_name']= $files['file_requirement']['tmp_name'][$key];
			$_FILES['file_requirement']['error']= $files['file_requirement']['error'][$key];
			$_FILES['file_requirement']['size']= $files['file_requirement']['size'][$key];   
			
			$file_name = date('Ymdhis')."_".$key."_".$this->input->post('tipodescuento_idd');
			
			$this->upload->initialize($this->set_upload_options($file_name));
			if (!$this->upload->do_upload('file_requirement')) {
				$this->structuredResponse(array('message'=>$this->upload->display_errors()),500);
				exit;
			} else {
				$newFilesData[] = array(
					'file_name' => $this->upload->data()['file_name'],
					'requirement_id' => $key
				);
			}
		}
		return $newFilesData;
	}

	private function set_upload_options($fileName)
	{   
		//upload an image options
		$config = array();
		$config['upload_path'] = CC_BASE_PATH."/files/requirement/";
		$config['allowed_types'] = 'pdf';
		$config['overwrite']     = true;
		$config['file_name'] 	 = $fileName;
		return $config;
	}

} 
