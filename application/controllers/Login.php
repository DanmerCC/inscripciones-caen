<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index()
	{
		$this->load->helper('url');

		$data['cabecera'] = $this->load->view('adminlte/linksHead',NULL,TRUE);
		$data['footer'] = $this->load->view('adminlte/scriptsFooter',NULL,TRUE);
		$data['action'] = "postulante/verificacion";
		$this->load->view('login',$data);
	}

	public function recuperarcontrasena(){
		$data['cabecera'] = $this->load->view('adminlte/linksHead',NULL,TRUE);
		$data['footer'] = $this->load->view('adminlte/scriptsFooter',NULL,TRUE);
		$this->load->view('recover_password/recuperar_contrasena',$data);
	}

	public function enviarCorreo(){
		if(isset($_POST['email']) && !empty($_POST['email'])){
			$this->load->library('form_validation');
			//Primero compruebo si es el correo electrónico válido o no
			$this->form_validation->set_rules('email','Email Address','trim|required|min_length[6]|max_length[50]|valid_email|xss_clean');
			
			if ($this->form_validation->run() == FALSE) {
				$data['error'] = 'Por favor proporcione una dirección de correo electrónico válida';
				$data['cabecera'] = $this->load->view('adminlte/linksHead',NULL,TRUE);
				$data['footer'] = $this->load->view('adminlte/scriptsFooter',NULL,TRUE);
				$this->load->view('recover_password/recuperar_contrasena', $data);
				// $this->load->view('includes/header');
				// $this->load->view('recover_password/recuperar_contrasena', array('error' => 'Por favor proporcione una dirección de correo electrónico válida'));
				// $this->load->view('login/view_login', array('error' => 'Por favor proporcione una dirección de correo electrónico válida'));
				// $this->load->view('includes/footer');
			} else {
				$email = trim($this->input->post('email'));
				$result = $this->model_login->emailExists($email);
				
				if ($result) {
					$this->enviarPasswordEmail($email, $result);
					$data['email'] = $email;
					$data['cabecera'] = $this->load->view('adminlte/linksHead',NULL,TRUE);
					$data['footer'] = $this->load->view('adminlte/scriptsFooter',NULL,TRUE);
					$this->load->view('recover_password/recuperar_contrasena', $data);
				} else {
					$data['error'] = 'Dirección de correo no registrado.';
					$data['cabecera'] = $this->load->view('adminlte/linksHead',NULL,TRUE);
					$data['footer'] = $this->load->view('adminlte/scriptsFooter',NULL,TRUE);
					$this->load->view('recover_password/recuperar_contrasena', $data);
				}
			}
		} else {
			$data['success'] = 'El correo ha sido enviado.';
			$data['cabecera'] = $this->load->view('adminlte/linksHead',NULL,TRUE);
			$data['footer'] = $this->load->view('adminlte/scriptsFooter',NULL,TRUE);
			$this->load->view('recover_password/recuperar_contrasena', $data);
		}	
	}

	private function enviarPasswordEmail($email, $firstname){
		$this->load->library('email');
		$email_code = md5($this->config->item('salt') . $firstname);
		
		$this->email->set_mailtype('html');
		$this->email->from($this->config->item('bot_email'), 'Freight Forum');
		$this->email->to($email);
		$this->email->subject('Por favor restablezca su contrasena de la intranet del CAEN-EPG');
		
		$message = 	'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
					"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"><html>
					<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
					</head><body>';
		$message .= '<p>Querido '.$firstname.',</p>';
		$message .= '<p>¡Queremos ayudarte a restablecer tu contrasena! Por favor haga <strong><a href="'.base_url().'login/reset_password_form/'.$email.'/'.$email_code.'">click aqui</a></strong> para reestablecer tu password.</p>';
		$message .= '<p>Gracias</p>';
		$message .= '<p>El equipo de tecnologias del CAEN-EPG</p>';
		$message .= '</body></html>';
		
		$this->email->message($message);
		$this->email->send();
	}
}
