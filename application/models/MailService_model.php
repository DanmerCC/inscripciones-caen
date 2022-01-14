<?php

/*
Modelo de action acciones relacionadas a una notificacion
*/

class MailService_model extends MY_Model
{
	private $basePath = 'http://mailservice.caen.edu.pe/api/';
	private $authPath = 'oauth/token';
	private $version = 'v1';
	private $token = null;

	function __construct()
	{
		parent::__construct();
	}

	function getToken()
	{

		$data = [
			'grant_type' => 'password',
			'client_id' => 2,
			'client_secret' => '5QEK8CMBot19moJcjM6reJjxbfisRwH0gTzpjhYP',
			'password' => '123456',
			'username' => 'jtyony18@gmail.com',
			"scope" => ""
		];
		$token = null;
		try {

			$tokenResult = $this->requestPost($this->getTokenPathUrl(), $data, array('Content-Type:application/json'));

			$token = $tokenResult->access_token;
		} catch (\Throwable $th) {
			throw new Exception("Error en el formato del token {$th->getMessage()}");
		}

		return $token;
	}

	function getTokenPathUrl()
	{
		return $this->basePath . $this->version . '/' . $this->authPath;
		//return 'http://mailservice.caen.edu.pe/prueba.php';
	}

	function init()
	{
		$this->token = $this->getToken();
	}

	function send($to, $message)
	{
		$this->verifyToken();
		return $this->requestSend($to, $message);
	}

	public function sendRecoveryMessage($to, $message)
	{
		$this->verifyToken();
		return $this->requestRecoveryMessage($to, $message);
	}
	private function requestRecoveryMessage($to, $message)
	{
		return $this->requestSend($to, $message, 'recoveryPassword');
	}

	private function requestSend($to, $message, $nameTemplate = 'default')
	{
		$data = [
			'email_to' => $to,
			'message' => $message,
			'template' => $nameTemplate
		];
		$headers = array(
			'Content-Type:application/json',
			'Authorization: Bearer ' . $this->token
		);

		$response = $this->requestGet($this->getMessagePath(), $data, $headers);
		return $response;
	}

	private function getMessagePath()
	{
		return $this->basePath . 'email/sendEmail';
	}

	private function requestPost($url, $body, $headers)
	{
		try {
			$result  = $this->genericRequest($url, $body, $headers, 'POST');
			log_message('info', "recibiendo respuesta http :" . (string)($result));
			$tokenResult = json_decode($result);
		} catch (\Throwable $th) {
			throw new Exception("Error al procesar respuesta de authenticacion {$th->getMessage()}");
		}

		return $tokenResult;
	}

	private function genericRequest($url, $body, $headers = [], $method = 'GET')
	{

		$cu = curl_init($url);
		if ($cu === false) {
			throw new Exception('failed to initialize');
		}
		if ($method == 'POST') {
			curl_setopt($cu, CURLOPT_POST, true);
		}
		curl_setopt($cu, CURLOPT_POSTFIELDS, json_encode($body));
		curl_setopt($cu, CURLOPT_VERBOSE, true);
		curl_setopt($cu, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($cu, CURLOPT_RETURNTRANSFER, true);

		$result = curl_exec($cu);

		if ($result === false) {
			throw new Exception(curl_error($cu), curl_errno($cu));
		}
		curl_close($cu);

		return $result;
	}

	private function requestGet($url, $body, $headers = [])
	{
		return $this->genericRequest($url, $body, $headers);
	}

	private function verifyToken()
	{
		if ($this->token == null) {
			$this->init();
		}
	}
}