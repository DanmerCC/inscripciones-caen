<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Captcha_model extends CI_Model
{
    function __construct(){
        parent::__construct();
        // $this->load->database();
    }

    public function saveCaptcha($captcha){
        $data = array(
            'captcha_time' => $captcha['time'],
            'ip_address' => $this->input->ip_address(),
            'word' => $captcha['word']
        );
        $query = $this->db->insert_string('captcha', $data);
        $this->db->query($query);
    }

    public function deleteOldCaptcha($expiration){
        $this->db->where('captcha_time <', $expiration);
        $this->db->delete('captcha');
    }

    public function check($ip, $expiration, $captcha){
        $this->db->where('word', $captcha);
        $this->db->where('ip_address', $ip);
        $this->db->where('captcha_time >', $expiration);

        $query = $this->db->get('captcha');

        return $query->num_rows();
    }
}