<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class File_model extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
	}

	public function save($file){

	}

	public function download($filepath){

	}

}

class SolicitudFile{
	/**
	 * @var path String ruta especifica parala solicitud
	 */
	private static $object_path='/sol-ad';
	static $min_name='solad';

	public static function path(){
		SolicitudFile
	}
}


class RepositoryFiles{
	static $basepath=CC_BASE_PATH.'/files';
}