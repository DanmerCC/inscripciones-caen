<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Registro extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
    }

    public function index()
    {
        $data['cabecera'] = $this->load->view('adminlte/linksHead', '', true);
        $data['footer']   = $this->load->view('adminlte/scriptsFooter', '', true);

        $this->load->view('register', $data);
    }

    public function guardar()
    {
    		$id_usuario_dni = $this->input->post('id');//el id por defecto sera el dni pero puede ser cambiado  cualquier otro

	        $nombre           = $this->input->post('nombre');
	        $apellido_paterno = $this->input->post('apellido_paterno');
	        $apellido_materno = $this->input->post('apellido_materno');
	        $password         = $this->input->post('password');
	        $email            = $this->input->post('email');

        $ql = $this->db->select('documento')->from('alumno')->where('documento',$id_usuario_dni)->or_where('email',$email)->get();
        if ($ql->num_rows() > 0) {
            $data["heading"]=" YA ESTA REGISTRADO";
            $data["message"]="Ya existe un registro con el mismo numero de Numero de documento o correo electronico";
			$data["seconds"]="5";
			$data["url"]="/registro";
        	echo $this->load->view('errors/custom/flash_msg',$data,TRUE);
			die();
        } else {

            /*Captura de errores para primer registro*/
			$this->load->model('Alumno_model');
			$alumno = $this->Alumno_model->registrar($apellido_paterno, $apellido_materno, $nombre, $id_usuario_dni,$email);
            $this->load->model('User_model');
            
            if($this->User_model->registrar($id_usuario_dni, $email, $password, $alumno)){
                $data["heading"]="Se registro correctamente";
                $data["message"]="Su cuenta  $id_usuario_dni a sido registrada correctamente";
                $data["seconds"]="5";
                $data["url"]="/postulante";
                $this->load->view('errors/custom/flash_msg',$data);
            }else{
                $data["heading"]="Ah ocurrido un error ";
                $data["message"]="Su cuenta  $id_usuario_dni no se registro intentelo nuevamente";
                $data["seconds"]="4";
                $data["url"]="/postulante";
                $this->load->view('errors/custom/flash_msg',$data);
            }
            
        }


    }

}
