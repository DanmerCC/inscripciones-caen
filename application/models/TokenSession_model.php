<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class TokenSession_model extends CI_Model
{
	private $table='token_session';

	private $id='id_token_session';
	private $user_id='user_id';
	private $tipo_token='tipo_token_session';

	public $authorities_table='authorities_table';

	function __construct()
	{
		parent::__construct();
		$this->load->helper('mihelper');
	}


	function getNewToken(){

	}
}
