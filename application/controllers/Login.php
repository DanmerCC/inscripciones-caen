<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Nativesession');
		$this->load->helper('url');
		$this->load->library('form_validation');
		$this->load->model('Login_model');
		$this->load->library('email');
		$this->load->helper('security'); //Libreria para habilitar xss_clean
	}

	public function index()
	{
		$data['cabecera'] = $this->load->view('adminlte/linksHead',NULL,TRUE);
		$data['footer'] = $this->load->view('adminlte/scriptsFooter',NULL,TRUE);
		$data['action'] = "postulante/verificacion";
		$this->load->view('login',$data);
	}

	//Vista para recuperar contraseña. De aqui se enviara el correo
	public function recuperarPassword(){
		$data['cabecera'] = $this->load->view('adminlte/linksHead',NULL,TRUE);
		$data['footer'] = $this->load->view('adminlte/scriptsFooter',NULL,TRUE);
		$this->load->view('recover_password/recuperar_contrasena',$data);
	}

	//Funcion para enviar correo
	public function enviarCorreo(){		
		if(isset($_POST['email']) && !empty($_POST['email'])){
			//Primero compruebo si es el correo electrónico válido o no
			$this->form_validation->set_rules('email','Email Address','trim|required|min_length[6]|max_length[50]|valid_email|xss_clean');

			if ($this->form_validation->run() == FALSE) {
				$data['error'] = 'Por favor proporcione una dirección de correo electrónico válida';
				$data['cabecera'] = $this->load->view('adminlte/linksHead',NULL,TRUE);
				$data['footer'] = $this->load->view('adminlte/scriptsFooter',NULL,TRUE);
				$this->load->view('recover_password/recuperar_contrasena', $data);
			} else {
				$email = trim($this->input->post('email'));
				$result = $this->Login_model->validityEmail_Existence($email);
				
				if ($result) {
					$this->enviarPasswordEmail($email, $result);		
					$data['success'] = 'El correo ha sido enviado.';
					$data['cabecera'] = $this->load->view('adminlte/linksHead',NULL,TRUE);
					$data['footer'] = $this->load->view('adminlte/scriptsFooter',NULL,TRUE);
					$this->load->view('recover_password/recuperar_contrasena', $data);
				} else {
					$data['error'] = 'Dirección de correo no registrado o no tiene permitido el cambio de contraseña.';
					$data['cabecera'] = $this->load->view('adminlte/linksHead',NULL,TRUE);
					$data['footer'] = $this->load->view('adminlte/scriptsFooter',NULL,TRUE);
					$this->load->view('recover_password/recuperar_contrasena', $data);
				}
			}
		} else {
			$data['error'] = 'El campo de correo no debe estar vacío.';
			$data['cabecera'] = $this->load->view('adminlte/linksHead',NULL,TRUE);
			$data['footer'] = $this->load->view('adminlte/scriptsFooter',NULL,TRUE);
			$this->load->view('recover_password/recuperar_contrasena', $data);
		}	
	}

	//Funcion donde se configura el correo a enviar
	private function enviarPasswordEmail($email, $firstname){
		$configGmail = array(
			'protocol' => 'smtp',
			'smtp_host' => 'ssl://smtp.gmail.com',
			'smtp_port' => 465,
			'smtp_user' => 'no-reply@caen.edu.pe',
			'smtp_pass' => '1qazxsw2$123',
			'mailtype' => 'html',
			'charset' => 'utf-8',
			'newline' => "\r\n"
		); 
		
		$email_code = md5($this->config->item('salt') . $firstname);
		// $this->email->initialize($configGmail);
		$this->email->set_mailtype('html');
		$this->email->from($this->config->item('bot_email'), 'CAEN-EPG');
		$this->email->to($email);
		$this->email->subject('Por favor restablezca su contrasena de la intranet del CAEN-EPG');
		
		$message = 	'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
					"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"><html>
					<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
					</head><body>';
		$message .= '<p>Querido '.$firstname.',</p>';
		$message .= '<p>¡Queremos ayudarte a restablecer tu contrasena! Por favor haga <strong><a href="'.base_url().'login/restorepassword/'.$email.'/'.$email_code.'">click aqui</a></strong> para reestablecer tu password.</p>';
		$message .= '<p>Gracias</p>';
		$message .= '<p>El equipo de tecnologias del CAEN-EPG</p>';
		$message .= '</body></html>';
		
		$this->email->message($message);
		$this->email->send();
	}

	//Funcion para activar la vista de Reestablecer contraseña
	public function restablecerPassword($email, $email_code){
		if(isset($email, $email_code)){
			$email = trim($email);
			$email_hash = sha1($email . $email_code);
			$verified = $this->Login_model->verificarPassword($email, $email_code);
			
			if($verified){
				$data['email_hash'] = $email_hash;
				$data['email_code'] = $email_code;
				$data['email'] = $email;
				$data['cabecera'] = $this->load->view('adminlte/linksHead',NULL,TRUE);
				$data['footer'] = $this->load->view('adminlte/scriptsFooter',NULL,TRUE);
				$this->load->view('recover_password/restablecer_contrasena',$data);
			} else {
				$data['error'] = 'Hubo un problema con tu enlace. Por favor haga clic nuevamente o solicite restablecer su contraseña nuevamente.';
				$data['email'] = $email;
				$data['cabecera'] = $this->load->view('adminlte/linksHead',NULL,TRUE);
				$data['footer'] = $this->load->view('adminlte/scriptsFooter',NULL,TRUE);
				$this->load->view('recover_password/recuperar_contrasena', $data);
			}
		}
	}

	//Se hace la actualizacion del password
	public function updatePassword() {
		if(!isset($_POST['email'], $_POST['email_hash']) || $_POST['email_hash'] !== sha1($_POST['email'].$_POST['email_code'])){
			die("Error al actualizar su password");
		}
		$this->load->library('form_validation');

		$this->form_validation->set_rules('email_hash', 'Email Hash', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|max_length[50]|matches[password_conf]|xss_clean');
		$this->form_validation->set_rules('password_conf', 'Confirmed Password', 'trim|required|min_length[6]|max_length[50]|xss_clean');

		if($this->form_validation->run() == FALSE){
			$this->load->view('includes/header');
			$this->load->view('login/view_update_password');
			$this->load->view('includes/footer');
		}else{
			$result = $this->Login_model->updatePassword();

			if($result){
				$data['success'] = 'Su contraseña ha sido restablecido.';
				$data['cabecera'] = $this->load->view('adminlte/linksHead',NULL,TRUE);
				$data['footer'] = $this->load->view('adminlte/scriptsFooter',NULL,TRUE);
				$this->load->view('login',$data);
			} else {
				$data['error'] = 'Problemas para actualizar su password. Por favor contáctenos en: desarrollo.tic@caen.edu.pe';
				$data['email'] = $email;
				$data['cabecera'] = $this->load->view('adminlte/linksHead',NULL,TRUE);
				$data['footer'] = $this->load->view('adminlte/scriptsFooter',NULL,TRUE);
				$this->load->view('recover_password/recuperar_contrasena', $data);
			}
		}
	}
}
