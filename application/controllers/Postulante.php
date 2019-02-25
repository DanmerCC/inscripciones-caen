<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Postulante extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('Nativesession');
	}

	public function index()
	{
		if($this->nativesession->get("estado")=="logeado"){

			$this->load->model('Alumno_model');
			$alumno=$this->Alumno_model->all($this->nativesession->get("idAlumno"));

			if($alumno->num_rows()==1){
				$identity=array();

				if(file_exists(CC_BASE_PATH."/files/foto/".$this->nativesession->get("dni").".jpg")){
					$identity['rutaimagen']="data:image/jpg;base64,".base64_encode(file_get_contents(CC_BASE_PATH."/files/foto/".$this->nativesession->get("dni").".jpg"));
					$data['rutaimagen']="data:image/jpg;base64,".base64_encode(file_get_contents(CC_BASE_PATH."/files/foto/".$this->nativesession->get("dni").".jpg"));

				}else if(file_exists(CC_BASE_PATH."/files/foto/".$this->nativesession->get("dni").".png")){
					$identity['rutaimagen']="data:image/png;base64,".base64_encode(file_get_contents(CC_BASE_PATH."/files/foto/".$this->nativesession->get("dni").".png"));
					$data['rutaimagen']="data:image/png;base64,".base64_encode(file_get_contents(CC_BASE_PATH."/files/foto/".$this->nativesession->get("dni").".png"));

				}else if(file_exists(CC_BASE_PATH."/files/foto/".$this->nativesession->get("dni").".gif")){
					$identity['rutaimagen']="data:image/gif;base64,".base64_encode(file_get_contents(CC_BASE_PATH."/files/foto/".$this->nativesession->get("dni").".gif"));
					$data['rutaimagen']="data:image/gif;base64,".base64_encode(file_get_contents(CC_BASE_PATH."/files/foto/".$this->nativesession->get("dni").".gif"));
					
				}else{
					$identity['rutaimagen']="dist/img/avatar5.png";
					$data['rutaimagen']="dist/img/avatar5.png";
				}

				$result=[];
				$i=0;

				foreach ($alumno->result_array() as $row){
		            $result[$i]=$row;
        		}

                $data["hasCvFile"]=file_exists(CC_BASE_PATH."/files/cvs/".$this->nativesession->get("dni").".pdf");
                
				$identity["nombres"]=$result[0]["nombres"];
				$this->load->model('Pais_model');
				$data['cabecera']=$this->load->view('adminlte/linksHead','',TRUE);
				$data['footer']=$this->load->view('adminlte/scriptsFooter','',TRUE);
				$data['mainHeader']=$this->load->view('adminlte/mainHeader',array("identity"=>$identity),TRUE);

				$data["lista"]=$result[$i];
				$data["nacionalidad"]=$result[0]["nacionalidad"];
				$data["paises"]=$this->Pais_model->all();
				$opciones["rutaimagen"]=$identity["rutaimagen"];
				$opciones["menu"]=[
					[
					"text"=>"Mi informacion",
					"submenu"=>[
							[
								"text"=>"Informacion Personal",
								"atributos"=>"id='aInfPersonal' data-toggle='collapse' data-parent='#accordion' href='#collapse1' class='default-click'",
								"default"=>"default"
							],
							[
								"text"=>"Laboral",
								"atributos"=>"id='aInfAcademica' data-toggle='collapse' data-parent='#accordion' href='#collapse2'"
							],
							[
								"text"=>"Documentos",
								"atributos"=>"id='aDocs' data-toggle='collapse' data-parent='#accordion' href='#collapse9'"
							],
							[
								"text"=>"Formatos",
								"atributos"=>"id='formatesPanel' data-toggle='collapse' data-parent='#accordion' href='#collapse10'"
							],
							[
								"text"=>"Academica",
								"atributos"=>"id='aInfLaboral' data-toggle='collapse' data-parent='#accordion' href='#collapse3'"
							],
							[
								"text"=>"Salud",
								"atributos"=>"id='aInfSalud' data-toggle='collapse' data-parent='#accordion' href='#collapse7'"
							],
							[
								"text"=>"Referencias",
								"atributos"=>"id='aInfReferencias' data-toggle='collapse' data-parent='#accordion' href='#collapse6'"
							]
						],
					"active"=>true
					],
					[
					"text"=>"Mis solicitudes",
					"submenu"=>[
							[
								"text"=>"Todas",
								"atributos"=>"id='aSolicitudes' data-toggle='collapse' data-parent='#accordion' href='#collapse8'"
							]
						],
					"active"=>true
					],
				];
				$data["mainSidebar"]=$this->load->view('adminlte/main-sideBar',$opciones,TRUE);
				$this->load->view('profile',$data);

			}else{
				$data["heading"]="No has iniciado sesion";
                $data["message"]="Redireccionando al Login ...";
                $data["seconds"]="2";
                $data["url"]="/login";
                $this->load->view('errors/custom/flash_msg',$data);
			}

		}else{
			//No tiene una session iniciada
			redirect(base_url().'login','refresh');
		}


	}

	public function cerrarSession(){
		$this->nativesession->destroy();
		redirect(base_url().'login','refresh');
	}

//*verificacion de login*/
	public function verificacion(){
		
		$user=$this->input->post('usuario');
		$password=$this->input->post('password');

		if((!isset($user)||!isset($password))){
			redirect(base_url().'login', 'refresh');
			die();
		}
		
		if((($user=="")||($password==""))){
			redirect(base_url().'login', 'refresh');
			die();
		}

		if((!isset($user)||!isset($password))){
			redirect(base_url().'login', 'refresh');
			die();
		}
		
		if((($user=="")||($password==""))){
			redirect(base_url().'login', 'refresh');
			die();
		}

		$this->db->select('alumno.documento,id,alumno.documento,acceso,password,alumno,tipo,alumno.id_alumno as id_alumno');
		$this->db->from('usuario');
		$this->db->join('alumno', 'usuario.alumno = alumno.id_alumno');
		$this->db->where('usuario.acceso',$user);
		$result = $this->db->get();

		//$result=$this->db->query('SELECT alumno.documento,id,acceso,password,alumno from usuario left join alumno on usuario.alumno = alumno.id_alumno')->get();
		if ($result->num_rows() == 1) {
			if(password_verify($password,$result->result()[0]->password)){
				if ($result->result()[0]->tipo=="admin") {
					redirect(base_url().'administracion/login', 'refresh');
									
				}else{
					/*Estableciendo variables de session*/
					//$this->nativesession->destroy();
					$this->nativesession->regenerateId();
					$this->nativesession->set('idAlumno',$result->result()[0]->id_alumno);
					$this->nativesession->set('idUsuario',$result->result()[0]->id);
					$this->nativesession->set('dni',$result->result()[0]->documento);
					$this->nativesession->set('estado','logeado');
					$this->nativesession->set('tipo',$result->result()[0]->tipo);
					redirect(base_url().'postulante', 'refresh');
				}
			}else{
				echo "<script>".
		              "alert('Datos incorrectos');".
		              "window.location.assign('".base_url("/login")."')".
		          "</script>";
		          //header("Refresh: 5; url=".base_rul()."login");
        		redirect(base_url().'login', 'refresh');
			}
        }else{
        	//$this->session->set_flashdata('correcto', 'Datos incorrectos');
        	//lista general
        	redirect(base_url().'login', 'refresh');
        }

	}


	public function cargaPersonal(){

		//Ruta donde se guardan los ficheros
        $config['upload_path'] = CC_BASE_PATH.'/files/foto/';
        
       	//Tipos de ficheros permitidos
        $config['allowed_types'] = 'gif|jpg|png';
		$config['overwrite'] = true;
        //nombre de imagen
        $config['file_name'] = $this->nativesession->get("dni");
         
       	//Se pueden configurar aun mas parámetros.
       	//Cargamos la librería de subida y le pasamos la configuración
       	$dni= $this->nativesession->get("dni");
		if (!empty($_FILES['file']['name'])) {
			if (file_exists(CC_BASE_PATH."/files/foto/".$dni.".jpg")) {
	        	unlink(CC_BASE_PATH."/files/foto/".$dni.".jpg");
	        }

	        if (file_exists(CC_BASE_PATH."/files/foto/".$dni.".png")) {
	        	unlink(CC_BASE_PATH."/files/foto/".$dni.".png");
	        }
		}

        $this->load->library('upload', $config);
        $error=null;
 
        if(!$this->upload->do_upload('file')){

            /*Si al subirse hay algún error lo meto en un array para pasárselo a la vista*/
                $error=array('error' => $this->upload->display_errors());

                //$this->load->view('subir_view', $error);
                //echo "error al subir el archivo";
                //redirect(base_url().'postulante', 'refresh');
        }else{
            //Datos del fichero subido
            $datos["img"]=$this->upload->data();
			error_reporting(E_ALL);
			ini_set('display_errors', '1');
            //Podemos acceder a todas las propiedades del fichero subido 
            $datos["img"]["file_name"];
			
			$dir = 'publicfiles/foto';
			//Copy momentarily
			if(is_dir($dir)){
				if(strpos($datos["img"]["full_path"], '.') !== 0){
					//Copio el archivo manteniendo el mismo nombre en la nueva carpeta
					copy($datos["img"]["full_path"], 'publicfiles/foto'.'/'.$datos["img"]["file_name"]);
					//echo $datos["img"]["full_path"];
					//exit;
				}
			}
			
			
            //Cargamos la vista y le pasamos los datos
            //para asegurarse que la imagen nueva se cargue en la vista se agregara un header
            header("Cache-Control: no-cache, must-revalidate");
            header("Expires: Sat, 1 Jul 2000 5:00:00 GMT");
        }

		$id=$this->nativesession->get("idAlumno");
		$grado_profesion=$this->input->post('grado_profesion');
		$apellido_paterno=$this->input->post('apellido_paterno');
		$apellido_materno=$this->input->post('apellido_materno');
		$tipoDocumento=$this->input->post('tipoDocumento');
		$nombres=$this->input->post('nombres');
		$estado_civil=$this->input->post('estado_civil');
		$fecha_nac=$this->input->post('fecha_nac');
		$telefono_casa=$this->input->post('telefono_casa');
		$celular=$this->input->post('celular');
		$email=$this->input->post('email');
		$distrito_nac=$this->input->post('distrito_nac');
		$provincia=$this->input->post('provincia');
		$departamento=$this->input->post('departamento');
		$direccion=$this->input->post('direccion');
		$interior=$this->input->post('interior');
		$distrito=$this->input->post('distrito');
		$nacionalidad=$this->input->post('nacionalidad');
		$grado_militar=$this->input->post('grado_militar');
		$plana_militar=$this->input->post('plana_militar');
		$cip_militar=$this->input->post('cip_militar');
		$situacion_militar=$this->input->post('situacion_militar');


		$si_militar=($this->input->post('si_militar')=='1');

		$this->load->model('Alumno_model');
		$this->Alumno_model->updateInformacionPersonal($id,
					$grado_profesion,
					$apellido_paterno,
					$apellido_materno,
					$nombres,
					$tipoDocumento,
					$estado_civil,
					$fecha_nac,
					$telefono_casa,
					$celular,
					$email,
					$distrito_nac,
					$provincia,
					$departamento,
					$direccion,
					$interior,
					$distrito,
					$nacionalidad,//*aqui
					$grado_militar,
					$plana_militar,
					$cip_militar,
					$situacion_militar,
					$si_militar
				);
		redirect(base_url().'postulante', 'refresh');

	}

	public function cargaLaboral(){

		$id=$this->nativesession->get('idAlumno');

		$lugar_trabajo=$this->input->post('lugar_trabajo');
		$area_direccion=$this->input->post('area_direccion');
		$tiempo_servicio=$this->input->post('tiempo_servicio');
		$cargo_actual=$this->input->post('cargo_actual');
		$direccion_laboral=$this->input->post('direccion_laboral');
		$distrito_laboral=$this->input->post('distrito_laboral');
		$telefono_laboral=$this->input->post('telefono_laboral');
		$anexo_laboral=$this->input->post('anexo_laboral');
		$experiencia_laboral1=$this->input->post('experiencia_laboral1');
		$fecha_inicio1=$this->input->post('fecha_inicio1');
		$fecha_fin1=$this->input->post('fecha_fin1');
		$experiencia_laboral2=$this->input->post('experiencia_laboral2');
		$fecha_inicio2=$this->input->post('fecha_inicio2');
		$fecha_fin2=$this->input->post('fecha_fin2');
		$curso_caen=$this->input->post('curso_caen');
		$indicar1=$this->input->post('indicar1');
		$curso_maestria=$this->input->post('curso_maestria');
		$indicar2=$this->input->post('indicar2');

		$situacion_laboral=$this->input->post('situacion_laboral');

		$this->load->model('Alumno_model');
		$this->Alumno_model->updateInformacionLaboral($id,
		$lugar_trabajo,
		$area_direccion,
		$tiempo_servicio,
		$cargo_actual,
		$direccion_laboral,
		$distrito_laboral,
		$telefono_laboral,
		$anexo_laboral,
		$experiencia_laboral1,
		$fecha_inicio1,
		$fecha_fin1,
		$experiencia_laboral2,
		$fecha_inicio2,
		$fecha_fin2,
		$curso_caen,
		$indicar1,
		$curso_maestria,
		$indicar2,
		$situacion_laboral);

		redirect(base_url().'postulante', 'refresh');


	}

	public function cargaAcademico(){

		$id=$this->nativesession->get('idAlumno');

		$titulo_obtenido=$this->input->post('titulo_obtenido');
		$universidad_titulo=$this->input->post('universidad_titulo');
		$fecha_titulo=$this->input->post('fecha_titulo');
		$grado_obtenido=$this->input->post('grado_obtenido');
		$universidad_grado=$this->input->post('universidad_grado');
		$fecha_grado=$this->input->post('fecha_grado');
		$maestria_obtenida=$this->input->post('maestria_obtenida');
		$universidad_maestria=$this->input->post('universidad_maestria');
		$fecha_maestria=$this->input->post('fecha_maestria');
		$doctorado_obtenido=$this->input->post('doctorado_obtenido');
		$universidad_doctor=$this->input->post('universidad_doctor');
		$fecha_doctor=$this->input->post('fecha_doctor');

		$this->load->model('Alumno_model');
		$this->Alumno_model->updateInformacionAcademicos($id,$titulo_obtenido,
		$universidad_titulo,
		$fecha_titulo,
		$grado_obtenido,
		$universidad_grado,
		$fecha_grado,
		$maestria_obtenida,
		$universidad_maestria,
		$fecha_maestria,
		$doctorado_obtenido,
		$universidad_doctor,
		$fecha_doctor);
		redirect(base_url().'postulante', 'refresh');
	}

	public function cargaSalud(){

		$id=$this->nativesession->get('idAlumno');
		$sufre_enfermedad=$this->input->post('sufre_enfermedad');
		$arrayTipoEnfermedad=$this->input->post('arrayTipoEnfermedad');
		$seguro_medico=$this->input->post('seguro_medico');
		$nombre_seguro=$this->input->post('nombre_seguro');
		$telefono_seguro=$this->input->post('telefono_seguro');
		$emergencia_familiar=$this->input->post('emergencia_familiar');
		$telefono_familiar=$this->input->post('telefono_familiar');
		$parentesco=$this->input->post('parentesco');


		$temp=array();

		$temp["Asma"]=$arrayTipoEnfermedad[0];
		$temp["Arterial"]=$arrayTipoEnfermedad[1];
		$temp["Diabetes"]=$arrayTipoEnfermedad[2];
		$temp["Cancer"]=$arrayTipoEnfermedad[3];
		$temp["otros"]=$arrayTipoEnfermedad[4];

		$tipo_enfermedad=json_encode($temp);


		//json_encode(
		//$tipo_enfermedad
		$this->load->model('Alumno_model');
		$this->Alumno_model->updateInformacionSalud($id,
		$sufre_enfermedad,
		$tipo_enfermedad,
		$seguro_medico,
		$nombre_seguro,
		$telefono_seguro,
		$emergencia_familiar,
		$telefono_familiar,
		$parentesco);

		redirect(base_url().'postulante', 'refresh');
	}

	public function cargaReferencia(){

		$id=$this->nativesession->get('idAlumno');

		$referencia_personal1=$this->input->post('referencia_personal1');
		$referencia_personal2=$this->input->post('referencia_personal2');

		$this->load->model('Alumno_model');
		$this->Alumno_model->updateInformacionReferencias($id,$referencia_personal1,$referencia_personal2);

		redirect(base_url().'postulante', 'refresh');
	}

	public function solicitud(){

		$this->load->model('Solicitud_model');

		$alumno=$this->nativesession->get('idAlumno');
		$programa=$this->input->post('programa');

		if($this->Solicitud_model->existe($alumno,$programa)){

			$msj=null;
			
			$msj['heading'] = "Ya tienes una solicitud para ese programa";
			$msj['message'] = "Solo se permite una solicitud por programa"; 

			$this->session->set_flashdata('mensajes', $msj);

			redirect(base_url().'mensaje', 'refresh');
		}else{
			$tipo_financiamiento=$this->input->post('tipoFinan');
			$this->load->model('Alumno_model');
			$this->Alumno_model->nuevaSolicitud($programa,$alumno,$tipo_financiamiento);

			redirect(base_url().'postulante', 'refresh');
		}

	}
	
	
	public function uploadCv(){

		$config['upload_path'] = CC_BASE_PATH.'/files/cvs/';
        
       	//Tipos de ficheros permitidos
        $config['allowed_types'] = 'pdf';
		$config['overwrite'] = true;
        //nombre de imagen
		$config['file_name'] = $this->nativesession->get("dni");
		
		$this->load->library('upload',$config);
		header('Content-Type: application/json');
		if(!$this->upload->do_upload('cv')){
            /*Si al subirse hay algún error lo meto en un array para pasárselo a la vista*/
			$error=array('error' => $this->upload->display_errors());
			//echo  var_dump($error);
			//$this->load->view('subir_view', $error);
			//echo "error al subir el archivo";
			//redirect(base_url().'postulante', 'refresh');
			$result=[
				"content"=>[],
				"status"=>"ERROR_UPDATING_FILE",
				 "error"=>$error
			];
			echo json_encode($result,JSON_UNESCAPED_UNICODE);
        }else{
            //Datos del fichero subido
            $datos["img"]=$this->upload->data();
 
            //Podemos acceder a todas las propiedades del fichero subido 
            $datos["img"]["file_name"];

			//echo var_dump($datos);

            //Cargamos la vista y le pasamos los datos
            //para asegurarse que la imagen nueva se cargue en la vista se agregara un header
            //header("Cache-Control: no-cache, must-revalidate");
			//header("Expires: Sat, 1 Jul 2000 5:00:00 GMT");
			$result=[
				"content"=>[
					"file_name"=> $datos["img"]["file_name"]
				],
				"status"=>"OK"
			];
			echo json_encode($result,JSON_UNESCAPED_UNICODE);
        }
	}

	public function uploadDeclaracionJurada(){

		$config['upload_path'] = CC_BASE_PATH.'/files/djs/';
        
       	//Tipos de ficheros permitidos
        $config['allowed_types'] = 'pdf';
		$config['overwrite'] = true;
        //nombre de imagen
		$config['file_name'] = $this->nativesession->get("dni");
		
		$this->load->library('upload',$config);
		header('Content-Type: application/json');
		if(!$this->upload->do_upload('cv')){
            /*Si al subirse hay algún error lo meto en un array para pasárselo a la vista*/
			$error=array('error' => $this->upload->display_errors());
			//echo  var_dump($error);
			//$this->load->view('subir_view', $error);
			//echo "error al subir el archivo";
			//redirect(base_url().'postulante', 'refresh');
			$result=[
				"content"=>[],
				"status"=>"ERROR_UPDATING_FILE"
			];
			echo json_encode($result,JSON_UNESCAPED_UNICODE);
        }else{
            //Datos del fichero subido
            $datos["img"]=$this->upload->data();
 
            //Podemos acceder a todas las propiedades del fichero subido 
            $datos["img"]["file_name"];

			//echo var_dump($datos);

            //Cargamos la vista y le pasamos los datos
            //para asegurarse que la imagen nueva se cargue en la vista se agregara un header
            //header("Cache-Control: no-cache, must-revalidate");
			//header("Expires: Sat, 1 Jul 2000 5:00:00 GMT");
			$result=[
				"content"=>[
					"file_name"=> $datos["img"]["file_name"]
				],
				"status"=>"OK"
			];
			echo json_encode($result,JSON_UNESCAPED_UNICODE);
        }
	}

	public function uploadCopiaDni(){

		$config['upload_path'] = CC_BASE_PATH.'/files/dni/';
        
       	//Tipos de ficheros permitidos
        $config['allowed_types'] = 'pdf';
		$config['overwrite'] = true;
        //nombre de imagen
		$config['file_name'] = $this->nativesession->get("dni");
		
		$this->load->library('upload',$config);
		header('Content-Type: application/json');
		if(!$this->upload->do_upload('cv')){
            /*Si al subirse hay algún error lo meto en un array para pasárselo a la vista*/
			$error=array('error' => $this->upload->display_errors());
			//echo  var_dump($error);
			//$this->load->view('subir_view', $error);
			//echo "error al subir el archivo";
			//redirect(base_url().'postulante', 'refresh');
			$result=[
				"content"=>[],
				"status"=>"ERROR_UPDATING_FILE",
				"error"=>$error
			];
			echo json_encode($result,JSON_UNESCAPED_UNICODE);
		}elseif($this->nativesession->get("estado")!="logeado"){
			$result=[
				"content"=>[],
				"status"=>"UNAUTHORIZED"
			];
			echo json_encode($result,JSON_UNESCAPED_UNICODE);
		}
		else{
            //Datos del fichero subido
            $datos["img"]=$this->upload->data();
 
            //Podemos acceder a todas las propiedades del fichero subido 
            $datos["img"]["file_name"];
			
			//echo var_dump($datos);

            //Cargamos la vista y le pasamos los datos
            //para asegurarse que la imagen nueva se cargue en la vista se agregara un header
            //header("Cache-Control: no-cache, must-revalidate");
			//header("Expires: Sat, 1 Jul 2000 5:00:00 GMT");
			$result=[
				"content"=>[
					"file_name"=> $datos["img"]["file_name"]
				],
				"status"=>"OK"
			];
			echo json_encode($result,JSON_UNESCAPED_UNICODE);
        }
	}

	public function uploadCopiaBachiller(){

		$config['upload_path'] = CC_BASE_PATH.'/files/bachiller/';
        
       	//Tipos de ficheros permitidos
        $config['allowed_types'] = 'pdf';
		$config['overwrite'] = true;
        //nombre de imagen
		$config['file_name'] = $this->nativesession->get("dni");
		
		$this->load->library('upload',$config);
		header('Content-Type: application/json');
		if(!$this->upload->do_upload('cv')){
            /*Si al subirse hay algún error lo meto en un array para pasárselo a la vista*/
			$error=array('error' => $this->upload->display_errors());
			//echo  var_dump($error);
			//$this->load->view('subir_view', $error);
			//echo "error al subir el archivo";
			//redirect(base_url().'postulante', 'refresh');
			$result=[
				"content"=>[],
				"status"=>"ERROR_UPDATING_FILE",
				"error"=>$error
			];
			echo json_encode($result,JSON_UNESCAPED_UNICODE);
		}elseif($this->nativesession->get("estado")!="logeado"){
			$result=[
				"content"=>[],
				"status"=>"UNAUTHORIZED"
			];
			echo json_encode($result,JSON_UNESCAPED_UNICODE);
		}
		else{
            //Datos del fichero subido
            $datos["img"]=$this->upload->data();
 
            //Podemos acceder a todas las propiedades del fichero subido 
            $datos["img"]["file_name"];
			
			//echo var_dump($datos);

            //Cargamos la vista y le pasamos los datos
            //para asegurarse que la imagen nueva se cargue en la vista se agregara un header
            //header("Cache-Control: no-cache, must-revalidate");
			//header("Expires: Sat, 1 Jul 2000 5:00:00 GMT");
			$result=[
				"content"=>[
					"file_name"=> $datos["img"]["file_name"]
				],
				"status"=>"OK"
			];
			echo json_encode($result,JSON_UNESCAPED_UNICODE);
        }
	}

	public function uploadCopiaMaestria(){

		$config['upload_path'] = CC_BASE_PATH.'/files/maestria/';
        
       	//Tipos de ficheros permitidos
        $config['allowed_types'] = 'pdf';
		$config['overwrite'] = true;
        //nombre de imagen
		$config['file_name'] = $this->nativesession->get("dni");
		
		$this->load->library('upload',$config);
		header('Content-Type: application/json');
		if(!$this->upload->do_upload('cv')){
            /*Si al subirse hay algún error lo meto en un array para pasárselo a la vista*/
			$error=array('error' => $this->upload->display_errors());
			//echo  var_dump($error);
			//$this->load->view('subir_view', $error);
			//echo "error al subir el archivo";
			//redirect(base_url().'postulante', 'refresh');
			$result=[
				"content"=>[],
				"status"=>"ERROR_UPDATING_FILE",
				"error"=>$error
			];
			echo json_encode($result,JSON_UNESCAPED_UNICODE);
		}elseif($this->nativesession->get("estado")!="logeado"){
			$result=[
				"content"=>[],
				"status"=>"UNAUTHORIZED"
			];
			echo json_encode($result,JSON_UNESCAPED_UNICODE);
		}
		else{
            //Datos del fichero subido
            $datos["img"]=$this->upload->data();
 
            //Podemos acceder a todas las propiedades del fichero subido 
            $datos["img"]["file_name"];
			
			//echo var_dump($datos);

            //Cargamos la vista y le pasamos los datos
            //para asegurarse que la imagen nueva se cargue en la vista se agregara un header
            //header("Cache-Control: no-cache, must-revalidate");
			//header("Expires: Sat, 1 Jul 2000 5:00:00 GMT");
			$result=[
				"content"=>[
					"file_name"=> $datos["img"]["file_name"]
				],
				"status"=>"OK"
			];
			echo json_encode($result,JSON_UNESCAPED_UNICODE);
        }
	}

	public function uploadCopiaDoctorado(){

		$config['upload_path'] = CC_BASE_PATH.'/files/doctorado/';
        
       	//Tipos de ficheros permitidos
        $config['allowed_types'] = 'pdf';
		$config['overwrite'] = true;
        //nombre de imagen
		$config['file_name'] = $this->nativesession->get("dni");
		
		$this->load->library('upload',$config);
		header('Content-Type: application/json');
		if(!$this->upload->do_upload('cv')){
            /*Si al subirse hay algún error lo meto en un array para pasárselo a la vista*/
			$error=array('error' => $this->upload->display_errors());
			//echo  var_dump($error);
			//$this->load->view('subir_view', $error);
			//echo "error al subir el archivo";
			//redirect(base_url().'postulante', 'refresh');
			$result=[
				"content"=>[],
				"status"=>"ERROR_UPDATING_FILE",
				"error"=>$error
			];
			echo json_encode($result,JSON_UNESCAPED_UNICODE);
		}elseif($this->nativesession->get("estado")!="logeado"){
			$result=[
				"content"=>[],
				"status"=>"UNAUTHORIZED"
			];
			echo json_encode($result,JSON_UNESCAPED_UNICODE);
		}
		else{
            //Datos del fichero subido
            $datos["img"]=$this->upload->data();
 
            //Podemos acceder a todas las propiedades del fichero subido 
            $datos["img"]["file_name"];
			
			//echo var_dump($datos);

            //Cargamos la vista y le pasamos los datos
            //para asegurarse que la imagen nueva se cargue en la vista se agregara un header
            //header("Cache-Control: no-cache, must-revalidate");
			//header("Expires: Sat, 1 Jul 2000 5:00:00 GMT");
			$result=[
				"content"=>[
					"file_name"=> $datos["img"]["file_name"]
				],
				"status"=>"OK"
			];
			echo json_encode($result,JSON_UNESCAPED_UNICODE);
        }
	}

	public function uploadSolicitudInscripcion(){
		$config['upload_path'] = CC_BASE_PATH.'/files/sInscripcion/';
        
       	//Tipos de ficheros permitidos
        $config['allowed_types'] = 'pdf';
		$config['overwrite'] = true;
        //nombre de imagen
		$config['file_name'] = $this->nativesession->get("dni");
		
		$this->load->library('upload',$config);
		header('Content-Type: application/json');
		if(!$this->upload->do_upload('cv')){
            /*Si al subirse hay algún error lo meto en un array para pasárselo a la vista*/
			$error=array('error' => $this->upload->display_errors());
			//echo  var_dump($error);
			//$this->load->view('subir_view', $error);
			//echo "error al subir el archivo";
			//redirect(base_url().'postulante', 'refresh');
			$result=[
				"content"=>[],
				"status"=>"ERROR_UPDATING_FILE",
				"error"=>$error
			];
			echo json_encode($result,JSON_UNESCAPED_UNICODE);
		}elseif($this->nativesession->get("estado")!="logeado"){
			$result=[
				"content"=>[],
				"status"=>"UNAUTHORIZED"
			];
			echo json_encode($result,JSON_UNESCAPED_UNICODE);
		}
		else{
            //Datos del fichero subido
            $datos["img"]=$this->upload->data();
 
            //Podemos acceder a todas las propiedades del fichero subido 
            $datos["img"]["file_name"];
			
			//echo var_dump($datos);

            //Cargamos la vista y le pasamos los datos
            //para asegurarse que la imagen nueva se cargue en la vista se agregara un header
            //header("Cache-Control: no-cache, must-revalidate");
			//header("Expires: Sat, 1 Jul 2000 5:00:00 GMT");
			$result=[
				"content"=>[
					"file_name"=> $datos["img"]["file_name"]
				],
				"status"=>"OK"
			];
			echo json_encode($result,JSON_UNESCAPED_UNICODE);
        }
	}

	public function downloadCv(){

		$path = CC_BASE_PATH.'/files/cvs/'.$this->nativesession->get("dni").".pdf";
		//header('Content-Description: File Transfer');
		//header('Content-Type: application/pdf');
		//header('Content-Transfer-Encoding: binary');
		if(file_exists($path)){
			$type = pathinfo($path, PATHINFO_EXTENSION);
			$data = file_get_contents($path);
			echo substr(base64_encode($data),0,-2);
			//$base64 = 'data:application/' . $type . ';base64,' . substr(base64_encode($data),0,-2);
			$base64 = 'data:application/' . $type . ';base64,' . base64_encode($data);
			echo $base64;
		}else
		{
			echo "error";
		}
		
	}
	
	public function stateOfProfileFiles(){
		$result=[];
		header('Content-Type: application/json');
		
		if($this->nativesession->get("estado")=="logeado"){
			$result=[
				"content"=>[
					"cv"=>file_exists(CC_BASE_PATH.'/files/cvs/'.$this->nativesession->get("dni").".pdf"),
					"dni"=>file_exists(CC_BASE_PATH.'/files/dni/'.$this->nativesession->get("dni").".pdf"),
					"dj"=>file_exists(CC_BASE_PATH.'/files/djs/'.$this->nativesession->get("dni").".pdf"),
					"bach"=>file_exists(CC_BASE_PATH.'/files/bachiller/'.$this->nativesession->get("dni").".pdf"),
					"maes"=>file_exists(CC_BASE_PATH.'/files/maestria/'.$this->nativesession->get("dni").".pdf"),
					"doct"=>file_exists(CC_BASE_PATH.'/files/doctorado/'.$this->nativesession->get("dni").".pdf"),
					"sins"=>file_exists(CC_BASE_PATH.'/files/sInscripcion/'.$this->nativesession->get("dni").".pdf"),
					"nameFiles"=>$this->nativesession->get("idAlumno")
				],
				"status"=>"OK"
				
			];
		}else{
			$result=[
				"content"=>[],
				"status"=>"UNAUTHORIZED"
			];
		}
		echo json_encode($result,JSON_UNESCAPED_UNICODE);
	}
	


}
