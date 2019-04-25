<?php 
/**
*
*/
class ChartsController extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
        $this->load->model('DataSource_model');
	}

    public function get_data_source(){
        $model=$this->input->post('model');
        $this->DataSource_model->setModel("alumnos");
        $resultado=$this->DataSource_model->getDataSetsName();
        $this->response($resultado);
    }

    public function get_data_source_name(){

    }
        
        
}