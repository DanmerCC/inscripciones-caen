<?php 
/**
*
*/
class CertificadoController extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Certificado_model');
	}

    public function verificar(){
        header('Access-Control-Allow-Origin: *'); 
        header('Content-Type: application/json');
        $hash=$this->input->post('hash');
        echo json_encode(["result"=>$this->Certificado_model->verificar($hash)->num_rows()]);
    }
        
        
}