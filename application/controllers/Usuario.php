<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('Nativesession');
	}

	public function cambiarContraseña(){
		$this->load->model('User_model');
		$password=$this->input->post('pwdActual');
		$passwordNuevo=$this->input->post('pwdNew');
		$passwordComparacion=$this->input->post('pwdRenew');
		$id_usuario=$this->nativesession->get('idUsuario');

		$validado=0;
		if(isset($password)&&isset($passwordNuevo)&&isset($passwordComparacion)&&isset($id_usuario)&&($passwordNuevo==$passwordComparacion)){
		//if(isset($password)&&isset($passwordNuevo)&&isset($passwordComparacion)&&isset($temp)&&($passwordNuevo==$passwordComparacion)){
			//$resultado=$this->User_model->buscarUsuario($temp);
				//password_verify($password,$result->result()[0]->password)
			echo  var_dump($this->User_model->validarContraseña($password,$id_usuario));
			if ($this->User_model->validarContraseña($password,$id_usuario)) {
				$validado=1;
			}
		}

		$resultado=0;

		if ($validado) {

			if ($this->User_model->cambiarContraseña($passwordNuevo,$id_usuario)) {
				$resultado=1;

			}
		}
		
		echo (string)$resultado;

	}


}