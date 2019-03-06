<?php

if ( ! defined('BASEPATH') )
    exit( 'No direct script access allowed' );

interface FileInterface {
    public function getProperties();
    public function setProperty($name,$value);
    public function setUrlAction($name,$value);
    public function getUrlAction();
}