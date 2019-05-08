<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 
/**
 * 
 */
class PostergacionController extends MY_Controller
{
	
	function __construct()
	{
        parent::__construct();
        $this->load->model('Postergacion_model');
        $this->load->library('NativeSession');
    }

    /**
     * nueva postergacion
     */
    function post_nuevo(){
        $programa_id=$this->input->post('programa_id');
        $fecha=$this->input->post('fecha');
        $comentario=$this->input->post('comentario');
        $id_author=$this->nativesession->get('idUsuario');
        $this->Postergacion_model->create($programa_id,$fecha,$id_author,$comentario);
    }


    /***
     * 
     */
}