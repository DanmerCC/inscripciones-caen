<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class InformesController extends MY_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Informes_model');
	}

	public function index()
	{
		$this->load->view('informes');
	}

	public function save(){
		
		$nombres_ap=$this->input->post('nombres_ap');
		$email=$this->input->post('email');
		$celular=$this->input->post('celular');
		$centro_laboral=$this->input->post('centro_laboral');
		$programa=$this->input->post('programa');
		$opt=$this->input->post('opt');
		$consulta=$this->input->post('consulta');

		$sucess=$this->Informes_model->save(
			$nombres_ap,
			$email,
			$celular,
			$centro_laboral,
			$programa,
			$opt,
			$consulta
		);
		if($sucess){
			echo "Correctamente guardado";
			exit;
		}else{
			show_error("Error al guardar",500);
		}
	}



} 
