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
        $column=$this->input->post('column');
        $this->DataSource_model->setModel($model);
        $resultado=$this->DataSource_model->getDdataGroupFilter($column);
        //echo var_dump($resultado);
        //exit;
        $this->response($resultado);
    }


    public function get_columns_name(){
		$this->init_model();
	}
	
	public function init_model(){
		$model=$this->uri->segment(2);
		if(!$this->DataSource_model->existModel($model)){
			error_404();
			exit;
		}
		$this->DataSource_model->setModel($model);
	}


	public function alumno_columns(){
		//$this->load_alumno_model();
		$this->load->model('Alumno_model');
		$result=$this->Alumno_model->getColumnsForAnalisis();
		$this->response($result,200);
	}
        
    private function load_alumno_model(){
		$this->load->model('Alumno_model');
	}
}
