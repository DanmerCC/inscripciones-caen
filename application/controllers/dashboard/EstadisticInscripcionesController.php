<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class EstadisticInscripcionesController extends MY_Controller
{
    public function __construct()
	{
		parent::__construct();
		$this->load->library('Nativesession');
        $this->load->helper('url');
        $this->load->model('Informes_model');
        $this->load->model('EstadisticsInscripcion_model');
    }
    
    public function report(){
		$programas_ids=$this->input->post('programas_ids');
		$fechaInicio=$this->input->post('fecha_inicio');
		$fechaFin=$this->input->post('fecha_fin');

		$data=$this->EstadisticsInscripcion_model->inscritosPorFechas($fechaInicio,$fechaFin,$programas_ids);
		$fechas=[];
		for ($i=0; $i < count($data); $i++) { 
			if(!array_key_exists($data[$i]["fecha"],$fechas)){
				$fechas[$data[$i]["fecha"]]=[
					"conteo"=>[]
				];
			}
			if(array_key_exists($data[$i]["fecha"],$fechas)){
				array_push($fechas[$data[$i]["fecha"]]["conteo"],[
					"programa_id"=>$data[$i]["programa"],
					"cantidad"=>$data[$i]["cantidad"],
				]);
			}
		}
		$this->response($fechas);
    }
}
