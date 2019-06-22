<?php


class ConfigPerfil_model extends CI_Model {

    private $table='config_perfil_user';
    private $id='config_perfil_user_id';

	function __construct(){
        parent::__construct();
        $this->load->library('ConfigClass');
        $this->load->library('Nativesession');
	}


	public function getObject(){
        $id_usuario=$this->nativessession->get('idUsuario');
        $this->db->select()
        ->from($this->table." cp" )
        ->join('usuario u','cp.usuario_id=u.id','left')
        ->where($this->id,$id_usuario);

        $result=$this->db->get();
        if($result->rum_rows()==0){
            $data=array(

            );
            $this->db->insert($this->table,$data);
        }
    }


}
