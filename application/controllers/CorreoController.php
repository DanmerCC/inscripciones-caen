<?php
class CorreoController extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function sendMailGmail()
	{
		//cargamos la libreria email de ci
		$this->load->library("email");

		//configuracion para gmail
		$configGmail = array(
			'protocol' => 'smtp',
			'smtp_host' => 'ssl://smtp.gmail.com',
			'smtp_port' => 465,
			//'smtp_user' => 'programador1@caen.edu.pe',
			'smtp_user' => 'no-reply@caen.edu.pe',
			'smtp_pass' => '1qazxsw2$123',
			'mailtype' => 'html',
			'charset' => 'utf-8',
			'newline' => "\r\n"
		);    

		//cargamos la configuración para enviar con gmail
		$this->email->initialize($configGmail);

		$this->email->from('danmerccoscco@gmail.com');
		$this->email->to("programador2@caen.edu.pe");
		$this->email->subject('Prueba');
		$this->email->message('<h2>Email enviado con codeigniter haciendo uso del smtp de gmail</h2><hr><br>');
		$this->email->send();
		//con esto podemos ver el resultado
		var_dump($this->email->print_debugger());
	}

	public function sendMailYahoo()
	{
		//cargamos la libreria email de ci
		$this->load->library("email");

		//configuracion para yahoo
		$configYahoo = array(
			'protocol' => 'smtp',
			'smtp_host' => 'smtp.mail.yahoo.com',
			'smtp_port' => 587,
			'smtp_crypto' => 'tls',
			'smtp_user' => 'emaildeyahoo',
			'smtp_pass' => 'password',
			'mailtype' => 'html',
			'charset' => 'utf-8',
			'newline' => "\r\n"
		); 

		//cargamos la configuración para enviar con yahoo
		$this->email->initialize($configYahoo);

		$this->email->from('correo que envia los emails');//correo de yahoo o no funcionará
		$this->email->to("correo que recibe el email");
		$this->email->subject('Bienvenido/a a uno-de-piera.com');
		$this->email->message('<h2>Email enviado con codeigniter haciendo uso del smtp de yahoo</h2><hr><br> Bienvenido al blog');
		$this->email->send();
		//con esto podemos ver el resultado
		var_dump($this->email->print_debugger());

	}
	
	public function fileTest(){

		echo  var_dump($_FILES);
	    //file_get_contents
	    /*
	    mkdir('files/prueba1234567');
	    
	    $stringfile=base64_encode(file_get_contents('files/dni/47327529.pdf',true));
	    $data=$stringfile;
	    
	    $this->load->view("prueba",array("data"=>$stringfile));*/
	}
	

}
