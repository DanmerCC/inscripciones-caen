<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class DataSource_model extends CI_Model
{

    private $model_target='';
    
    public $models_targetable=[
        'alumnos'=>'Alumno_model'
    ];

	function __construct()
	{
		parent::__construct();
        $this->load->helper('mihelper');
	}

    public function setModel($model_name){
        $this->model_target=$this->models_targetable[$model_name];
        $this->load->model($this->model_target);
    }
    public function getDataSetsName(){
        $thismodelo_target=$this->model_target;
        return $this->$thismodelo_target->getColumnsForAnalisis();
    }

    public function getDataByName($data_sets){
        $this->load->model($this->model_target);
        $thismodelo_target=$this->model_target;
        return $this->$thismodelo_target->getCountForAnalisis($data_sets);
	}
	
	public function getDdataGroupFilter($column,$filter=NULL){
		$this->load->model($this->model_target);
		$thismodelo_target=$this->model_target;
		return $this->$thismodelo_target->getDataGroupColumn($column,$filter);
	}

	public function existModel($model_name){
		return array_key_exists($model_name,$this->models_targetable);
	}
    //Modelo
    //Columnas
    //GrupoDeDatos
	public function get_columns_name(){
		$thismodelo_target=$this->model_target;
        return $this->$thismodelo_target->getColumnsForAnalisis();
	}

	public function get_group_data($column,$filter=NULL){
		$model=$this->load_current_model();
		return $this->$model->getDataGroupColumn($column,$filter);
	}

	public function get_count_data_by_group_data($column,$filter=NULL){
		$model=$this->load_current_model();
		return $this->$model->getCountForAnalisis($column,$filter);
	}

	private function load_current_model(){
		$this->load->model($this->model_target);
		$thismodelo_target=$this->model_target;
		return $thismodelo_target;
	}
	
}
