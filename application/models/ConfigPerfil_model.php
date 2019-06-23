<?php


class ConfigPerfil_model extends CI_Model {

    private $table='config_perfil_user';
    private $id='id_config_perfil_user';

	function __construct(){
        parent::__construct();
		$this->load->library('ConfigClass');
		$this->load->library('Nativesession');
	}

	/**
	 * para iniciar debe de haber iniciado session
	 */
	public function getConfigAcordion(){
        
		$name_acordion_config=$this->getAcordionName();
		$config_object=new Config_Acordion();

		$config_object->select($name_acordion_config);
		return $config_object->values;
	}
	
	public function setAcordion($name){
		$id_usuario=$this->nativesession->get('idUsuario');
		$conditions=array(
			'u.id'=>$id_usuario
		);
		$this->db	->select($this->id.', acordion_default_name')
					->from($this->table." cp" )
					->join('usuario u','cp.usuario_id=u.id','left')
					->where($conditions);


		$result=$this->db->get();
		if($result->num_rows()>0){
			$first_row=$result->result_array()[0];
			if($first_row['acordion_default_name']==$name){
				return true;
			}
			$data=array(
				'acordion_default_name'	=>$name,
				'usuario_id'			=>$id_usuario
			);
			$this->db->where($this->id,$first_row[$this->id]);
			$this->db->update($this->table,$data);
			
		}else{
			$data=array(
				'acordion_default_name'	=>$name,
				'usuario_id'			=>$id_usuario
            );
			$this->db->insert($this->table,$data);
		}
		return $this->db->affected_rows()==1;
	}

	public function getAcordionName(){
		$id_usuario=$this->nativesession->get('idUsuario');
        $this->db->select('acordion_default_name')
        ->from($this->table." cp" )
        ->join('usuario u','cp.usuario_id=u.id','left')
        ->where('u.id',$id_usuario);

		$result=$this->db->get();
        if($result->num_rows()==0){
            $data=array(
				'acordion_default_name'=>Config_Acordion::first_acordion,
				'usuario_id'=>$id_usuario
            );
			$this->db->insert($this->table,$data);
			$name_acordion_config=Config_Acordion::first_acordion;
		}else{
			$name_acordion_config=$result->result_array()[0]['acordion_default_name'];
		}
		return $name_acordion_config;
	}

	public function verify_exist(){
		$id_usuario=$this->nativesession->get('idUsuario');
        $this->db->select('acordion_default_name')
        ->from($this->table." cp" )
        ->join('usuario u','cp.usuario_id=u.id','left')
        ->where('u.id',$id_usuario);

		$result=$this->db->get();
		return $result->num_rows()>0;
	}

}
