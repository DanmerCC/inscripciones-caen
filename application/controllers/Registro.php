<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Registro extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');

        //Load the captcha helper
        $this->load->helper('captcha');

        // Load session library
        $this->load->library('session');
        
        //Se crea randon de 5 para captcha y sesion
        $this->load->helper('string');
        $this->rand = random_string('alnum', 5);
        $this->load->model('Captcha_model');
    }

    public function index()
    {
        $data['cabecera'] = $this->load->view('adminlte/linksHead', '', true);
        $data['footer']   = $this->load->view('adminlte/scriptsFooter', '', true);
        $data['captcha'] = $this->generarCaptcha();
        $this->session->set_userdata('captcha', $this->rand);

        $this->load->view('register', $data);
    }

    public function generarCaptcha(){
        $font = 'AlfaSlabOne-Regular';
        $config = array(
            'word' => $this->rand,
            'img_path' => './captcha_images/',
            'img_url' => base_url().'captcha_images/',
            'font_path' => $font,
            'img_width' => '100',
            'img_height' => 50,
            'expiration' => 60,
            'font_size' => 20,

            'colors' => array(
                'background' => array(200,80,50),
                'border' => array(255,255,255),
                'text' => array(255,255,255),
                'grid' => array(0,40,40) 
            )
        );

        $captcha = create_captcha($config);
        $this->Captcha_model->saveCaptcha($captcha);
        return $captcha;
    }

    public function refresh(){
        $expiration = time()-60;
        $this->Captcha_model->deleteOldCaptcha($expiration);
        $data = $this->generarCaptcha();
        $this->session->unset_userdata('captchaCode');
        $this->session->set_userdata('captcha', $this->rand);

        echo $data['image'];
    }

    public function guardar()
    {
        //Si es diferente
        if($this->input->post('captcha') != $this->session->userdata('captcha')){
            $this->index();
        }else{
            $expiration = time()-60; //Limite de un minuto
            $ip = $this->input->ip_address();
            $captcha = $this->input->post('captcha');
    
            $this->Captcha_model->deleteOldCaptcha($expiration);
    
            $last = $this->Captcha_model->check($ip, $expiration, $captcha);
    
            if($last == 1){
                    $id_usuario_dni = $this->input->post('id');//el id por defecto sera el dni pero puede ser cambiado  cualquier otro

                    $nombre           = $this->input->post('nombre');
                    $apellido_paterno = $this->input->post('apellido_paterno');
                    $apellido_materno = $this->input->post('apellido_materno');
                    $password         = $this->input->post('password');
                    $email            = $this->input->post('email');
                    $celphone         = $this->input->post('celphone');
                    $programa_id      =$this->input->post('programa_id');
                    $tipoFinan          =$this->input->post('tipoFinan');

                    if($this->isNotSetArray([$id_usuario_dni,$email,$programa_id,$tipoFinan,$celphone])){
                        $data["heading"]="Ah ocurrido un error ";
                        $data["message"]="Su cuenta  no se registro intentelo nuevamente";
                        $data["seconds"]="4";
                        $data["url"]="/postulante";
                        echo $this->load->view('errors/custom/flash_msg',$data,TRUE);
                        echo "Error se detecto un valor nulo";
                        die();
                    }
                $ql = $this->db->select('documento')->from('alumno')->where('documento',$id_usuario_dni)->or_where('email',$email)->get();
                if ($ql->num_rows() > 0) {
                    $data["heading"]=" YA ESTA REGISTRADO";
                    $data["message"]="Ya existe un registro con el mismo numero de Numero de documento o correo electronico";
                    $data["seconds"]="5";
                    $data["url"]="/registro";
                    echo $this->load->view('errors/custom/flash_msg',$data,TRUE);
                    die();
                } else {

                    /*Captura de errores para primer registro*/
                    $this->load->model('Alumno_model');
                    $alumno = $this->Alumno_model->registrar($apellido_paterno, $apellido_materno, $nombre, $id_usuario_dni,$email,$celphone);
                    $this->load->model('User_model');
                    
                    //Agrega una solicitud
                    

                    if($this->User_model->registrar($id_usuario_dni, $email, $password, $alumno)){
                        $this->Alumno_model->nuevaSolicitud($programa_id, $alumno, $tipoFinan);
                        $data["heading"]="Se registro correctamente";
                        $data["message"]="Su cuenta  $id_usuario_dni a sido registrada correctamente";
                        $data["seconds"]="5";
                        $data["url"]="/postulante";
                        $this->load->view('errors/custom/flash_msg',$data);
                    }else{
                        $data["heading"]="Ah ocurrido un error ";
                        $data["message"]="Su cuenta no se registro intentelo nuevamente";
                        $data["seconds"]="4";
                        $data["url"]="/postulante";
                        $this->load->view('errors/custom/flash_msg',$data);
                    }
                    
                }
            }else{
                echo $success['Hola'];
            }
        }
    }

    private function isNotSetArray($array,$operator='and'){
        $result=false;
        for ($i=0; $i < count($array); $i++) { 
           if((!isset($array[$i]))||($array[$i]=="")||($array[$i]==NULL)){
               $result=true;
               //echo var_dump($array[$i]);
               //exit;
               break;
           }
        }
        return $result;
    }

    
    

}
