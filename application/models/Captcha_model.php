<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Captcha_model extends CI_Model
{
    private $table = 'captcha';
    private $captcha_id = 'captcha_id';
    private $captcha_time = 'captcha_time';
    private $ip_address = 'ip_address';
    private $word = 'word';

    function __construct(){
        parent::__construct();

        //Usado para mantener estandar de otros modelos
        $this->load->helper('mihelper');
    }

    //Se guarda los datos de captcha en la BD
    public function saveCaptcha($captcha){
        $data = array(
            $this->captcha_time => $captcha['time'],
            $this->ip_address => $this->input->ip_address(),
            $this->word => $captcha['word']
        );
        $query = $this->db->insert_string($this->table, $data);
        $this->db->query($query);
    }
    
    //Se eliminarán los captchas vencidos en BD
    public function deleteOldCaptcha($expiration){
        $this->db->where($this->captcha_time.' <', $expiration);
        $this->db->delete($this->table);
    }

    public function check($ip, $expiration, $captcha){
        $this->db->where($this->word, $captcha);
        $this->db->where($this->ip_address, $ip);
        $this->db->where($this->captcha_time.' >', $expiration);

        $query = $this->db->get($this->table);

        return $query->num_rows();
    }
}