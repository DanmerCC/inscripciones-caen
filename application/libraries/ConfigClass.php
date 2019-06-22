<?php
/**
* 
*/

class ConfigClass 
{
	

}
class Config_Acordion{

    
    public $first_acordion;
    public $second_acordion;
    public $third_acordion;
    public $quarter_acordion;
    public $fifth_acordion;
    public $sixth_acordion;
    public $seventh_acordion;
    public $eighth_acordion;
    public $nineth_acordion;

    function  __construct(){

        $this->first_acordion=false;
        $this->second_acordion=false;
        $this->third_acordion=false;
        $this->quarter_acordion=false;
        $this->fifth_acordion=false;
        $this->sixth_acordion=false;
        $this->seventh_acordion=false;
        $this->eighth_acordion=false;
        $this->nineth_acordion=false;

    }


    function como_array(){
        return (array)$this;
    }
}