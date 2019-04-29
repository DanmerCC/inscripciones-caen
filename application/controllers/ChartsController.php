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

	public function alumno_get_group_data(){
		$this->load->model('Alumno_model');
		$modelo=$this->input->post('model');
		$column=$this->input->post('column');
		//echo  var_dump($modelo);
		//exit;
		//if(empty($modelo) || empty($column) || !in_array($column,$this->Alumno_model->getColumnsForAnalisis())){
		if(empty($modelo) || empty($column) || !in_array($column,$this->Alumno_model->getColumnsForAnalisis())){
			show_404();
			exit;
		}

		$group_data=$this->Alumno_model->getDataGroupColumn($column);
		$resultado=array();
		foreach($group_data as $key=>$data)
		{
			array_push($resultado,$data[$column]);
		}
		//var_dump($resultado);
		//exit;
		$this->response($resultado,200);
	}

	public function get_count_data(){
		$this->load->model('Alumno_model');
		$modelo=$this->input->post('model');
		$column=$this->input->post('column');
		//echo  var_dump($this->Alumno_model->getDataGroupColumn($column));
		//exit;
		//if(empty($modelo) || empty($column) || !in_array($column,$this->Alumno_model->getColumnsForAnalisis())){
		if(empty($modelo) || empty($column) || !in_array($column,$this->Alumno_model->getColumnsForAnalisis())){
			show_404();
			exit;
		}
		
		$group_data_from_column=$this->Alumno_model->getDataGroupColumn($column);
		$columns=$this->Alumno_model->getColumnsForAnalisis();
		
		$data_sets=array();
		foreach($group_data_from_column as $key=>$data)
		{
			array_push($data_sets,$data[$column]);
		}

		
		$group_data=array();
		$columns=$this->Alumno_model->getColumnsForAnalisis();
		
		for ($i=0; $i < count($data_sets); $i++) { 
			
			array_push($group_data,$this->Alumno_model->getCountForAnalisis($column,$data_sets[$i])[0]);
		}
		$this->response($group_data,200);
	}
        
    private function load_alumno_model(){
		$this->load->model('Alumno_model');
	}
}
