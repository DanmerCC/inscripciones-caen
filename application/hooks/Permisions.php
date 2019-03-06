<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Permisions
{
    private $ci;
    public function __construct()
    {
        $this->ci = &get_instance();
        !$this->ci->load->library('session') ? $this->ci->load->library('session') : false;
        !$this->ci->load->helper('url') ? $this->ci->load->helper('url') : false;
    }

    public function check_login()
    {
        if ($this->ci->session->userdata('id') == false) {
                redirect(base_url($this->ci->uri->segment(1)));
            }
    }
}

