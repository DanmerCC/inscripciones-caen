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
        $this->load->helper('url');
	}

    public function get_data_source_names(){
        //$model=$this->input->post('model');
        $model=$this->uri->segment(2);
        $this->DataSource_model->setModel($model);
        $resultado=$this->DataSource_model->getDataSetsName();
        $this->response($resultado);
    }

    public function get_data_source(){
        $model=$this->uri->segment(2);
        $columns=$this->input->post('columns[]');
        $this->DataSource_model->setModel($model);
        $resultado=$this->DataSource_model->getDataByName($columns);
        //echo var_dump($resultado);
        //exit;
        $this->response($resultado);
    }
        
        
}