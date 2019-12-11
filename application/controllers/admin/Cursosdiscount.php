<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

require_once ("interfaces/Idata_controller.php");

class Cursosdiscount extends MY_Controller  implements Idata_controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->library('Nativesession');
		$this->load->library('Mihelper');
		$this->load->helper('url');
		$this->load->model('Cursosdiscount_model');
		$this->load->helper('mihelper');
		$this->load->library('opciones');
		$this->load->model('Permiso_model');
	}

    public function dataTable(){
       // $rspta = $this->Discount_model->all();
        $rspta = [["id"=>"1","name"=>"PERsES","description"=>"SEA","percentage"=>"10"],["id"=>"2","name"=>"sasfFA","description"=>"AFAFAFS","percentage"=>"20"]];
	    //vamos a declarar un array
	    $data = Array();
	    header("Content-type: application/json");
	    $i=0;
	    foreach ($rspta as $value) {
	            $data[] = array(
				"0" => '<button class="btn btn-warning" onclick="mostrarFormPro(' .$value["id"]. ')"><i class= "fa fa-pencil"></i></button>
                        <button class="btn btn-danger" onclick="eliminar(' .$value["id"]. ')"><i class= "fa fa-trash"></i></button>
                        <button class="btn btn-info" onclick="verRequisitos(' .$value["id"]. ')"><i class= "fa fa-eye"></i></button>',
	            "1" => $value["name"],
	            "2" => $value["description"],
	            "3" => $value["percentage"]." %"
	        );
	     }        
	    $results = array(
	        "sEcho" => 1, //Informacion para datatables
	        "iTotalRecords" => count($data), //enviamos el total de registros al datatables
	        "iTotalDisplayRecords" => count($data), //enviamos total de registros a visualizar
	        "aaData" => $data);
	    echo json_encode($results);
    }

    public function index(){
    	if ($this->nativesession->get('tipo')=='admin') {
			$identidad["rutaimagen"]="/dist/img/avatar5.png";
			$identidad["nombres"]=$this->nativesession->get('acceso');
			$opciones["rutaimagen"]=$identidad["rutaimagen"];
			$opciones["menu"]=$opciones["menu"]=$this->opciones->segun($this->Permiso_model->lista($this->nativesession->get('idUsuario')),'Beneficios');

			$data['cabecera']=$this->load->view('adminlte/linksHead','',TRUE);
			$data['footer']=$this->load->view('adminlte/scriptsFooter','',TRUE);
			$data["mainSidebar"]=$this->load->view('adminlte/main-sideBar',$opciones,TRUE);
			$data['mainHeader']=$this->load->view('adminlte/mainHeader',array("identity"=>$identidad),TRUE);
			$this->load->view('dashboard_cursodiscount',$data);
		}else
		{
			redirect('administracion/login');
		}
	}
	
	public function save(){
		$discount_id = $this->input->post('discount_id');
		$programa_id = $this->input->post('programa_id');
		$res = $this->Cursosdiscount_model->registrar($discount_id,$programa_id);
		if($res){
			$this->structuredResponse(array('message'=>""),200);
		}else{
			$this->structuredResponse(array('message'=>"Ocurrio un error interno"),500);
		}
	}

	public function update($discount_id=-1){
		$data=[];
		$data["name"] = $this->input->post('name');
		$data["description"] = $this->input->post('description');
		$data["percentage"] = $this->input->post('percentage');
		$id=$this->input->post('discount_id');
		$status=$this->Discount_model->update($id,$data);
		if($status){
			return $this->structuredResponse(array('message'=>""),200);
		}else{
			return $this->structuredResponse(array('message'=>"No se actualizo ningun campo"),200);
		}
		
	}

	public function edit($discount_id=-1){
		$res = $this->Discount_model->getOne($discount_id);
		if($res){
			$this->structuredResponse($res,200);
		}else{
			$this->structuredResponse(array('message'=>"Ocurrio un error interno"),500);
		}
	}

	public function delete(){
		$programa_id = $this->input->post('programa_id');
        $discount_id = $this->input->post('discount_id');
		$data = $this->Cursosdiscount_model->getOneDataByDiscountAndCursos($discount_id,$programa_id);
        if($data!=null){
            $res = $this->Cursosdiscount_model->delete($data->id);
            if($res){
                $this->structuredResponse($res,200);
            }else{
                $this->structuredResponse(array('message'=>"Ocurrio un error interno"),500);
            }
        }
	}
}
