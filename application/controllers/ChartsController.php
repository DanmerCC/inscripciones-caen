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

	private function get_array_model(){
		$model=array();
		$model["alumno"]="Alumno_model";
		$model["Inscrito"]="Inscripcion_model";
		return $model;
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
/**
 * @var name_model is a alias name string 
 */
	private function load_model_by_name_or_fail($name_model){
		if(isset($this->get_array_model()[$name_model])){
			$this->load->model($this->get_array_model()[$name_model]);
			return $this->get_array_model()[$name_model];
		}else{
			show_error("Error al cargar el nombre de modelo",500);
		}
	}

	public function alumno_columns(){
		$model_real_name=$this->load_model_by_name_or_fail($this->input->post('model'));
		$result=$this->$model_real_name->getColumnsForAnalisis();
		$this->response($result,200);
	}

	public function alumno_get_group_data(){
		$this->load->model('Alumno_model');
		$modelo=$this->input->post('model');
		$column=$this->input->post('column');
		$model_real_name=$this->load_model_by_name_or_fail($this->input->post('model'));
		
		if(empty($modelo) || empty($column) || !in_array($column,$this->Alumno_model->getColumnsForAnalisis())){
			show_404();
			exit;
		}

		$group_data=$this->$model_real_name->getDataGroupColumn($column);
		$resultado=array();
		foreach($group_data as $key=>$data)
		{
			array_push($resultado,$data[$column]);
		}
		//var_dump($resultado);
		//exit;
		$this->response($resultado,200);
	}

	/**
	 * @var 
	 */
	public function get_count_data_alumno(){
		$modelo=$this->input->post('model');
		$column=$this->input->post('column');
		$model_real_name=$this->load_model_by_name_or_fail($this->input->post('model'));
		if(empty($modelo) || empty($column) || !in_array($column,$this->$model_real_name->getColumnsForAnalisis())){
			show_404();
			exit;
		}
		
		$group_data_from_column=$this->$model_real_name->getDataGroupColumn($column);
		$columns=$this->$model_real_name->getColumnsForAnalisis();
		
		$data_sets=array();
		foreach($group_data_from_column as $key=>$data)
		{
			array_push($data_sets,$data[$column]);
		}
		$group_data=array();
		$columns=$this->$model_real_name->getColumnsForAnalisis();
		for ($i=0; $i < count($data_sets); $i++) { 
			
			array_push($group_data,$this->$model_real_name->getCountForAnalisis($column,$data_sets[$i])[0]);
		}
		$this->response($group_data,200);
	}
        
    private function load_alumno_model(){
		$this->load->model('Alumno_model');
	}

	public function get_chart(){
		$this->load->model('Inscripcion_model');
		$result=$this->Inscripcion_model->queryGetProgramCount();
		//echo var_dump($result);
		//exit;
		$columns=array();
		$data_set=array();
		for ($i=0; $i < count($result); $i++) { 
			array_push($columns,$result[$i]["nombre_programa"]);
			array_push($data_set,$result[$i]["conteo"]);
		}
		$this->response(array("labels"=>$columns,"datasets"=>[$data_set]),200);
	}

}
