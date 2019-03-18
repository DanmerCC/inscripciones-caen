<?php
if ( ! defined('BASEPATH') )
    exit( 'No direct script access allowed' );

class SubRoute
{

	private $base='';
	private $baseNumber=0;
	public  $loged_required=false;

    public function __construct(){

    }

	public function setBase(String $baseUrl='',int $number){
		$this->base=$baseUrl;
		$this->baseNumber=$number;
	}

	
    
}
