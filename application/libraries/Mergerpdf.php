<?php
/*
Combinar documentos PDF con PHP
y libmergepdf
Método 3: Escribir en archivo
@author parzibyte
 */
# Cargar librerías
require_once "vendor/autoload.php";
use iio\libmergepdf\Merger;
class Mergerpdf{

	private $combinador;
	private $name="";
	private $documents=[];

	public function __construct()
    {
        $this->combinador=new Merger;
	}
	
	public function setFileName($name)
	{
		$this->name=$name;
	}

	public function getFileName()
	{
		return $this->name;
	}

	public function addFile($pathroute){
		$this->combinador->addFile($pathroute);
	}

	public function getMergedFiles(){
		$salida = $this->combinador->merge();
		//header("Content-type:application/pdf");
		//header("Content-Disposition:attachment;filename=$this->name");
		return  $salida;
	}
}
