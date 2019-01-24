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
		$this->load->library('Pdf');
		$this->load->library('pagination');
		$this->load->helper('mihelper');
		
	}

	public function index(){
		header('Content-Type: application/json');
		header("Access-Control-Allow-Origin: *");
		echo json_encode($this->mihelper->resultToArray($this->Solicitud_model->getAll()));
	}

	public function inf($cant,$page){//page
		header('Content-Type: application/json');
		header("Access-Control-Allow-Origin: *");
		/*$cant_total=$this->Solicitud_model->getNumSolicitudes();
		$max_offset=ceil($cant_total/($cant<=0?1:$cant));
		$cantGod=(($cant>100)?100:$cant);
		$offsetGod=(($offset>$max_offset)?$max_offset:$offset);
		*/
		$pageGood=($page<=0?1:$page);
		$cantGood=(($cant<0)?0:$cant);
		$cantGood=(($cantGood>100)?100:$cantGood);
		$offsetGood=$cantGood*($pageGood-1);
		echo json_encode(arrayObjectoToArray($this->Solicitud_model->informacion($cantGood,$offsetGood)));
		//echo var_dump($this->Solicitud_model->informacion($cant,$offset));
	}
	
	public function pdf($id){
		
        $solicitud=$this->Solicitud_model->getFichaDataEspecifico($id);

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

}