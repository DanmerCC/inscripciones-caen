<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class FinanzasAuthorization_model extends CI_Model
{
	private $table='fin_authorizacion_inscrito';
	private $usuario_id='usuario_id';
	private $inscripcion='inscripcion';
	private $comentario='comentario';
	private $tipo_id='tipo_id';

	function __construct()
	{
		parent::__construct();
	}

	function create($usuario_id,$inscripcion,$tipo_id,$comentario=''){
		$data=array(
			$this->usuario_id=>$usuario_id,
			$this->inscripcion=>$inscripcion,
			$this->comentario=>$comentario,
			$this->tipo_id=>$tipo_id
		);
		$this->db->insert($this->table,$data);
		return ($this->affected_rows()==1);
	}
}
