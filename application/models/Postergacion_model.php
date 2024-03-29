<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Postergacion_model extends MY_Model{
    
    private $table='postergacion_curso';

    private $id="id_postergacon";
    private $fecha_anterior = 'desde';
	private $nuevo_inicio="nuevo_inicio";
	private $nuevo_termino='nuevo_termino';
    private $author="author_id";
    private $comentario="comentario";
    private $curso_id="curso_id";
    private $created="created";
    private $modified="modified";

	public function __construct()
	{
		parent::__construct();
        $this->load->helper('mihelper');
        $this->load->model('Programa_model');
    }

    /**
     * @var int curso_id id del curso 
     * @var DateTime fecha fecha en formato
     * @var String comentario
     */
    public function create($curso_id,$fecha_anterior,$fecha_nueva,$autor,$nuevo_termino,$comentario=""){
        $data=array(
            $this->id => NULL,
            $this->fecha_anterior=>$fecha_anterior,
			$this->nuevo_inicio => $fecha_nueva,
			$this->author => $autor,
            $this->comentario => $comentario,
			$this->curso_id=>$curso_id,
			$this->nuevo_termino=>$nuevo_termino
		);
		$this->db->insert($this->table,$data);
		$ultimoId = $this->db->insert_id();
		return $ultimoId;
    }

	public function get_all(){
        $this->db->select()->from($this->table);
        $result=resultToArray($this->db->get());
    }

    public function get_one($id){
        $this->db->select(implode(',',$this->getPublicColumns()))
        ->from($this->table);
        $result=resultToArray($this->db->get());
    }
    public function update($id,$nuevo_inicio,$comentario){
        $data=array(
            $this->id=>$id,
            $this->nuevo_inicio=>$nuevo_inicio,
            $this->comentario=>$comentario
        );

        $this->db->where($this->id,$id);
        $result=$this->db->update($this->table,$data);
        return ($result->affected_rows()==1);
    }

    public function delete($id){
        
    }

    private function setPublicColumns(){
		$this->public_arguments=[
            $this->id,
            $this->nuevo_inicio,
            $this->author,
            $this->comentario,
            $this->created,
        ];
	}

}
