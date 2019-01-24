<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
//si no existe la función invierte_date_time la creamos
if(!function_exists('resultToArray')){
	//formateamos la fecha y la hora, función de cesarcancino.com
	function resultToArray($result){
		$response= [];
		$i=0;
		foreach ($result->result_array() as $row){
            $response[$i]=$row;
            $i++;
		}

		return $response;
	}
}

//si no existe la función invierte_date_time la creamos
if(!function_exists('arrayObjectoToArray')){
	//formateamos la fecha y la hora, función de cesarcancino.com
	function arrayObjectoToArray($arrayobject){
		$response= [];
		$i=0;
		for($i=0;$i<count($arrayobject);$i++){
		    $response[$i]=get_object_vars($arrayobject[$i]);
		}

		return $response;
	}
}

