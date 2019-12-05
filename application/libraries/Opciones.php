<?php 
/**
* 
*/
class Opciones
{
	public $arreglo=null;
	public $opciones=null;
	public $ci;
    //public $lista=null;
	function __construct()
	{
		$this->ci=&get_instance();
		$this->ci->load->helper('url');
    $this->arreglo=[];
    $this->opciones=array();
    $this->opciones['alumnos']=[
					"text"=>"Alumnos",
					"icon"=>"fa fa-users",
					"hasSubModule"=>false,
                    "href"=>'/administracion/vista/alumnos',
                     "active"=>false
                    ];
    $this->opciones['matriculas']=[
                    "text"=>"Matriculas",
					"icon"=>"fa fa-users",
					"hasSubModule"=>false,
                    "href"=>"/administracion/vista/matriculas",
                    "submenu"=>[],
                    "active"=>false
                    ];
    $this->opciones['programas']=[
                    "text"=>"Programas",
					"icon"=>"fa fa fa-book",
					"hasSubModule"=>true,
                    "href"=>"/administracion/vista/programas",
                    "submenu"=>[
                            [
                                "text"=>"Todos",
                                "atributos"=>"id='programas' href='".base_url()."administracion/vista/programas#collapse8'"
                            ],
                            [
                                "text"=>"Nuevo",
                                "atributos"=>"id='formNuevoPro' data-toggle='collapse' data-parent='#accordion' href='#collapse8'"
							],
                            [
                                "text"=>"calendario(beta)",
                                "atributos"=>"id='calendar-view' href='".base_url()."administracion/vista/programascalendar'"
                            ]
                        ],
                     "active"=>false
                    ];
    $this->opciones['discounts']=[//beneficios
                    "text"=>"Beneficios",
					"icon"=>"fa fa-cogs",
					"hasSubModule"=>true,
                    "href"=>"/administracion/vista/discounts",
                    "submenu"=>[
                            [
                                "text"=>"Beneficios",
                                "atributos"=>"id='beneficios' href='".base_url()."administracion/vista/discounts'"
                            ],
                            [
                                "text"=>"Requisitos",
                                "atributos"=>"id='beneficios' href='".base_url()."administracion/vista/requirements'"
							],
                            [
                                "text"=>"Beneficio-Programa",
                                "atributos"=>"id='beneficios' href='".base_url()."administracion/vista/cursosdiscount'"
                            ],
                            [
                                "text"=>"Beneficio-Requisito",
                                "atributos"=>"id='beneficios' href='".base_url()."administracion/vista/discountsrequirement'"
                            ]
                        ],
                     "active"=>false
                    ];
    $this->opciones['solicitudes']=[
                    "text"=>"Pre-inscripcion",
					"icon"=>"fa fa-address-book",
					"hasSubModule"=>false,
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
				"icon"=>"fa fa-users",
				"hasSubModule"=>false,
                "href"=>"/administracion/vista/informes",
                 "active"=>false                 
                ];
    $this->opciones['reportes']=[
                "text"=>"Reportes",
				"icon"=>"fa fa-bar-chart",
				"hasSubModule"=>false,
                "href"=>"/administracion/vista/reportes",
                "active"=>false
			];
	$this->opciones['inscripciones']=[
                "text"=>"Inscripcion",
				"icon"=>"fa fa-pencil",
				"hasSubModule"=>false,
                "href"=>"/administracion/vista/inscripciones",
                "active"=>false
            ];
	$this->opciones['entrevistas']=[
                "text"=>"Entrevistas",
				"icon"=>"fa fa-user",
				"hasSubModule"=>false,
                "href"=>"/administracion/vista/entrevistas",
                "active"=>false
			];
	$this->opciones['evaluaciones']=[
                "text"=>"Evaluaciones",
				"icon"=>"fa fa-pencil-square-o",
				"hasSubModule"=>false,
                "href"=>"/administracion/vista/evaluaciones",
                "active"=>false
            ];
        array_push($this->arreglo, $this->opciones['alumnos']);
        array_push($this->arreglo, $this->opciones['matriculas']);
        array_push($this->arreglo, $this->opciones['programas']);
        array_push($this->arreglo, $this->opciones['discounts']);
        array_push($this->arreglo, $this->opciones['solicitudes']);
        array_push($this->arreglo, $this->opciones['informes']);
		array_push($this->arreglo, $this->opciones['reportes']);
		array_push($this->arreglo, $this->opciones['inscripciones']);
		array_push($this->arreglo, $this->opciones['entrevistas']);
		array_push($this->arreglo, $this->opciones['evaluaciones']);
        
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
