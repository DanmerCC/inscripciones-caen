<?php
/**
* 
*/
class Mihelper 
{
	
	public function resultToArray($result){
		$response= [];
		$i=0;
		foreach ($result->result_array() as $row){
            $response[$i]=$row;
            $i++;
		}

		return $response;
	}
}