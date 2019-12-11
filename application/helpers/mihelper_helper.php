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


//si no existe la función invierte_date_time la creamos
if(!function_exists('c_extract')){
	//formateamos la fecha y la hora, función de cesarcancino.com
	function c_extract($array_pluckeable,$column){
		$response= [];
		$i=0;
		for($i=0;$i<count($array_pluckeable);$i++){
		    $response[$i]=($array_pluckeable[$i][$column]);
		}

		return $response;
	}
}


if(!function_exists('changePrimaryKeyToIndex')){
	//formateamos la fecha y la hora, función de cesarcancino.com
	function changePrimaryKeyToIndex($array_object,$primary_key_column){
		$keys=array_unique(c_extract($array_object,$primary_key_column));
		if(count($keys)!==count($array_object)){
			throw new Exception("la columna contiene datos repetidos");
		}
		$response= [];
		$i=0;
		for($i=0;$i<count($array_object);$i++){
		    $response[$array_object[$i][$primary_key_column]]=$array_object[$i];
		}

		return $response;
	}
}
