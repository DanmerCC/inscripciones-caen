<page backcolor="#FEFEFE" style="font-size: 10pt; margin 0%;" >
    <bookmark title="Solicitud de Inscripcion" level="0" ></bookmark>
    <table style="width:100%;">
        <tr>
            <td style="width: 50%; height: 60pt;" rowspan="2", valign="middle" align="center">
                <img  src="assets/img/logo-caen.jpg" alt="Logo">
            </td>
            <td style="width: 30%; height: 40pt; line-height:350%;" align="right">
                CÓDIGO
            </td>
            <td style="width: 20%; height:40pt; line-height:350%;" align="center" border=1>
                <span ></span>
            </td>
        </tr>
        <tr>
            <td style="width: 30%; height: 20pt; font-size: 12pt; line-height:175%;" align="right">
                Fecha:
            </td>
            <td style="width: 20%; height: 20pt; line-height:175%;">
                <?=date('d/m/Y',strtotime($datosAlumno['fecha_registro'])) ?>
            </td>
        </tr>
    </table>
    <table cellpadding="11">
        <tr>
            <td align="center" style="height: 75pt; font-size: 14pt;">
                <b>SOLICITUD DE INSCRIPCIÓN al</b><br><br>
                <b>__<?=$datosAlumno['number_programa']."_".$datosAlumno['name_programa'];?>__</b>
            </td>
        </tr>
    </table>   
    <hr>
    <table cellspacing="0" style="width: 100%;">
		<tr>
            <td style="width: 80%; height: 35pt; line-height: 350%;">A): <u>DATOS PERSONALES</u></td>
            <td style="width: 7%;"></td>
            <td rowspan="3" style="width: 13%;">
				<?php if(file_exists('publicfiles/foto/'.$datosAlumno['documento'].'.jpg')): ?>
                <img src="publicfiles/foto/<?=$datosAlumno['documento']?>.jpg" alt="Logo" style="height: 450pt; width: 400pt; max-height: 450pt; max-width: 400pt;border: 0.25px solid #000;">
                <?php elseif(file_exists('publicfiles/foto/'.$datosAlumno['documento'].'.jpeg')): ?>
                <img src="publicfiles/foto/<?=$datosAlumno['documento']?>.jpeg" alt="Logo" style="height: 450pt; width: 400pt; max-height: 450pt; max-width: 400pt;border: 0.25px solid #000;">
                <?php endif; ?>
             </td>
        </tr>
        <tr>
            <td style="width: 80%;font-size: 10pt;margin: 10pt;" border="1" align="center"><?=$datosAlumno['grado_profesion']?></td>
            <td style="width: 7%;"></td>
        </tr>
        <tr>
            <td style="width: 80%; height:2%; font-size: 8pt; text-align:center;" align="center">GRADO / PROFESIÓN</td>
            <td style="width: 7%;"></td>
        </tr>
        <tr>
            <td style="width: 30%; font-size: 10pt; " border="1" align="center"><?=$datosAlumno['apellido_paterno']?></td>
            <td style="width: 5%;font-size: 10pt;"></td>
            <td style="width: 30%;font-size: 10pt;" border="1" align="center"><?=$datosAlumno['apellido_materno']?></td>
            <td style="width: 5%;"></td>
            <td style="width: 30%;font-size: 10pt;" border="1" align="center"><?=$datosAlumno['nombres']?></td>
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
            <td style="width: 30%; font-size: 10pt;" border="1" align="center"><?=$datosAlumno['documento']?></td>
            <td style="width: 5%;"></td>
            <td style="width: 30%; font-size: 10pt;" border="1" align="center"><?=$datosAlumno['estado_civil']?></td>
            <td style="width: 5%;"></td>
            <td style="width: 30%; font-size: 10pt;" border="1" align="center"><?=date('d/m/Y',strtotime($datosAlumno['fecha_nac'])) ?></td>
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
            <td style="width: 18%; font-size: 10pt;" border="1" align="center"><?=$datosAlumno['telefono_casa']?></td>
            <td style="width: 4%;"></td>
            <td style="width: 18%; font-size: 10pt;" border="1" align="center"><?=$datosAlumno['celular']?></td>
            <td style="width: 4%;"></td>
            <td style="width: 18%; font-size: 10pt;" border="1" align="center"><?=$datosAlumno['celular']?></td>
            <td style="width: 4%;"></td>
            <td style="width: 34%; font-size: 10pt;" border="1" align="center"><?=$datosAlumno['email']?></td>
        </tr>
        <tr>
            <td style="width: 18%; height:12pt; font-size: 8pt; text-align:center;" align="center">TELÉFONO CASA</td>
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
            <td style="width: 30%; font-size: 10pt;" border="1" align="center"><?=$datosAlumno['distrito_nac']?></td>
            <td style="width: 5%;"></td>
            <td style="width: 30%; font-size: 10pt;" border="1" align="center"><?=$datosAlumno['provincia']?></td>
            <td style="width: 5%;"></td>
            <td style="width: 30%; font-size: 10pt;" border="1" align="center"><?=$datosAlumno['departamento']?></td>
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
            <td style="width: 15%; height:12pt; font-size: 8pt; text-align:left;">DIRECCIÓN DOMICILIARIA</td>
            <td style="width: 2%;"></td>
            <td style="width: 35%; font-size: 10pt;" border="1" align="center"><?=$datosAlumno['direccion']?> </td>
            <td style="width: 4%;"></td>
            <td style="width: 15%; font-size: 10pt;" border="1" align="center"><?=$datosAlumno['interior']?> </td>
            <td style="width: 4%;"></td>
            <td style="width: 25%; font-size: 10pt;" border="1" align="center"><?=$datosAlumno['distrito']?> </td>
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
    
    <table cellspacing="0" style="width: 100%;">
        <tr>
            <td style="height: 30pt; line-height: 300%;">B): <u>DATOS LABORALES</u></td>
        </tr>
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
            <td style="width: 21%; height:12pt; font-size: 8pt; text-align:center;" align="center">INSTITUCIÓN</td>
            <td style="width: 4%;"></td>
            <td style="width: 51%; height:12pt; font-size: 8pt; text-align:center;" align="center">ÁREA / DIRECCIÓN / OFICINA / DPTO.</td>
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
            <td style="width: 40%; height:12pt; font-size: 8pt; text-align:center;" align="center">DIRECCIÓN</td>
            <td style="width: 5%;"></td>
            <td style="width: 15%; height:12pt; font-size: 8pt; text-align:center;" align="center">DISTRITO</td>
            <td style="width: 5%;"></td>
            <td style="width: 15%; height:12pt; font-size: 8pt; text-align:center;" align="center">TELÉFONO</td>
            <td style="width: 5%;"></td>
            <td style="width: 15%; height:12pt; font-size: 8pt; text-align:center;" align="center">ANEXO</td>
        </tr>
    </table>
    <table cellspacing="0" style="width: 100%;">
        <tr>
            <td style="width: 100%; font-size: 8pt; height: 16pt; line-height: 180%;">EXPERIENCIA LABORAL (Referencia de 2 últimos puestos de trabajo):</td>
        </tr>
        <tr>
            <td style="width: 5%;height:12pt;font-size: 8pt;" align="center" valign="bottom">1</td>
            <td style="width: 50%;height:12pt;font-size: 8pt;border-bottom: 1px solid black"><?=$datosAlumno['experiencia_laboral1']?></td>
            <td style="width: 5%;height:12pt;font-size: 8pt;" align="center" valign="bottom">del</td>
            <td style="width: 17%;height:12pt;font-size: 8pt;border-bottom: 1px solid black" align="center"><?=$datosAlumno['fecha_inicio1']?></td>
            <td style="width: 5%;height:12pt;font-size: 8pt;" align="center" valign="bottom">al</td>
            <td style="width: 18%;height:12pt;font-size: 8pt;border-bottom: 1px solid black" align="center"><?=$datosAlumno['fecha_fin1']?></td>
        </tr>
        <tr>
            <td style="width: 5%;height:12pt;font-size: 8pt;" align="center" valign="bottom">2</td>
            <td style="width: 50%;height:12pt;font-size: 8pt;border-bottom: 1px solid black"><?=$datosAlumno['experiencia_laboral2']?></td>
            <td style="width: 5%;height:12pt;font-size: 8pt;" align="center" valign="bottom">del</td>
            <td style="width: 17%;height:12pt;font-size: 8pt;border-bottom: 1px solid black" align="center"><?=$datosAlumno['fecha_inicio2']?></td>
            <td style="width: 5%;height:12pt;font-size: 8pt;" align="center" valign="bottom">al</td>
            <td style="width: 18%;height:12pt;font-size: 8pt;border-bottom: 1px solid black" align="center"><?=$datosAlumno['fecha_fin2']?></td>
        </tr>
    </table>
    <br>
    <table cellspacing="0" style="width: 100%;">
        <tr>
            <td style="height: 2pt; width: 100%;"></td>
        </tr>
        <tr>
            <td style="width: 40%;font-size: 8pt;line-height: 220%;" align="center" valign="middle">HA SEGUIDO ALGÚN CURSO EN EL CAEN:</td>
            <td style="width: 5%;" align="center" valign="middle" border="1"><?php if($datosAlumno['curso_caen'] == 'SI'): ?>X<?php endif;?></td>
            <td style="width: 5%;"></td>
            <td style="width: 5%;" align="center" valign="middle" border="1"><?php if($datosAlumno['curso_caen'] == 'NO'): ?>X<?php endif;?></td>
            <td style="width: 5%;"></td>
            <td style="width: 40%;font-size: 8pt;border-bottom: 1px solid black;line-height: 220%;" align="center" valign="middle"><?=$datosAlumno['indicar1']?></td>
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
            <td style="width: 40%;font-size: 8pt;line-height: 220%;" align="center" valign="middle">HA CURSADO ESTUDIOS DE MAESTRIA:</td>
            <td style="width: 5%;" align="center" valign="middle" border="1"><?php if($datosAlumno['curso_maestria'] == 'SI'): ?>X<?php endif;?></td>
            <td style="width: 5%;"></td>
            <td style="width: 5%;" align="center" valign="middle" border="1"><?php if($datosAlumno['curso_maestria'] == 'NO'): ?>X<?php endif;?></td>
            <td style="width: 5%;"></td>
            <td style="width: 40%;font-size: 8pt;border-bottom: 1px solid black;line-height: 220%;" align="center" valign="middle"><?=$datosAlumno['indicar2']?></td>
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
    <table cellspacing="0" style="width: 100%;">
        <tr>
            <td style="height: 30pt; line-height: 300%;">C): <u>DATOS ACADÉMICOS</u></td>
        </tr>
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
            <td style="width: 5%;font-size: 8pt; line-height: 170%;" align="center" valign="middle">1</td>
            <td style="width: 20%;height:12pt;font-size: 8pt;line-height: 170%;" align="center" valign="middle">Título Universitario en:</td>
            <td style="width: 35%;height:12pt;font-size: 8pt;border-bottom: 1px solid black;text-align: center;line-height: 170%;" align="center" valign="middle"><?=$datosAlumno['titulo_obtenido']?></td>
            <td style="width: 5%;"></td>
            <td style="width: 20%;height:12pt;font-size: 8pt;border-bottom: 1px solid black;text-align: center;line-height: 170%;" align="center" valign="middle"><?=$datosAlumno['universidad_titulo']?></td>
            <td style="width: 5%;"></td>
            <td style="width: 10%;height:12pt;font-size: 8pt;border-bottom: 1px solid black;text-align: center;line-height: 170%;" align="center" valign="middle"><?=$datosAlumno['fecha_titulo']?></td>
        </tr>
        <tr>
            <td style="width: 5%;font-size: 8pt;line-height: 170%;" align="center" valign="middle">2</td>
            <td style="width: 20%;height:12pt;font-size: 8pt;line-height: 170%;" align="center" valign="middle">Grado Académico de:</td>
            <td style="width: 35%;height:12pt;font-size: 8pt;border-bottom: 1px solid black;text-align: center;line-height: 170%;" align="center" valign="middle"><?=$datosAlumno['grado_obtenido']?></td>
            <td style="width: 5%;"></td>
            <td style="width: 20%;height:12pt;font-size: 8pt;border-bottom: 1px solid black;text-align: center;line-height: 170%;" align="center" valign="middle"><?=$datosAlumno['universidad_grado']?></td>
            <td style="width: 5%;"></td>
            <td style="width: 10%;height:12pt;font-size: 8pt;border-bottom: 1px solid black;text-align: center;line-height: 170%;" align="center" valign="middle"><?=$datosAlumno['fecha_grado']?></td>
        </tr>
        <tr>
            <td style="width: 5%;font-size: 8pt;line-height: 170%;" align="center" valign="middle">3</td>
            <td style="width: 20%;height:12pt;font-size: 8pt;line-height: 170%;" align="center" valign="middle">Maestrías / Doctorado en:</td>
            <td style="width: 35%;height:12pt;font-size: 8pt;border-bottom: 1px solid black;text-align: center;line-height: 170%;" align="center" valign="middle"><?=$datosAlumno['maestria_obtenida']?></td>
            <td style="width: 5%;"></td>
            <td style="width: 20%;height:12pt;font-size: 8pt;border-bottom: 1px solid black;text-align: center;line-height: 170%;" align="center" valign="middle"><?=$datosAlumno['universidad_maestria']?></td>
            <td style="width: 5%;"></td>
            <td style="width: 10%;height:12pt;font-size: 8pt;border-bottom: 1px solid black;text-align: center;line-height: 170%;" align="center" valign="middle"><?=$datosAlumno['fecha_maestria']?></td>
        </tr>
        <tr>
            <td style="width: 5%;font-size: 8pt;line-height: 180%;" align="center" valign="middle">4</td>
            <td style="width: 20%;height:12pt;font-size: 8pt;line-height: 180%;" align="center" valign="middle">Maestrías / Doctorado en:</td>
            <td style="width: 35%;height:12pt;font-size: 8pt;border-bottom: 1px solid black;text-align: center;line-height: 180%;" align="center" valign="middle"><?=$datosAlumno['doctorado_obtenido']?></td>
            <td style="width: 5%;"></td>
            <td style="width: 20%;height:12pt;font-size: 8pt;border-bottom: 1px solid black;text-align: center;line-height: 180%;" align="center" valign="middle"><?=$datosAlumno['universidad_doctor']?></td>
            <td style="width: 5%;"></td>
            <td style="width: 10%;height:12pt;font-size: 8pt;border-bottom: 1px solid black;text-align: center;line-height: 180%;" align="center" valign="middle"><?=$datosAlumno['fecha_doctor']?></td>
        </tr>
    </table>
    <br>
    <table cellspacing="0" style="width: 100%;" >
        <tr>
            <td style="width: 50%; height: 60pt;" rowspan="2" valign="middle" align="center">
                <img width=100% height=20%; src="assets/img/logo-caen.jpg" alt="Logo"><br>
            </td>
        </tr>
    </table>
    <table cellspacing="0" style="width: 100%;">
        <tr>
            <td style="width: 100%; height: 25pt;line-height: 200%;">D): <u>DOCUMENTOS PRESENTADOS</u></td>
        </tr>
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
    <table cellspacing="0" style="width: 100%;">
        <tr>
            <td style="width: 100%; height: 25pt; line-height: 250%;">E): <u>REFERENCIAS</u></td>
        </tr>
        <tr>
            <td style="text-align: justify; height: 20pt; line-height: 150%; font-size: 10pt;">
                Indique 2 personas que puedan proporcionar referencias sobre su vida profesional:
            </td>
        </tr>
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
    <table cellspacing="0" style="width: 100%;">
        <tr>
            <td style="width: 100%; height: 25pt; line-height: 250%;">F): <u>FINANCIAMIENTO</u></td>
        </tr>
        <tr>
            <td style="width: 30%;font-size: 8pt;" align="center" valign="middle">Indique la alternativa de pago elegida:</td>
            <td style="width: 7%;height: 12pt;font-size: 12pt;" align="center" valign="middle" border="1"><?php if($datosAlumno['tipoFinanciamiento'] == 'Contado'): ?>X<?php endif;?></td>
            <td style="width: 5%;"></td>
            <td style="width: 7%;height: 12pt;font-size: 12pt;" align="center" valign="middle" border="1"><?php if($datosAlumno['tipoFinanciamiento'] == 'Cuotas'): ?>X<?php endif;?></td>
            <td style="width: 51%;"></td>
        </tr>
        <tr>
            <td style="width: 30%;" align="center" valign="middle"></td>
            <td style="width: 7%;height: 20pt;font-size: 8pt;" align="center" valign="top">Contado</td>
            <td style="width: 5%;"></td>
            <td style="width: 7%;height: 20pt;font-size: 8pt;" align="center" valign="top">Cuotas</td>
            <td style="width: 51%;"></td>
        </tr>
    </table>
    <hr>
    <table cellspacing="0" style="width: 100%;">
        <tr>
            <td style="width: 100%; height: 25pt; line-height: 250%;">G): <u>DATOS DE SALUD</u></td>
        </tr>
        <tr>
            <td style="width: 70%;font-size: 8pt;" align="center" valign="middle"></td>
            <td style="width: 2%;"></td>
            <td style="width: 5%;height: 5pt;font-size: 8pt;line-height: 200%;" align="center" valign="middle">SI</td>
            <td style="width: 1%;"></td>
            <td style="width: 5%;height: 5pt;font-size: 8pt;line-height: 200%;" align="center" valign="middle">NO</td>
            <td style="width: 17%;"></td>
        </tr>
        <tr>
            <td style="width: 70%;font-size: 8pt;line-height: 200%;" align="left" valign="middle">1.-¿Sufre de alguna enfermedad crónica que pueda derivar en situación de emergencia médica?</td>
            <td style="width: 2%;"></td>
            <td style="width: 5%;height: 12pt;font-size: 12pt;" align="center" valign="middle" border="1"><?php if($datosAlumno['sufre_enfermedad'] == 'Si'): ?>X<?php endif;?></td>
            <td style="width: 1%;"></td>
            <td style="width: 5%;height: 12pt;font-size: 12pt;" align="center" valign="middle" border="1"><?php if($datosAlumno['sufre_enfermedad'] == 'No'): ?>X<?php endif;?></td>
            <td style="width: 17%;"></td>
        </tr>
    </table>
    <br>
    <?php 
    $enfermedades=json_decode($datosAlumno['tipo_enfermedad'],true);
     ?>
    <table cellspacing="0" style="width: 100%;">
        <tr>
            <td style="width: 5%;font-size: 8pt; line-height: 250%;" align="right" valign="middle">Asma</td>
            <td style="width: 1%;"></td>
            <td style="width: 5%;height: 12pt;font-size: 12pt;" align="center" valign="middle" border="1"><?php if($enfermedades['Asma'] == 'SI'): ?>X<?php endif;?></td>
            <td style="width: 1%;"></td>
            <td style="width: 10%;font-size: 8pt;" align="right" valign="middle">Hipertensión Arterial</td>
            <td style="width: 1%;"></td>
            <td style="width: 5%;height: 12pt;font-size: 12pt;" align="center" valign="middle" border="1"><?php if($enfermedades['Arterial'] == 'SI'): ?>X<?php endif;?></td>
            <td style="width: 1%;"></td>
            <td style="width: 8%;font-size: 8pt; line-height: 250%;" align="right" valign="middle">Diabetes</td>
            <td style="width: 1%;"></td>
            <td style="width: 5%;height: 12pt;font-size: 12pt;" align="center" valign="middle" border="1"><?php if($enfermedades['Diabetes'] == 'SI'): ?>X<?php endif;?></td>
            <td style="width: 1%;"></td>
            <td style="width: 6%;font-size: 8pt; line-height: 250%;" align="right" valign="middle">Cáncer</td>
            <td style="width: 1%;"></td>
            <td style="width: 5%;height: 12pt;font-size: 12pt;" align="center" valign="middle" border="1"><?php if($enfermedades['Cancer'] == 'SI'): ?>X<?php endif;?></td>
            <td style="width: 1%;"></td>
            <td style="width: 6%;font-size: 8pt; line-height: 250%;" align="right" valign="middle">Otras:</td>
            <td style="width: 37%;height: 12pt;font-size: 8pt;border-bottom: 1px dashed black; line-height: 250%;" align="center" valign="bottom"><?php echo $enfermedades['otros']; ?></td>
        </tr>
    </table>
    <br>
    <table cellspacing="0" style="width: 100%;">
        <tr>
            <td style="width: 24%;font-size: 8pt; line-height: 200%;" align="left" valign="middle">2.- ¿Dispone de Seguro Médico?</td>
            <td style="width: 5%;height: 12pt;font-size: 12pt;" align="center" valign="middle" border="1"><?php if($datosAlumno['seguro_medico'] == 'SI'): ?>X<?php endif;?></td>
            <td style="width: 2%;"></td>
            <td style="width: 30%;font-size: 8pt; line-height: 200%;" align="right" valign="middle">Indicar Compañía/Consignar Teléfono:</td>
            <td style="width: 39%;height: 12pt;font-size: 8pt;border-bottom: 1px dashed black; line-height: 200%;" align="center" valign="middle"><?=$datosAlumno['nombre_seguro']?>/<?=$datosAlumno['telefono_seguro']?></td>
        </tr>
    </table>
    <br>
    <table cellspacing="0" style="width: 100%;">
        <tr>
            <td style="width: 26%;font-size: 8pt; line-height: 200%;" align="left" valign="bottom">3.- En caso de Emergencia avisar a:</td>
            <td style="width: 30%; font-size: 8pt;border-bottom: 1px dashed black; line-height: 200%;" align="center"><?=$datosAlumno['emergencia_familiar']?></td>
            <td style="width: 1%;"></td>
            <td style="width: 10%;font-size: 8pt; line-height: 200%;" align="left" valign="bottom">Teléfonos:</td>
            <td style="width: 1%;"></td>
            <td style="width: 28%; font-size: 8pt;border-bottom: 1px dashed black; line-height: 200%;" align="center"><?=$datosAlumno['telefono_familiar']?></td>
        </tr>
    </table>
    <table cellspacing="0" style="width: 100%;">
        <tr>
            <td style="width: 10%;font-size: 8pt; line-height: 135%;" align="left" valign="middle">Parentezco:</td>
            <td style="width: 90%;height: 12pt;font-size: 8pt;border-bottom: 1px dashed black; line-height: 150%;" align="center" valign="middle"><?=$datosAlumno['parentesco']?></td>
        </tr>
    </table>
    <br>
    <div style="text-align: justify;"><b>Declaro bajo juramento que todos los datos informados son verídicos y pueden ser sustentados por el suscrito, a petición del Centro de Altos Estudios Nacionales.</b></div>
    <hr>
    <table cellspacing="0" style="width: 100%;">
        <tr>
            <td style="width: 25%;height:60px;" border="1"></td>
            <td style="width: 25%;height:60px;" border="1"></td>
            <td style="width: 25%;height:60px;" border="1"></td>
            <td style="width: 25%;height:60px;" border="1"></td>
        </tr>
        <tr>
            <td style="width: 25%;" valign="middle" align="center" border="1">FIRMA DEL PARTICIPANTE</td>
            <td style="width: 25%;" valign="middle" align="center" border="1">DIRECCIÓN ACADÉMICA</td>
            <td style="width: 25%;" valign="middle" align="center" border="1">SECRETARIO DE ADMISIÓN</td>
            <td style="width: 25%;" valign="middle" align="center" border="1">DIRECTOR GENERAL DEL CAEN-EPG</td>
        </tr>
    </table>
    <br>
    <i><p style="width: 23%;font-size: 8pt;" align="left" valign="center">Ficha de Solicitud con código <?=$datosAlumno['id_alumno']?></p></i>
</page>