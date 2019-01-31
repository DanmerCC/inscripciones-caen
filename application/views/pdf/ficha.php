<page backcolor="#FEFEFE" backtop="0" backbottom="0" style="font-size: 10pt margin 1%" >
    <bookmark title="Solicitud de Inscripccion" level="0" ></bookmark>
    <table cellspacing="0" style="width: 100%; text-align: center; font-size: 14px" >
        <tr>
            <td style="width: 50%;" rowspan="2" valign="middle" align="center">
                <img  src="assets/img/logo-caen.jpg" alt="Logo"><br>
            </td>
            <td style="width: 20%;" align="right" valign="middle">
                <b>CODIGO</b>&nbsp;
            </td>
            <td style="width: 25%;height: 80%;" align="center" valign="middle" border=1>
                <span ></span><br/>
            </td>
        </tr>
        <tr>
            <td style="width: 50%;" align="right" valign="bottom" colspan="2">
                Fecha: <?=date('d/m/Y',strtotime($datosAlumno['fecha_registro'])) ?>
            </td>
        </tr>
    </table>
    <p align="center" style="margin: 1pt;">
        <b>SOLICITUD DE INSCRIPCION al</b><br><br>
        <b>__<?=$datosAlumno['number_programa']."_".$datosAlumno['name_programa'];?>__</b>
    </p>
    <hr style="height: 0%">
    <table cellspacing="0" style="width: 100%;">
		<tr>
            <td style="width: 75%;">
    			<p>A): <u>DATOS PERSONALES</u></p></td>
            <td rowspan="2" style="width: 25%; height:35%">
				<?php if(file_exists('publicfiles/foto/'.$datosAlumno['documento'].'.jpg')): ?>
                <img height=40px src="publicfiles/foto/<?=$datosAlumno['documento']?>.jpg" alt="Logo"><br>
                <?php elseif(file_exists('publicfiles/foto/'.$datosAlumno['documento'].'.jpeg')): ?>
                <img height=40px src="publicfiles/foto/<?=$datosAlumno['documento']?>.jpeg" alt="Logo"><br>
                <?php endif; ?>
             </td>
        </tr>
        <tr>
            <td style="width: 75%;" align="center"></td>
            <td style="width: 25%;"></td>
        </tr>
        <tr>
            <td style="width: 75%;height: 12pt;font-size: 12pt;margin: 10pt;" border="1" align="center"><?=$datosAlumno['grado_profesion']?></td>
            <td style="width: 25%;"></td>
        </tr>
        <tr>
            <td style="width: 75%; height:2%; font-size: 12pt; text-align:center;" align="center">GRADO / PROFESION</td>
            <td style="width: 25%;"></td>
        </tr>
        <tr>
            <td style="width: 30%;" border="1" align="center"><?=$datosAlumno['apellido_paterno']?></td>
            <td style="width: 5%;"></td>
            <td style="width: 30%;" border="1" align="center"><?=$datosAlumno['apellido_materno']?></td>
            <td style="width: 5%;"></td>
            <td style="width: 30%;" border="1" align="center"><?=$datosAlumno['nombres']?></td>
        </tr>
        <tr>
            <td style="width: 30%; height:12pt; font-size: 8pt; text-align:center;" align="center">APELLIDO PATERNO</td>
            <td style="width: 5%;"></td>
            <td style="width: 30%; height:12pt; font-size: 8pt; text-align:center;" align="center">APELLIDO MATERNO</td>
            <td style="width: 5%;"></td>
            <td style="width: 30%; height:12pt; font-size: 8pt; text-align:center;" align="center">NOMBRES</td>
        </tr>
    </table>
    <table cellspacing="0" style="width: 100%;">
        <tr>
            <td style="width: 30%;" border="1" align="center"><?=$datosAlumno['documento']?></td>
            <td style="width: 5%;"></td>
            <td style="width: 30%;" border="1" align="center"><?=$datosAlumno['estado_civil']?></td>
            <td style="width: 5%;"></td>
            <td style="width: 30%;" border="1" align="center"><?=date('d/m/Y',strtotime($datosAlumno['fecha_nac'])) ?></td>
        </tr>
        <tr>
            <td style="width: 30%; height:12pt; font-size: 8pt; text-align:center;" align="center">NRO. DNI</td>
            <td style="width: 5%;"></td>
            <td style="width: 30%; height:12pt; font-size: 8pt; text-align:center;" align="center">ESTADO CIVIL</td>
            <td style="width: 5%;"></td>
            <td style="width: 30%; height:12pt; font-size: 8pt; text-align:center;" align="center">FECHA DE NACIMIENTO</td>
        </tr>
    </table>
    <table cellspacing="0" style="width: 100%;">
        <tr>
            <td style="width: 18%;" border="1" align="center"><?=$datosAlumno['telefono_casa']?></td>
            <td style="width: 4%;"></td>
            <td style="width: 18%;" border="1" align="center"><?=$datosAlumno['celular']?></td>
            <td style="width: 4%;"></td>
            <td style="width: 18%;" border="1" align="center"><?=$datosAlumno['celular']?></td>
            <td style="width: 4%;"></td>
            <td style="width: 34%;" border="1" align="center"><?=$datosAlumno['email']?></td>
        </tr>
        <tr>
            <td style="width: 18%; height:12pt; font-size: 8pt; text-align:center;" align="center">TELEFONO CASA</td>
            <td style="width: 4%;"></td>
            <td style="width: 18%; height:12pt; font-size: 8pt; text-align:center;" align="center">CELULAR</td>
            <td style="width: 4%;"></td>
            <td style="width: 18%; height:12pt; font-size: 8pt; text-align:center;" align="center">RPM</td>
            <td style="width: 4%;"></td>
            <td style="width: 34%; height:12pt; font-size: 8pt; text-align:center;" align="center">E-MAIL DE CONTACTO</td>
        </tr>
    </table>
    <table cellspacing="0" style="width: 100%;">
        <tr>
            <td style="width: 30%;" border="1" align="center"><?=$datosAlumno['distrito_nac']?></td>
            <td style="width: 5%;"></td>
            <td style="width: 30%;" border="1" align="center"><?=$datosAlumno['provincia']?></td>
            <td style="width: 5%;"></td>
            <td style="width: 30%;" border="1" align="center"><?=$datosAlumno['departamento']?></td>
        </tr>
        <tr>
            <td style="width: 30%; height:12pt; font-size: 8pt; text-align:center;" align="center">DISTRITO DE NACIMIENTO</td>
            <td style="width: 5%;"></td>
            <td style="width: 30%; height:12pt; font-size: 8pt; text-align:center;" align="center">PROVINCIA</td>
            <td style="width: 5%;"></td>
            <td style="width: 30%; height:12pt; font-size: 8pt; text-align:center;" align="center">DEPARTAMENTO</td>
        </tr>
    </table>
    <table cellspacing="0" style="width: 100%;">
        <tr>
            <td style="width: 10%; height:12pt; font-size: 8pt; text-align:left;">DIRECCION DOMICILIARIA</td>
            <td style="width: 2%;"></td>
            <td style="width: 40%;" border="1" align="center"><?=$datosAlumno['direccion']?> </td>
            <td style="width: 4%;"></td>
            <td style="width: 15%;" border="1" align="center"><?=$datosAlumno['interior']?> </td>
            <td style="width: 4%;"></td>
            <td style="width: 25%;" border="1" align="center"><?=$datosAlumno['distrito']?> </td>
        </tr>
        <tr>
            <td style="width: 10%; height:12pt; font-size: 8pt; text-align:center;" align="center"></td>
            <td style="width: 2%;"></td>
            <td style="width: 40%; height:12pt; font-size: 8pt; text-align:center;" align="center">Av. / Calle / Jr.</td>
            <td style="width: 4%;"></td>
            <td style="width: 15%; height:12pt; font-size: 8pt; text-align:center;" align="center">Nº / Int. / Dpto.</td>
            <td style="width: 4%;"></td>
            <td style="width: 25%; height:12pt; font-size: 8pt; text-align:center;" align="center">Distrito</td>
        </tr>
    </table>
    <hr>
    <p style="margin: 0pt;">B): <u>DATOS LABORALES</u></p>
    <table cellspacing="0" style="width: 100%;">
        <tr>
            <td style="width: 20%;font-size: 8pt; " align="right" valign="middle">LUGAR DE TRABAJO:</td>
            <td style="width: 4%;"></td>
            <td style="width: 21%;height:12pt; font-size: 8pt;" border="1" align="center"><?=$datosAlumno['lugar_trabajo']?></td>
            <td style="width: 4%;"></td>
            <td style="width: 51%;height:12pt; font-size: 8pt;" border="1" align="center"><?=$datosAlumno['area_direccion']?></td>
        </tr>
        <tr>
            <td style="width: 20%; height:12pt; font-size: 8pt; text-align:center;" align="center"></td>
            <td style="width: 4%;"></td>
            <td style="width: 21%; height:12pt; font-size: 8pt; text-align:center;" align="center">INSTITUCION</td>
            <td style="width: 4%;"></td>
            <td style="width: 51%; height:12pt; font-size: 8pt; text-align:center;" align="center">AREA / DIRECCION / OFICINA / DPTO.</td>
        </tr>
    </table>
    <table cellspacing="0" style="width: 100%;">
        <tr>
            <td style="width: 20%;font-size: 8pt;" align="right" valign="middle">TIEMPO DE SERVICIOS:</td>
            <td style="width: 4%;"></td>
            <td style="width: 36%;height:12pt; font-size: 8pt;" border="1" align="center"><?=$datosAlumno['tiempo_servicio']?></td>
            <td style="width: 4%;"></td>
            <td style="width: 36%;height:12pt; font-size: 8pt;" border="1" align="center"><?=$datosAlumno['cargo_actual']?></td>
        </tr>
        <tr>
            <td style="width: 20%; height:12pt; font-size: 8pt; text-align:center;" align="center"></td>
            <td style="width: 4%;"></td>
            <td style="width: 36%; height:12pt; font-size: 8pt; text-align:center;" align="center"></td>
            <td style="width: 4%;"></td>
            <td style="width: 36%; height:12pt; font-size: 8pt; text-align:center;" align="center">CARGO QUE DESEMPEÑA ACTUALMENTE</td>
        </tr>
    </table>
    <table cellspacing="0" style="width: 100%;">
        <tr>
            <td style="width: 40%; height:12pt; font-size: 8pt; text-align:center;" border="1" align="center"><?=$datosAlumno['direccion_laboral']?> </td>
            <td style="width: 5%; height:12pt; font-size: 8pt; text-align:center;"></td>
            <td style="width: 15%; height:12pt; font-size: 8pt; text-align:center;" border="1" align="center"><?=$datosAlumno['distrito_laboral']?> </td>
            <td style="width: 5%; height:12pt; font-size: 8pt; text-align:center;"></td>
            <td style="width: 15%; height:12pt; font-size: 8pt; text-align:center;" border="1" align="center"><?=$datosAlumno['telefono_laboral']?> </td>
            <td style="width: 5%; height:12pt; font-size: 8pt; text-align:center;"></td>
            <td style="width: 15%; height:12pt; font-size: 8pt; text-align:center;" border="1" align="center"><?=$datosAlumno['anexo_laboral']?> </td>
        </tr>
        <tr>
            <td style="width: 40%; height:12pt; font-size: 8pt; text-align:center;" align="center">DIRECCION</td>
            <td style="width: 5%;"></td>
            <td style="width: 15%; height:12pt; font-size: 8pt; text-align:center;" align="center">DISTRITO</td>
            <td style="width: 5%;"></td>
            <td style="width: 15%; height:12pt; font-size: 8pt; text-align:center;" align="center">TELEFONO</td>
            <td style="width: 5%;"></td>
            <td style="width: 15%; height:12pt; font-size: 8pt; text-align:center;" align="center">ANEXO</td>
        </tr>
    </table>
    <p>EXPERIENCIA LABORAL (Referencia de 2 últimos puestos de trabajo):</p>
    <table cellspacing="0" style="width: 100%;">
        <tr>
            <td style="width: 5%;height:12pt;font-size: 8pt;" align="center" valign="bottom">1</td>
            <td style="width: 50%;height:12pt;font-size: 8pt;border-bottom: 1px solid black"><?=$datosAlumno['experiencia_laboral1']?></td>
            <td style="width: 5%;height:12pt;font-size: 8pt;" align="center" valign="bottom">del</td>
            <td style="width: 17%;height:12pt;font-size: 8pt;border-bottom: 1px solid black"><?=$datosAlumno['fecha_inicio1']?></td>
            <td style="width: 5%;height:12pt;font-size: 8pt;" align="center" valign="bottom">al</td>
            <td style="width: 18%;height:12pt;font-size: 8pt;border-bottom: 1px solid black" align="center"><?=$datosAlumno['fecha_fin1']?></td>
        </tr>
        <tr>
            <td style="width: 5%;height:12pt;font-size: 8pt;" align="center" valign="bottom">2</td>
            <td style="width: 50%;height:12pt;font-size: 8pt;border-bottom: 1px solid black"><?=$datosAlumno['experiencia_laboral2']?></td>
            <td style="width: 5%;height:12pt;font-size: 8pt;" align="center" valign="bottom">del</td>
            <td style="width: 17%;height:12pt;font-size: 8pt;border-bottom: 1px solid black"><?=$datosAlumno['fecha_inicio2']?></td>
            <td style="width: 5%;height:12pt;font-size: 8pt;" align="center" valign="bottom">al</td>
            <td style="width: 18%;height:12pt;font-size: 8pt;border-bottom: 1px solid black" align="center"><?=$datosAlumno['fecha_fin2']?></td>
        </tr>
    </table>
    <br>
    <table cellspacing="0" style="width: 100%;">
        <tr>
            <td style="width: 40%;font-size: 8pt;" align="center" valign="middle">HA SEGUIDO ALGUN CURSO EN EL CAEN:</td>
            <td style="width: 5%;" align="center" valign="middle" border="1"><?php if($datosAlumno['curso_caen'] == 'SI'): ?>X<?php endif;?></td>
            <td style="width: 5%;"></td>
            <td style="width: 5%;" align="center" valign="middle" border="1"><?php if($datosAlumno['curso_caen'] == 'NO'): ?>X<?php endif;?></td>
            <td style="width: 5%;"></td>
            <td style="width: 40%;font-size: 8pt;border-bottom: 1px solid black" align="center" valign="middle"><?=$datosAlumno['indicar1']?></td>
        </tr>
        <tr>
            <td style="width: 40%;height:12pt;" align="center" valign="middle"></td>
            <td style="width: 5%;height:12pt;font-size: 8pt;"align="center" valign="top">SI</td>
            <td style="width: 5%;height:12pt;"></td>
            <td style="width: 5%;height:12pt;font-size: 8pt;"align="center" valign="top">NO</td>
            <td style="width: 5%;height:12pt;"></td>
            <td style="width: 40%;height:12pt;font-size: 8pt;" align="center" valign="middle">INDICACIONES</td>
        </tr>
        <tr>
            <td style="width: 40%;font-size: 8pt;" align="center" valign="middle">HA CURSADO ESTUDIOS DE MAESTRIA:</td>
            <td style="width: 5%;" align="center" valign="middle" border="1"><?php if($datosAlumno['curso_maestria'] == 'SI'): ?>X<?php endif;?></td>
            <td style="width: 5%;"></td>
            <td style="width: 5%;" align="center" valign="middle" border="1"><?php if($datosAlumno['curso_maestria'] == 'NO'): ?>X<?php endif;?></td>
            <td style="width: 5%;"></td>
            <td style="width: 40%;font-size: 8pt;border-bottom: 1px solid black" align="center" valign="middle"><?=$datosAlumno['indicar2']?></td>
        </tr>
        <tr>
            <td style="width: 40%;height:12pt;" align="center" valign="middle"></td>
            <td style="width: 5%;height:12pt;font-size: 8pt;"align="center" valign="top">SI</td>
            <td style="width: 5%;height:12pt;"></td>
            <td style="width: 5%;height:12pt;font-size: 8pt;"align="center" valign="top">NO</td>
            <td style="width: 5%;height:12pt;"></td>
            <td style="width: 40%;height:12pt;font-size: 8pt;" align="center" valign="middle">INDICACIONES</td>
        </tr>
    </table>
    <hr>
    <p>C): <u>DATOS ACADEMICOS</u></p>
    <table cellspacing="0" style="width: 100%;">
        <tr>
            <td style="width: 5%"></td>
            <td style="width: 20%"></td>
            <td style="width: 35%"></td>
            <td style="width: 5%;"></td>
            <td style="width: 20%;height:12pt;font-size: 8pt;text-align: center;" align="center" valign="middle">Universidad</td>
            <td style="width: 5%;"></td>
            <td style="width: 10%;font-size: 8pt;text-align: center;" align="center" valign="middle">Año</td>
        </tr>
        <tr>
            <td style="width: 5%;font-size: 8pt;" align="center" valign="middle">1</td>
            <td style="width: 20%;height:12pt;font-size: 8pt;" align="center" valign="middle">Titulo Universitario en:</td>
            <td style="width: 35%;height:12pt;font-size: 8pt;border-bottom: 1px solid black;text-align: center;" align="center" valign="middle"><?=$datosAlumno['titulo_obtenido']?></td>
            <td style="width: 5%;"></td>
            <td style="width: 20%;height:12pt;font-size: 8pt;border-bottom: 1px solid black;text-align: center;" align="center" valign="middle"><?=$datosAlumno['universidad_titulo']?></td>
            <td style="width: 5%;"></td>
            <td style="width: 10%;height:12pt;font-size: 8pt;border-bottom: 1px solid black;text-align: center;" align="center" valign="middle"><?=$datosAlumno['fecha_titulo']?></td>
        </tr>
        <tr>
            <td style="width: 5%;font-size: 8pt;" align="center" valign="middle">2</td>
            <td style="width: 20%;height:12pt;font-size: 8pt;" align="center" valign="middle">Grado Académico de:</td>
            <td style="width: 35%;height:12pt;font-size: 8pt;border-bottom: 1px solid black;text-align: center;" align="center" valign="middle"><?=$datosAlumno['grado_obtenido']?></td>
            <td style="width: 5%;"></td>
            <td style="width: 20%;height:12pt;font-size: 8pt;border-bottom: 1px solid black;text-align: center;" align="center" valign="middle"><?=$datosAlumno['universidad_grado']?></td>
            <td style="width: 5%;"></td>
            <td style="width: 10%;height:12pt;font-size: 8pt;border-bottom: 1px solid black;text-align: center;" align="center" valign="middle"><?=$datosAlumno['fecha_grado']?></td>
        </tr>
        <tr>
            <td style="width: 5%;font-size: 8pt;" align="center" valign="middle">3</td>
            <td style="width: 20%;height:12pt;font-size: 8pt;" align="center" valign="middle">Maestrías / Doctorado en:</td>
            <td style="width: 35%;height:12pt;font-size: 8pt;border-bottom: 1px solid black;text-align: center;" align="center" valign="middle"><?=$datosAlumno['maestria_obtenida']?></td>
            <td style="width: 5%;"></td>
            <td style="width: 20%;height:12pt;font-size: 8pt;border-bottom: 1px solid black;text-align: center;" align="center" valign="middle"><?=$datosAlumno['universidad_maestria']?></td>
            <td style="width: 5%;"></td>
            <td style="width: 10%;height:12pt;font-size: 8pt;border-bottom: 1px solid black;text-align: center;" align="center" valign="middle"><?=$datosAlumno['fecha_maestria']?></td>
        </tr>
        <tr>
            <td style="width: 5%;font-size: 8pt;" align="center" valign="middle">4</td>
            <td style="width: 20%;height:12pt;font-size: 8pt;" align="center" valign="middle">Maestrías / Doctorado en:</td>
            <td style="width: 35%;height:12pt;font-size: 8pt;border-bottom: 1px solid black;text-align: center;" align="center" valign="middle"><?=$datosAlumno['doctorado_obtenido']?></td>
            <td style="width: 5%;"></td>
            <td style="width: 20%;height:12pt;font-size: 8pt;border-bottom: 1px solid black;text-align: center;" align="center" valign="middle"><?=$datosAlumno['universidad_doctor']?></td>
            <td style="width: 5%;"></td>
            <td style="width: 10%;height:12pt;font-size: 8pt;border-bottom: 1px solid black;text-align: center;" align="center" valign="middle"><?=$datosAlumno['fecha_doctor']?></td>
        </tr>
    </table>
    <table cellspacing="0" style="width: 100%; text-align: center; font-size: 14px" >
        <tr>
            <td style="width: 80%;" rowspan="2" valign="middle" align="center">
                <img width=100% height=20%; src="assets/img/logo-caen.jpg" alt="Logo"><br>
            </td>
        </tr>
    </table>
    <p>D): <u>DOCUMENTOS PRESENTADOS</u></p>
    <table cellspacing="0" style="width: 100%;">
        <tr>
            <td style="width: 10%;font-size: 8pt;" align="center" valign="middle" border="1"></td>
            <td style="width: 90%;height:12pt;font-size: 8pt;" align="left" valign="middle" border="1">1.- Solicitud de Inscripción para el Proceso de Admisión (Formato CAEN).</td>
        </tr>
        <tr>
            <td style="width: 10%;font-size: 8pt;" align="center" valign="middle" border="1"></td>
            <td style="width: 90%;height:12pt;font-size: 8pt;" align="left" valign="middle" border="1">2.- Declaración Jurada de poseer Antecedentes Penales, Judiciales ni Policiales (Formato CAEN).</td>
        </tr>
        <tr>
            <td style="width: 10%;font-size: 8pt;" align="center" valign="middle" border="1"></td>
            <td style="width: 90%;height:12pt;font-size: 8pt;" align="left" valign="middle" border="1">3.- Copia del Título Profesional legalizado por notario o fedateado.</td>
        </tr>
        <tr>
            <td style="width: 10%;font-size: 8pt;" align="center" valign="middle" border="1"></td>
            <td style="width: 90%;height:12pt;font-size: 8pt;" align="left" valign="middle" border="1">4.- Copia Simple DNI. o Pasapaorte.</td>
        </tr>
        <tr>
            <td style="width: 10%;font-size: 8pt;" align="center" valign="middle" border="1"></td>
            <td style="width: 90%;height:12pt;font-size: 8pt;" align="left" valign="middle" border="1">5- Currículum Vitae simple (Sin documentar).</td>
        </tr>
        <tr>
            <td style="width: 10%;font-size: 8pt;" align="center" valign="middle" border="1"></td>
            <td style="width: 90%;height:12pt;font-size: 8pt;" align="left" valign="middle" border="1">6.- TRES (3) fotografías de frente tamaño carné, a color fondo blanco.</td>
        </tr>
        <tr>
            <td style="width: 10%;font-size: 8pt;" align="center" valign="middle" border="1"></td>
            <td style="width: 90%;height:12pt;font-size: 8pt;" align="left" valign="middle" border="1">7.- Copia de la Resolución que motivó su pase a la Situación de Retiro (sólo personal militar).</td>
        </tr>
        <tr>
            <td style="width: 10%;font-size: 8pt;" align="center" valign="middle" border="1"></td>
            <td style="width: 90%;height:12pt;font-size: 8pt;" align="left" valign="middle" border="1">8.- Autorización de su Comando Institucional (FFAA y PNP en actividad)</td>
        </tr>
        <tr>
            <td style="width: 10%;font-size: 8pt;" align="center" valign="middle" border="1"></td>
            <td style="width: 90%;height:12pt;font-size: 8pt;" align="left" valign="middle" border="1">9.- Tema propuesto de investigación (solo para el programa de Doctorado)</td>
        </tr>
    </table>
    <ul style="list-style: none;font-size: 8pt;">
        <li>- La inscripción al Proceso de Admisión al Centro de Altos Estudios Nacionales se realiza de acuerdo a las
normas generales del Sistema Universitario y a las directivas de Admisión del CAEN. </li>
        <li>- El CAEN dará como inscritos únicamente a los Postulantes que presenten los documentos completos según la
relación anteriormente indicada.</li>
    </ul>
    <hr>
    <p>E): <u>REFERENCIAS</u></p>
    <blockquote>
        Indique 2 personas que puedan proporcionar referencias sobre su vida profesional:
    </blockquote>

    <table cellspacing="0" style="width: 100%;">
        <tr>
            <td style="width: 5%;height:12pt;font-size: 8pt;" align="center" valign="bottom">1</td>
            <td style="width: 95%;height:12pt;font-size: 8pt;border-bottom: 1px solid black"><?=$datosAlumno['referencia_personal1']?></td>
        </tr>
        <tr>
            <td style="width: 5%;height:12pt;font-size: 8pt;" align="center" valign="bottom">2</td>
            <td style="width: 95%;height:12pt;font-size: 8pt;border-bottom: 1px solid black"><?=$datosAlumno['referencia_personal2']?></td>
        </tr>
    </table>
    <br>
    <hr>
    <p>F): <u>FINANCIAMIENTO</u></p>
    <table cellspacing="0" style="width: 100%;">
        <tr>
            <td style="width: 30%;font-size: 8pt;" align="center" valign="middle">Indique la alternativa de pago elegida:</td>
            <td style="width: 5%;height: 12pt;font-size: 12pt;" align="center" valign="middle" border="1"><?php if($datosAlumno['tipoFinanciamiento'] == 'Contado'): ?>X<?php endif;?></td>
            <td style="width: 5%;"></td>
            <td style="width: 5%;height: 12pt;font-size: 12pt;" align="center" valign="middle" border="1"><?php if($datosAlumno['tipoFinanciamiento'] == 'Cuotas'): ?>X<?php endif;?></td>
            <td style="width: 55%;"></td>
        </tr>
        <tr>
            <td style="width: 30%;" align="center" valign="middle"></td>
            <td style="width: 5%;height: 12pt;font-size: 8pt;"align="center" valign="top">Contado</td>
            <td style="width: 5%;"></td>
            <td style="width: 5%;height: 12pt;font-size: 8pt;"align="center" valign="top">Cuotas</td>
            <td style="width: 55%;"></td>
        </tr>
    </table>
    <br>
    <hr>
    <p>G): <u>DATOS DE SALUD</u></p>
    <table cellspacing="0" style="width: 100%;">
        <tr>
            <td style="width: 65%;font-size: 8pt;" align="center" valign="middle"></td>
            <td style="width: 5%;height: 12pt;font-size: 8pt;" align="center" valign="middle">SI</td>
            <td style="width: 1%;"></td>
            <td style="width: 5%;height: 12pt;font-size: 8pt;" align="center" valign="middle">NO</td>
            <td style="width: 24%;"></td>
        </tr>
        <tr>
            <td style="width: 65%;font-size: 8pt;" align="left" valign="middle">1.-¿Sufre de alguna enfermedad crónica que pueda derivar en situación de emergencia médica</td>
            <td style="width: 5%;height: 12pt;font-size: 12pt;" align="center" valign="middle" border="1"><?php if($datosAlumno['sufre_enfermedad'] == 'Si'): ?>X<?php endif;?></td>
            <td style="width: 1%;"></td>
            <td style="width: 5%;height: 12pt;font-size: 12pt;" align="center" valign="middle" border="1"><?php if($datosAlumno['sufre_enfermedad'] == 'No'): ?>X<?php endif;?></td>
            <td style="width: 24%;"></td>
        </tr>
    </table>
    <br>
    <?php 

    $enfermedades=json_decode($datosAlumno['tipo_enfermedad'],true);
     ?>
    <table cellspacing="0" style="width: 100%;">
        <tr>
            <td style="width: 5%;font-size: 8pt;" align="right" valign="middle">Asma</td>
            <td style="width: 1%;"></td>
            <td style="width: 5%;height: 12pt;font-size: 12pt;" align="center" valign="middle" border="1"><?php if($enfermedades['Asma'] == 'SI'): ?>X<?php endif;?></td>
            <td style="width: 1%;"></td>
            <td style="width: 8%;font-size: 8pt;" align="right" valign="middle">Hipertensión Arterial</td>
            <td style="width: 1%;"></td>
            <td style="width: 5%;height: 12pt;font-size: 12pt;" align="center" valign="middle" border="1"><?php if($enfermedades['Arterial'] == 'SI'): ?>X<?php endif;?></td>
            <td style="width: 1%;"></td>
            <td style="width: 5%;font-size: 8pt;" align="right" valign="middle">Diabetes</td>
            <td style="width: 1%;"></td>
            <td style="width: 5%;height: 12pt;font-size: 12pt;" align="center" valign="middle" border="1"><?php if($enfermedades['Diabetes'] == 'SI'): ?>X<?php endif;?></td>
            <td style="width: 1%;"></td>
            <td style="width: 5%;font-size: 8pt;" align="right" valign="middle">Cancer</td>
            <td style="width: 1%;"></td>
            <td style="width: 5%;height: 12pt;font-size: 12pt;" align="center" valign="middle" border="1"><?php if($enfermedades['Cancer'] == 'SI'): ?>X<?php endif;?></td>
            <td style="width: 1%;"></td>
            <td style="width: 5%;font-size: 8pt;" align="right" valign="middle">Otras:</td>
            <td style="width: 1%;"></td>
            <td style="width: 43%;height: 12pt;font-size: 8pt;border-bottom: 1px dashed black" align="center" valign="middle"><?php echo $enfermedades['otros']; ?></td>
        </tr>
    </table>
    <br>
    <table cellspacing="0" style="width: 100%;">
        <tr>
            <td style="width: 23%;font-size: 8pt;" align="left" valign="middle">2.- ¿Dispone de Seguro Medico?</td>
            <td style="width: 5%;height: 12pt;font-size: 12pt;" align="center" valign="middle" border="1"><?php if($datosAlumno['seguro_medico'] == 'SI'): ?>X<?php endif;?></td>
            <td style="width: 1%;"></td>
            <td style="width: 25%;font-size: 8pt;" align="right" valign="middle">Indicar Compañía/Consignar Teléfono:</td>
            <td style="width: 1%;"></td>
            <td style="width: 45%;height: 12pt;font-size: 8pt;border-bottom: 1px dashed black" align="center" valign="middle"><?=$datosAlumno['nombre_seguro']?>/<?=$datosAlumno['telefono_seguro']?></td>
        </tr>
    </table>
    <table cellspacing="0" style="width: 100%;">
        <tr>
            <td style="width: 24%;font-size: 8pt;" align="left" valign="middle">3.- En caso de Emergencia avisar a:</td>
            <td style="width: 34%;height: 12pt;font-size: 8pt;border-bottom: 1px dashed black" align="center" valign="middle"><?=$datosAlumno['emergencia_familiar']?></td>
            <td style="width: 1%;"></td>
            <td style="width: 6%;font-size: 8pt;" align="left" valign="middle">Telefonos:</td>
            <td style="width: 1%;"></td>
            <td style="width: 34%;height: 12pt;font-size: 8pt;border-bottom: 1px dashed black" align="center" valign="middle"><?=$datosAlumno['telefono_familiar']?></td>
        </tr>
    </table>
    <table cellspacing="0" style="width: 100%;">
        <tr>
            <td style="width: 8%;font-size: 8pt;" align="left" valign="middle">Parentezco:</td>
            <td style="width: 92%;height: 12pt;font-size: 8pt;border-bottom: 1px dashed black" align="center" valign="middle"><?=$datosAlumno['parentesco']?></td>
        </tr>
    </table>
    <br>
    <i><b>Declaro bajo juramento que todos los datos informados son verídicos y pueden ser sustentados por el suscrito, a petición del Centro de Altos Estudios Nacionales.</b></i>
    <br>
    <br>
    <br>
    <hr>
    <table cellspacing="0" style="width: 100%;">
        <tr>
            <td style="width: 25%;height:150px;" border="1"></td>
            <td style="width: 25%;height:150px;" border="1"></td>
            <td style="width: 25%;height:150px;" border="1"></td>
            <td style="width: 25%;height:150px;" border="1"></td>
        </tr>
        <tr>
            <td style="width: 25%;" valign="middle" align="center" border="1">FIRMA DEL PARTICIPANTE</td>
            <td style="width: 25%;" valign="middle" align="center" border="1">DIRECCION ACADEMICA</td>
            <td style="width: 25%;" valign="middle" align="center" border="1">SECRETARIO DE ADMISION</td>
            <td style="width: 25%;" valign="middle" align="center" border="1">DIRECTOR GENERAL DEL CAENEPG</td>
        </tr>
    </table>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <i><p style="width: 23%;font-size: 8pt;" align="left" valign="center">ficha de Solicitud con codigo <?=$datosAlumno['id_alumno']?></p></i>
    <br>
</page>