<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 
/**
 * 
 */
class Programa extends MY_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->library('Nativesession');
		$this->load->library('Mihelper');
		$this->load->helper('url');
		$this->load->model('Programa_model');
		$this->load->library("Mihelper");
		$this->load->library('opciones');
		$this->load->model('Permiso_model');
	}

	public function newPrograma(){
		$result['tipo']=$this->mihelper->resultToArray($this->Programa_model->getAllTipos());
		$this->load->view("modals/newForm_programa",$result);
	}

    public function dataTable(){
		$search=$this->input->post("search[]");
		$start=$this->input->post('start');
		$length=$this->input->post('length');
		$columns=$this->input->post('columns');
		$number_order=$this->input->post('order[0][column]');
		$dir_order=$this->input->post('order[0][dir]');
		$activeSearch=!(strlen($search["value"])==0);
		$cantidad=$this->Programa_model->count();
		$visibility='';
		/**
		 * valida el texto del search 
		 * si el valor no coincide con visible o no visible se guarda como ''
		 */
		switch ($columns[8]["search"]["value"]) {
			case 'visible':
				$visibility='visible';
				break;
			case 'no visible':
				$visibility='no visible';
				break;
			default:
				$visibility='';
				break;
		}
		$this->Programa_model->onlyVisibleFilter($visibility);
		if(isset($columns[7]["search"]["value"])){
			$this->Programa_model->setTypeFilter($columns[7]["search"]["value"]);
		}
		
		if(strlen($search["value"])>0){
			$rspta = $this->Programa_model->page_with_filter($start,$length,$search["value"],$number_order,$dir_order);
		}else{
			$rspta = $this->Programa_model->page($start,$length,$number_order,$dir_order);
		}
	    //vamos a declarar un array
		$data = Array();
		//echo var_dump($rspta);
		//exit;
	    header("Content-type: application/json");
		$i=0;
		
	    foreach ($rspta as $value) {
	            $data[] = array(
	            "0" => ' <button class="btn btn-warning" onclick="mostrarFormPro(' .$value["id_curso"]. ')"><i class= "fa fa-pencil"></i></button>'.(($value["estado"]=='0')?' <button class="btn btn-alert"   title="" onclick="activarPrograma('.$value["id_curso"].')"><i class="fa fa-eye-slash" aria-hidden="true"></i></button>':
				' <button class="btn btn-primary" onclick="desactivarPrograma('.$value["id_curso"].')"><i class="fa fa-eye" aria-hidden="true"></i></button>').
				(($value["estado"]=='1')?$this->html_link($value["id_curso"]):""),
	            "1" => $value["numeracion"]." ".$value["nombre"],
	            "2" => $value["duracion"],
	            "3" => $value["costo_total"],
	            "4" => $value["vacantes"],
	            '5' => $value['fecha_inicio'].$this->HTML_Postergacion($value["id_curso"]),
	            "6" => $value["fecha_final"],
	            "7" => $value["tipoNombre"],
	            "8" => ($value["estado"]=='0')?'<span class="label bg-red">No visible</span>':'<span class="label bg-green">Visible</span>'
	        );
	     }        
	    $results = array(
	        "sEcho" => $this->input->post('sEcho'), //Informacion para datatables
	        "iTotalRecords" => count($data), //enviamos el total de registros al datatables
	        "iTotalDisplayRecords" => $this->Programa_model->countWithStateFilter(), //enviamos total de registros a visualizar
	        "aaData" => $data);
	    echo json_encode($results);
	}
	
	private function HTML_Postergacion($id){
		return "<ul class=''>
				<li class='dropdown'>
					<a href='#' class='dropdown-toggle' data-toggle='dropdown'>Postergaciones <b class='caret'></b></a>
					<ul class='dropdown-menu'>
						<form id='form-'>
							<div class='form-group'>
							<label for='n_start".$id."' >Nueva fecha<label>
							<input id='n_start".$id."' class='form-control' name='new_date' type='date' />
							</div>
							<div class='form-group'>
							<label for='n_end".$id."' >Nueva fecha final<label>
							<input id='n_end".$id."' class='form-control' name='new_date' type='date' />
							</div>
						<form>
						<li data-inputinit='n_start$id' data-inputend='n_end$id' onclick='postergacion($id,this);'><div class='btn btn-primary'>postergar curso</div></li>
					</ul>
				</li>
				</ul>";
	}

    public function index(){
    	if ($this->nativesession->get('tipo')=='admin') {
			$identidad["rutaimagen"]="/dist/img/avatar5.png";
			$identidad["nombres"]=$this->nativesession->get('acceso');
			$opciones["rutaimagen"]=$identidad["rutaimagen"];
			$opciones["menu"]=$this->opciones->segun($this->Permiso_model->lista($this->nativesession->get('idUsuario')),'Programas');
			$data['cabecera']=$this->load->view('adminlte/linksHead','',TRUE);
			$data['footer']=$this->load->view('adminlte/scriptsFooter','',TRUE);
			$data["mainSidebar"]=$this->load->view('adminlte/main-sideBar',$opciones,TRUE);
			$data['mainHeader']=$this->load->view('adminlte/mainHeader',array("identity"=>$identidad),TRUE);
			$this->load->view('dashboard_programa',$data);
		}else
		{
			redirect('administracion/login');
		}

	}
	
	public function viewCalendar(){
		if ($this->nativesession->get('tipo')=='admin') {
			$identidad["rutaimagen"]="/dist/img/avatar5.png";
			$identidad["nombres"]=$this->nativesession->get('acceso');
			$opciones["rutaimagen"]=$identidad["rutaimagen"];
			$opciones["menu"]=$this->opciones->segun($this->Permiso_model->lista($this->nativesession->get('idUsuario')),'Programas');
			$data['cabecera']=$this->load->view('adminlte/linksHead','',TRUE);
			$data['footer']=$this->load->view('adminlte/scriptsFooter','',TRUE);
			$data["mainSidebar"]=$this->load->view('adminlte/main-sideBar',$opciones,TRUE);
			$data['mainHeader']=$this->load->view('adminlte/mainHeader',array("identity"=>$identidad),TRUE);
			$this->load->view('dashboard_programa_calendar',$data);
		}else
		{
			redirect('administracion/login');
		}
	}

    public function get($id){
    	$result=$this->Programa_model->getById($id);
    	$array=$this->mihelper->resultToArray($result);

    	echo json_encode($array);
    }


    public function insertar(){
  		$nombre=$this->input->post('nnombre');
		$duracion=$this->input->post('nduracion');
		$costo_total=$this->input->post('ncosto');
		$vacantes=$this->input->post('nvacantes');
		$fecha_inicio=$this->input->post('nfecha_inicio');
		$fecha_final=$this->input->post('nfecha_final');
		$idTipo_curso=$this->input->post('nidTipo_curso');
		$numeracion=$this->input->post('nnumeracion');

		$this->Programa_model->insertar($nombre,$duracion,$costo_total,$vacantes,$fecha_inicio,$fecha_final,$idTipo_curso,$numeracion);
		if($this->db->affected_rows() > 0)
		{
		    // Code here after successful insert
		    echo "Se agrego el programa correctamente"; // to the controller
		}else{
			echo "No se pudo agregar correctamente";
		}

    }


    public function actualizar(){
    	$id_curso=$this->input->post('id_curso');
    	$nombre=$this->input->post('nombre');
    	$numeracion=$this->input->post('numeracion');
		$duracion=$this->input->post('duracion');
		$costo_total=$this->input->post('costo');
		$vacantes=$this->input->post('vacantes');
		$fecha_inicio=$this->input->post('fecha_inicio');
		$fecha_final=$this->input->post('fecha_final');
		$idTipo_curso=$this->input->post('idTipo_curso');

		if ($this->Programa_model->update($nombre,$id_curso,$duracion,$costo_total,$vacantes,$fecha_inicio,$fecha_final,$idTipo_curso,$numeracion)=='1') {
			//salida
			echo "Se guardo correctamente";
		}else{
			echo "No se pudo guardar correctamente";
		}


    }

    public function activar(){
    	$id_curso=$this->input->post('id_curso');
    	if ($this->Programa_model->activar($id_curso)=='1') {
    		echo "Correcto";
    	}else{
    		echo "Ocurrio un error";
    	}
    	  
    }


    public function desactivar(){
    	$id_curso=$this->input->post('id_curso');
    	if ($this->Programa_model->desactivar($id_curso)=='1') {
    		echo "Correcto";
    	}else{
    		echo "Ocurrio un error";
    	}
	}
	
	public function postergar(){
		$programa_id=$this->input->post('programa_id');
		$nueva_fecha_inicio=$this->input->post('nueva_fecha');
		$nueva_fecha_final=$this->input->post('nueva_fecha_final');
		
		$this->response($this->Programa_model->postergar($programa_id,$nueva_fecha_inicio,$nueva_fecha_final));
	}

	public function html_link($id_programa){
		$link_base=base_url()."registro?dp=".$id_programa;
		return "<ul class=''>
		<li class='dropdown'>
			<a href='#' class='dropdown-toggle' data-toggle='dropdown'>Link registro directo <b class='caret'></b></a>

			<ul class='dropdown-menu' onclick='copy_clipboard(this)' data-url='$link_base'>
			
				$link_base
			</ul>
		</li>
		</ul>";
	}
}
