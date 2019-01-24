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
		$this->load->helper('url');
		$this->load->library('Pdf');
		//$this->load->library('Pdf2');
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
} 