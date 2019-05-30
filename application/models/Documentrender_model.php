<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class Documentrender_model extends CI_Model
{
	private $documentable;

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Pdf');
	}

	public function setType(Documentable $documentable){
		$this->documentable=$documentable;
	}

	public function loadDocument(){
		$data=$this->documentable->getData();
		$template=$this->documentable->template;
		$pdf = new Pdf('P', 'mm', 'A4', false, 'UTF-8', false);
		$pdf->SetDisplayMode('real', 'default');
		$pdf->setCellHeightRatio(1.3);
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		//**Obligamos a ejecutar la impresion en el lado del usuario */
		$pdf->AutoPrint(true);
        $pdf->AddPage();
		$html = $this->load->view($template,$data,true);
		$pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output('My-File-Name.pdf', 'I');
	}
	
	public function delete(){
		if($this->documentable==NULL){
			throw Exception("No se definio documento");
		}else{
			$this->documentable->send_to_trash();
		}
	}
}

interface Documentable{
	//public function getPath():String;
	//public function getName():void;
	public function getData();
	//public function setTemplate();
	public function send_to_trash();
}

abstract class BaseDocument {
	public $ci;
	public $path ='/';
	protected $id;

	public function __construct(int $id)
	{
		$this->ci=&get_instance();
		$this->id=$id;
	}

}

class SolicitudDocument extends BaseDocument implements Documentable {


	public $path ='/';
	public $template='pdf/solicitud_admision';

	public function setTemplate(){

	}

	public function getData(){
		$this->ci->load->model('Solicitud_model');
		$this->ci->load->model('Alumno_model');
		$this->ci->load->model('Programa_model');
		$solicitud=$this->ci->Solicitud_model->getAllColumnsById($this->id);
		$alumno=$this->ci->Alumno_model->findById($solicitud["alumno"])[0];
		$programa=$this->ci->Programa_model->get_one_with_type($solicitud["programa"]);
		$data["nombres_completo"]=$alumno["nombres"]." ".$alumno["apellido_paterno"]." ".$alumno["apellido_materno"];
		$data["telefono"]=$alumno["celular"];
		$data["programa"]=$programa->numeracion." ".$programa->tipo_curso." en ".$programa->nombre;
		$data["documento"]=$alumno["documento"];
		$data["profesion"]=$alumno["grado_profesion"];
		$data["domicilio"]=$alumno["direccion"];
		$data["domicilio_distrito"]=$alumno["distrito"];
		$data["email"]=$alumno["email"];
		


		$fecha=explode('-',$programa->fecha_inicio);
			$año=$fecha[0];
			$dia=$fecha[2];
			$mes=$this->getMesTexto($fecha[1]);
		$fecha_actual=explode('-',date('Y-m-d'));
		
			
		$data["fechatexto_start_program"]="$dia de $mes de $año";
		$data["fecha_actual"]=$fecha_actual[2]." de ".$this->getMesTexto($fecha_actual[1])." del ".$fecha_actual[0];

		return $data;
	}

	public function send_to_trash(){
		echo "Eliminado";
		exit;
	}

	public function getMesTexto($number_month){
		switch ($number_month) {
			case 1:
				$mes = 'Enero';
				break;
			case 2:
				$mes = 'Febrero';
				break;
			case 3:
				$mes = 'Marzo';
				break;
			
			case 4:
				$mes = 'Abril';
				break;
			case 5:
				$mes = 'Mayo';
				break;
			case 6:
				$mes = 'Junio';
				break;
			case 7:
				$mes = 'Julio';
				break;
			case 8:
				$mes = 'Agosto';
				break;
			case 9:
				$mes = 'Septiembre';
				break;
			case 10:
				$mes = 'Octubre';
				break;
			case 11:
				$mes = 'Noviembre';
				break;
			case 12:
				$mes = 'Diciembre';
				break;
			default:
				$mes = '_________';
				break;
		}
		return $mes;
	}

}
