<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
//si no existe la función invierte_date_time la creamos
if(!function_exists('env')){
	//formateamos la fecha y la hora, función de cesarcancino.com
	function env($name){
		return $_ENV[$name];
	}
}
