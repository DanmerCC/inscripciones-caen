<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

require_once ("interfaces/Idata_controller.php");

class DiscountRequirement extends MY_Controller  implements Idata_controller
{
	private $canDelete=false;
	private $canChangeDiscount=false;

	function __construct()
	{
		parent::__construct();
		$this->load->library('Nativesession');
		$this->load->library('Mihelper');
		$this->load->helper('url');
		$this->load->model('DiscountRequirement_model');
		$this->load->helper('mihelper');
		$this->load->library('opciones');
		$this->load->model('Permiso_model');
		$this->load->model('Auth_Permisions');
		$this->canDelete=$this->Auth_Permisions->can('delete_desct_requirement');
		$this->canChangeDiscount=$this->Auth_Permisions->can('delete_desct_requirement');
		
    }
    
    public function dataTable(){

    }

    public function index(){
        
    }
	
	public function save(){
		$this->validatePermision($this->canChangeDiscount);
		$discount_id = $this->input->post('discount_id');
		$requirement_id = $this->input->post('requirement_id');
		$res = $this->DiscountRequirement_model->registrar($discount_id,$requirement_id);
		if($res){
			$this->structuredResponse(array('message'=>""),200);
		}else{
			$this->structuredResponse(array('message'=>"Ocurrio un error interno"),500);
		}
	}

	public function update(){
		$data=[];
		$discount_id = $this->input->post('discount_id');
		$requirement_id = $this->input->post('requirement_id');
		$id=$this->input->post('id');
		$status=$this->DiscountRequirement_model->update($id,$data);
		if($status){
			return $this->structuredResponse(array('message'=>""),200);
		}else{
			return $this->structuredResponse(array('message'=>"No se actualizo ningun campo"),200);
		}
		
	}

	public function edit($id=-1){
		$res = $this->DiscountRequirement_model->getOne($id);
		if($res){
			$this->structuredResponse($res,200);
		}else{
			$this->structuredResponse(array('message'=>"Ocurrio un error interno"),500);
		}
	}

	public function delete(){
		$this->validatePermision($this->canDelete);
        $requirement_id = $this->input->post('requirement_id');
        $discount_id = $this->input->post('discount_id');
        $data = $this->DiscountRequirement_model->getOneDataByDiscountAndRequirements($discount_id,$requirement_id);
        if($data!=null){
            $res = $this->DiscountRequirement_model->delete($data->id);
            if($res){
                $this->structuredResponse($res,200);
            }else{
                $this->structuredResponse(array('message'=>"Ocurrio un error interno"),500);
            }
        }
	}
}
