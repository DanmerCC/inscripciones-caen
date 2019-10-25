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
		$this->addHeaderCrosOriginHeader();
		
    }
    
    public function report(){
		$programas_ids=empty($this->input->post('programas_ids'))?[]:$this->input->post('programas_ids');
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
	
	function inscritosPorPrograma(){
		$data=$this->EstadisticsInscripcion_model->inscritosPorPrograma();
		$result["militares"]=[];
		$result["civiles"]=[];
		for ($i=0; $i < count($data); $i++) {
			if($data[$i]["si_militar"]=="0"){
				array_push($result["civiles"],[
					"programa_id"=>$data[$i]["programa"],
					"cantidad"=>$data[$i]["cantidad"]
				]);
			}elseif($data[$i]["si_militar"]=="1"){
				array_push($result["militares"],[
					"programa_id"=>$data[$i]["programa"],
					"cantidad"=>$data[$i]["cantidad"]
				]);
			}
			
		}
		
		$this->response($result);
	}
	/**
	 * Cuantos con exalumnos del caen en los inscritos
	 * 
	 */
	function exalumnosInscritosPorPrograma(){
		return $this->response($this->EstadisticsInscripcion_model->exalumnosPorPrograma());
	}


	function porGenero(){
		return $this->response($this->EstadisticsInscripcion_model->porGenero());
	}

	/***
	 * 
	 */
	function getInscritosPorCicloDeVida(){
		$this->db->select(
			"COUNT(inscripcion.id_inscripcion) as cantidad,".
			"TIMESTAMPDIFF(YEAR, alumno.fecha_nac, CURDATE()) as edad"
		);
		$this->db->from('alumno');
		$this->db->join('solicitud','alumno.id_alumno = solicitud.alumno');
		$this->db->join('inscripcion','inscripcion.solicitud_id = solicitud.idSolicitud');
		$this->db->group_by('edad');
		$result=$this->db->get()->result_array();
		$cantidadDeJovenes=0;
		$cantidadDeAdultos=0;
		$cantidadDeAdultosMayores=0;

		$RangeJovenes=[
			'start'=>18,
			'end'=>35
		];
		$RangeAdultos=[
			'start'=>35,
			'end'=>50
		];
		$RangeAdultosMayor=[
			'start'=>50,
			'end'=>200
		];
		for ($i=0; $i <count($result); $i++) { 
			if($result[$i]["edad"]>=$RangeJovenes['start']&&$result[$i]["edad"]>=$RangeJovenes['end']){
				$cantidadDeJovenes++;
			}
			if($result[$i]["edad"]>=$RangeAdultos['start']&&$result[$i]["edad"]>=$RangeAdultos['end']){
				$cantidadDeAdultos++;
			}
			if($result[$i]["edad"]>=$RangeAdultosMayor['start']&&$result[$i]["edad"]>=$RangeAdultosMayor['end']){
				$cantidadDeAdultosMayores++;
			}
		}
		$this->response([
			'jovens'=>$cantidadDeJovenes,
			'adultos'=>$cantidadDeAdultos,
			'adultoMayor'=>$cantidadDeAdultosMayores,
		]);
	}

	function addHeaderCrosOriginHeader(){
		header('Content-Type: application/json');
		header("Access-Control-Allow-Origin: *");
	}
}
