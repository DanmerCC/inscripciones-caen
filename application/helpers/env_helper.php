<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
//si no existe la función invierte_date_time la creamos
if(!function_exists('env')){
	//formateamos la fecha y la hora, función de cesarcancino.com
	function env($name,$default=null){

		if($_ENV[$name]==""){
			$value =  NULL;
		}else{
			$value = $_ENV[$name];
		}

		if($value==NULL)
		{
			$value = $default;
		}

		if($value=="true"){
			$value = true;
		}

		if($value==="false"){
			$value = false;
		}

		return $value;
	}
}
