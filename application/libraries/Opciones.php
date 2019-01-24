<?php 
/**
* 
*/
class Opciones
{
	public $arreglo=null;
    public $opciones=null;
    //public $lista=null;
	function __construct()
	{
    $this->arreglo=[];
    $this->opciones=array();
    $this->opciones['alumnos']=[
                    "text"=>"Alumnos",
                    "href"=>'/administracion/vista/alumnos',
                    "submenu"=>[
                            [
                                "text"=>"Solicitantes",
                                "atributos"=>"id='solicitantes'"
                            ]
                        ],
                     "active"=>false
                    ];
    $this->opciones['matriculas']=[
                    "text"=>"Matriculas",
                    "href"=>"/administracion/vista/matriculas",
                    "submenu"=>[],
                    "active"=>false
                    ];
    $this->opciones['programas']=[
                    "text"=>"Programas",
                    "href"=>"/administracion/vista/programas",
                    "submenu"=>[
                            [
                                "text"=>"Todos",
                                "atributos"=>"id='programas' data-toggle='collapse' data-parent='#accordion' href='#collapse8'"
                            ],
                            [
                                "text"=>"Nuevo",
                                "atributos"=>"id='formNuevoPro' data-toggle='collapse' data-parent='#accordion' href='#collapse8'"
                            ]
                        ],
                     "active"=>false
                    ];
    $this->opciones['beneficios']=[
                    "text"=>"Beneficios",
                    "href"=>"/administracion/vista/beneficios",
                    "submenu"=>[
                            [
                                "text"=>"Todos",
                                "atributos"=>"id='' data-toggle='collapse' data-parent='#accordion' href='#collapse8'"
                            ]
                        ],
                     "active"=>false
                    ];
    $this->opciones['solicitudes']=[
                    "text"=>"Solicitudes",
                    "href"=>"/administracion/vista/solicitudes",
                    "submenu"=>[
                            [
                                "text"=>"Todos",
                                "atributos"=>"id='' data-toggle='collapse' data-parent='#accordion' href='#collapse8'"
                            ]
                        ],
                     "active"=>false
                    ];
    $this->opciones['informes']=[
                "text"=>"Interesados",
                "href"=>"/administracion/vista/informes",
                "submenu"=>[
                        [
                            "text"=>"Todos",
                            "atributos"=>"id='' data-toggle='collapse' data-parent='#accordion' href='#collapse8'"
                        ]
                    ],
                 "active"=>false
                ];
        array_push($this->arreglo, $this->opciones['alumnos']);
        array_push($this->arreglo, $this->opciones['matriculas']);
        array_push($this->arreglo, $this->opciones['programas']);
        array_push($this->arreglo, $this->opciones['beneficios']);
        array_push($this->arreglo, $this->opciones['solicitudes']);
        array_push($this->arreglo, $this->opciones['informes']);
        //print ("<pre>".print_r($this->arreglo[0],true)."</pre>");
        return $this->arreglo;
	}


    public function opcionDefault($opcion){

        $result=$this->arreglo;
        for ($i=0;$i<count($result);$i++) {
            if ($result[$i]['text']==$opcion) {
                $result[$i]['active']=true;
                //echo $this->result[$i]['active']?"entrooo":"no entro";
            }
        }
        return $result;
    }
    
    public function casede(){
        $opciones['casede']=[
                "text"=>"Inscripciones",
                "href"=>"/administracion/vista/casede",
                "submenu"=>[
                        [
                            "text"=>"Todos",
                            "atributos"=>"id='' data-toggle='collapse' data-parent='#accordion' href='#collapse8'"
                        ]
                    ],
                 "active"=>false
                ];
        $result=[];
        array_push($result, $opciones['casede']);
        return $result;
    }

    public function segun($lista,$opcion=null){
        $rst=[];
        for ($i=0; $i <count($lista) ; $i++) {

            if (isset($this->opciones[$lista[$i]['url']])) {
                 array_push($rst, $this->opciones[$lista[$i]['url']]);
            }
        }

        $result=$rst;
        for ($i=0;$i<count($result);$i++) {
            if ($result[$i]['text']==$opcion) {
                $result[$i]['active']=true;
                //echo $this->result[$i]['active']?"entrooo":"no entro";
            }
        }
        return $result;
    }
}