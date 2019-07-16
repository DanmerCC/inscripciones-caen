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

interface iFile{
	public function path();
	public function completePath();
	public function id();
}

class BaseFile implements iFile{
	public function path(){
		return CC_BASE_PATH.'/files'.static::$object_path;
	}
	public function id(){
		return $this->id;
	}

	public function completePath(){
		return $this->path().'/'.$this->id();
	}

	public function name(){
		return static::$nombre;
	}
}

class CurriculumFile extends BaseFile{
	/**
	 * @var path String ruta especifica parala solicitud
	 */
	static $object_path='/cvs';
	static $min_name='cv';
	static $nombre='Curriculum';

}

class DeclaracionJuradaFile extends BaseFile{
	/**
	 * @var path String ruta especifica parala solicitud
	 */
	static $object_path='/djs';
	static $min_name='dj';
	static $nombre='Declaracion Jurada';

}

class DniFile extends BaseFile{
	/**
	 * @var path String ruta especifica parala solicitud
	 */
	static $object_path='/dni';
	static $min_name='dni';
	static $nombre='DNI';

}

class BachillerFile extends BaseFile{
	/**
	 * @var path String ruta especifica parala solicitud
	 */
	static $object_path='/bachiller';
	static $min_name='bach';
	static $nombre='Constacia de Bachiller';

}

class MaestriaFile extends BaseFile{
	/**
	 * @var path String ruta especifica parala solicitud
	 */
	static $object_path='/maestria';
	static $min_name='maes';
	static $nombre='Constancia de Maestria';

}


class DoctoradoFile extends BaseFile{
	/**
	 * @var path String ruta especifica parala solicitud
	 */
	static $object_path='/doctorado';
	static $min_name='doct';
	static $nombre='Constancia de Doctorado';

}


class SolicitudFile extends BaseFile{
	/**
	 * @var path String ruta especifica parala solicitud
	 */
	static $object_path='/sol-ad';
	static $min_name='solad';
	static $nombre='Solicitud de Admision';
}

class ProyectoInvestigacionFile extends BaseFile{
	/**
	 * @var path String ruta especifica parala solicitud
	 */
	static $object_path='/proinves';
	static $min_name='pinvs';
	static $nombre='Proyecto de Investigacion';
}

class HojaDatosFile extends BaseFile{
	/**
	 * @var path String ruta especifica parala solicitud
	 */
	static $object_path='/hojadatos';
	static $min_name='hdatos';
	static $nombre='Hoja de datos';
}


