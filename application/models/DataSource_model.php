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
        $this->load->model($this->model_target);
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
        return $this->$thismodelo_target->getCountForAnalisis();
    }
    //Modelo
    //Columnas
    //TipoDatos

	
}
