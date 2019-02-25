<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Postulante CAEN</title>
  
<?=$this->load->view('adminlte/linksHead','',TRUE);?>
</head>
<body class="hold-transition skin-red sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

<?=$mainHeader; ?>
  <!-- =============================================== -->

  <!-- Left side column. contains the sidebar -->
<?=$mainSidebar; ?>

  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Mi sitio</a></li>
      </ol>
    </section>



    <!-- Main content -->
    <section class="content">
              <div class="container">   
                  <div class="panel-group" id="accordion">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <span class="glyphicon glyphicon-plus-sign"></span>
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">DATOS PERSONALES</a>
                            </h4>
                        </div>
                        <div id="collapse1" class="panel-collapse collapse in">
                            <div class="panel-body">

                                <div class="panel-body">

                                    <form id="formInfPersonal" action="/postulante/guardar/personal" method="post" enctype='multipart/form-data'>
                                        <div class="form-group">
                                            <div class="row">
                                                <div id="ubicacion" class="col-sm-8">
                                                    <label>Grado/Profesión<span style="color: red">(*)</span></label>
                                                    <input type="text"  class="form-control" id="grado_profesion" name="grado_profesion" maxlength="100" required >
                                                    <span id="" class="error" style="display:none;">*</span>
                                                </div>
                                                <div class="col-sm-4">
                                                <!--    <label>Foto de Perfil <span style="color: red">(*)</span>:</label> -->
                                                    <span class="image-perfil">
                                                        <label for="foto" class="btn btn-danger">Elegir nueva imagen</label>
                                                        <img id="imagenpersona" src=<?=$rutaimagen ?> style="height:100px;width:100px;">
                                                    </span>
                                                </div>
                                        
                                                <div class="col-sm-2">
                                                    <div class="form-group" hidden="hidden">
                                                        <input type="file" name="file" id="foto" class="noprint" accept="image/*">
                                                        <span id="" class="error" style="display:none;">Se permite archivos: .gif, .jpg, .png y .jpeg</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <label>Apellido Paterno<span style="color: red">(*)</span></label>
                                                <input type="text" class="form-control" id="apellido_paterno" name="apellido_paterno" value="" maxlength="45" style="text-transform: capitalize;" required>
                                            </div>
                                            <div class="col-sm-4">
                                                <label>Apellido Materno<span style="color: red">(*)</span></label>
                                                <input type="text" class="form-control" id="apellido_materno" name="apellido_materno" value="" maxlength="45" style="text-transform: capitalize;" required>
                                            </div>
                                            <div class="col-sm-4">
                                                <label>Nombres<span style="color: red">(*)</span></label>
                                                <input type="text" class="form-control" id="nombres" name="nombres" value="" maxlength="45" style="text-transform: capitalize;" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-3 col-md-2">
                                                <label>Tipo documento<span style="color: red">(*)</span></label>
                                                <select class="form-control" name="tipoDocumento" id="tipoDocumento" form="formInfPersonal">
                                                    <option value="1">DNI</option>
                                                    <option value="2">PASAPORTE</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-3 col-md-2">
                                                <label>Documento<span style="color: red">(*)</span></label>
                                                <input type="text" class="form-control" id="dni" name="dni" value=""  readonly="readonly" disabled="" required >
                                            </div>

                                            <div class="col-sm-2">
                                                <label>Estado Civil<span style="color: red">(*)</span></label>
                                                <input type="text" class="form-control" id="estado_civil" name ="estado_civil" value="" required>
                                            </div>
                                            <div class="col-sm-2">
                                                <label>Nacionalidad<span style="color: red">(*)</span></label>
                                                <select class="form-control" name="nacionalidad" id="paises" form='formInfPersonal'>
                                                    <?php for($i=0;$i<count($paises);$i++){ ?>
                                                        <option <?php echo $paises[$i]["nombre"]==$nacionalidad?"selected ":""; ?>value=<?php echo "'".$paises[$i]["nombre"]."'"; ?> > <?php echo $paises[$i]["nombre"]; ?> </option>
                                                    <?php } ?>
                                                </select>
                                            </div>

                                            <div class="col-sm-4">
                                                <label>Fecha de Nacimiento<span style="color: red">(*)</span></label>
                                                <input type="date" class="form-control" id="fecha_nac" name ="fecha_nac" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-1">
                                                <label>Marque si es militar</label>
                                                <input type="checkbox" class="checkbox" id="si_militar" name="si_militar" readonly="readonly" value=1>
                                            </div>
                                            <div class="col-sm-3">
                                                <label>Grado militar</label>
                                                <input type="text" class="form-control" id="grado_militar" name="grado_militar" readonly="readonly">
                                            </div>
                                            <div class="col-sm-2">
                                                <label>Plana militar</label>
                                                <input type="text" class="form-control" id="plana_militar" name="plana_militar" readonly="readonly">
                                            </div>
                                            <div class="col-sm-2">
                                                <label>CIP<span style="color: red">(Militar)</span></label>
                                                <input type="text" class="form-control" id="cip_militar" name="cip_militar" readonly="readonly">
                                            </div>
                                            <div class="col-sm-4">
                                                <label>Situacion Militar<span style="color: red">(*)</span></label>
                                                <select class="form-control" name="situacion_militar" id="situacion_militar" disabled="disabled">
                                                    <option disabled selected value>elija una opcion</option>
                                                    <option value="ACTIVO">ACTIVO</option>
                                                    <option value="RETIRO">RETIRO</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <label>Telefono de Casa</label>
                                                <input type="text" class="form-control" id="telefono_casa" name="telefono_casa" value="">
                                            </div>
                                            <div class="col-sm-4">
                                                <label>Celular<span style="color: red">(*)</span></label>
                                                <input type="text" class="form-control" id="celular" name="celular" value="" required="">
                                            </div>
                                            <div class="col-sm-4">
                                                <label>Email de Contacto<span style="color: red">(*)</span></label>
                                                <input type="text" class="form-control" id="email" name="email" value="" required="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <label>Distrito de Nacimiento<span style="color: red">(*)</span></label>
                                                <input type="text" class="form-control" id="distrito_nac" name="distrito_nac" style="text-transform: capitalize;" required="">
                                            </div>
                                            <div class="col-sm-4">
                                                <label>Provincia<span style="color: red">(*)</span></label>
                                                <input type="text" class="form-control" id="provincia" name="provincia" value="" required="">
                                            </div>
                                            <div class="col-sm-4">
                                                <label>Departamento<span style="color: red">(*)</span></label>
                                                <input type="text" class="form-control" id="departamento" name="departamento" value="" required="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label>Dirección Domiciliaria (Av / Calle / Jirón)<span style="color: red">(*)</span></label>
                                                <input type="text" class="form-control" id="direccion" name="direccion" value="" required="">
                                            </div>

                                            <div class="col-sm-2">
                                                <label>N° / Int / Dpto<span style="color: red">(*)</span></label>
                                                <input type="text" class="form-control" id="interior" name ="interior" value="" required="">
                                            </div>

                                            <div class="col-sm-4">
                                                <label>Distrito<span style="color: red">(*)</span></label>
                                                <input type="text" class="form-control" id="distrito" name ="distrito" required="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <button type="sumbit" class="btn btn-primary btn-lg right" id="btnPersonal">Guardar</button>
                                            </div>
                                        </div>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <span class="glyphicon glyphicon-plus-sign"></span>
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">DATOS LABORALES</a>
                            </h4>
                        </div>
                        <div id="collapse2" class="panel-collapse collapse">
                            <form action="postulante/guardar/laboral" method="POST" id="formInfLaboral">
                                <div class="panel-body">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <label>Lugar de Trabajo/Institutción<span style="color: red">(*)</span></label>
                                                <input type="text" class="form-control" id="lugar_trabajo" name="lugar_trabajo" value="">
                                            </div>
                                            <div class="col-sm-4">
                                                <label>Area/Dirección/Oficina/Dpto<span style="color: red">(*)</span></label>
                                                <input type="text" class="form-control" id="area_direccion" name="area_direccion" value="">
                                            </div>
                                            <div class="col-sm-4">
                                                <label>Tiempo de Servicio<span style="color: red">(*)</span></label>
                                                <input type="text" class="form-control" id="tiempo_servicio" name="tiempo_servicio" value="">
                                            </div>
                                        </div>
                                    </div>
                                
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <label>Cargo Actual que Desempeña<span style="color: red">(*)</span></label>
                                                <input type="text" class="form-control" id="cargo_actual" name="cargo_actual" value="">
                                            </div>
                                
                                            <div class="col-sm-4">
                                                <label>Dirección<span style="color: red">(*)</span></label>
                                                <input type="text" class="form-control" id="direccion_laboral" name ="direccion_laboral" value="">
                                            </div>
                                
                                            <div class="col-sm-4">
                                                <label>Distrito<span style="color: red">(*)</span></label>
                                                <input type="text"  class="form-control" id="distrito_laboral" name ="distrito_laboral" value="">
                                            </div>
                                        </div>
                                    </div>
                                
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <label>Telefono<span style="color: red">(*)</span></label>
                                                <input type="text" class="form-control"  id="telefono_laboral" name="telefono_laboral" value="">
                                            </div>
                                            <div class="col-sm-4">
                                                <label>Anexo<span style="color: red">(*)</span></label>
                                                <input type="text" class="form-control" id="anexo_laboral" name="anexo_laboral" value="">
                                            </div>
                                            <div class="col-sm-4">
                                                <label>Situacion Laboral<span style="color: red">(*)</span></label>
                                                <select type="" class="form-control" name="situacion_laboral" id="situacion_laboral" form="formInfLaboral">
                                                    <option value="planilla">En planilla</option>
                                                    <option value="independiente">Independiente</option>
                                                    <option value="cas">CAS</option>
                                                    <option value="locador">Locador de servicios</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label for="experiencia_laboral1">Experiencia Laboral (Referencia de los 02 ultimos puestos de trabajo)</label>
                                                <input type="text" class="form-control" id="experiencia_laboral1" name="experiencia_laboral1" value="">
                                            </div>
                                
                                            <div class="col-sm-3">
                                                <label>Fecha Inicio</label>
                                                <input type="date" class="form-control" id="fecha_inicio1"  name ="fecha_inicio1" value=""/>
                                            </div>
                                            <div class="col-sm-3">
                                                <label>Fecha Fin</label>
                                                <input type="date"  class="form-control" id="fecha_fin1" name ="fecha_fin1" value=""/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label> </label>
                                                <input type="text" class="form-control" id="experiencia_laboral2" name="experiencia_laboral2" value="">
                                            </div>
                                
                                            <div class="col-sm-3">
                                                <label> </label>
                                                <input type="date"  class="form-control"  id="fecha_inicio2" name ="fecha_inicio2" value=""/>
                                            </div>
                                            <div class="col-sm-3">
                                                <label></label>
                                                <input type="date" class="form-control" id="fecha_fin2" name ="fecha_fin2" value=""/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <br>  <label> Ha seguido algún curso en el CAEN-EPG ------ </label>
                                                <label>SI</label>
                                                <input type="radio" id="curso_caen_si" name="curso_caen"  value="SI"  />
                                                <label>NO</label>
                                                <input type="radio" id="curso_caen_no" name="curso_caen" value="NO" checked/>
                                            </div>
                                            <div class="col-sm-6">
                                                <label> Indicar </label>
                                                <input type="text" class="form-control" id="indicar1" name ="indicar1" value="" readonly />
                                            </div>
                                
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <br>  <label> Ha Cursado estudios de Maestrías ------------- </label>
                                                <label>SI</label>
                                                <input type="radio" id="curso_maestria_si"  name="curso_maestria"  value="SI"  />
                                                <label>NO</label>
                                                <input type="radio" id="curso_maestria_no" name="curso_maestria" value="NO" checked/>
                                            </div>
                                            <div class="col-sm-6">
                                                <label> Indicar </label>
                                                <input type="text" class="form-control" id="indicar2" name ="indicar2" value="" readonly />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <button type="sumbit" class="btn btn-primary btn-lg right" id="btnLaboral">Guardar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!--agregado -->
                    
					<div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <span class="glyphicon glyphicon-plus-sign"></span>
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse9">DOCUMENTOS ADJUNTOS</a>
                            </h4>
                        </div>
                        <div id="collapse9" class="panel-collapse collapse">
                                <div class="panel-body">
                                
                                    <div class="col-sm-6">
                                        <div id="containerBoxCV">
                                            PDF
                                            <!--box-->
                                            
                                            <!--box-->
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div id="containerBoxDJ">
                                            <!--box-->

                                            <!--box-->
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div id="containerBoxCopys">
                                            <!--box-->
                                            
                                            <!--box-->
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div id="containerBoxBachiller">
                                            <!--box-->
                                            
                                            <!--box-->
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div id="containerBoxMaestria">
                                            <!--box-->
                                            
                                            <!--box-->
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div id="containerBoxDoctorado">
                                            <!--box-->
                                            
                                            <!--box-->
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div id="containerBoxSolicitud">
                                            <!--box-->
                                            
                                            <!--box-->
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <!--Panel formatos-->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <span class="glyphicon glyphicon-plus-sign"></span>
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse10">FORMATOS</a>
                            </h4>
                        </div>
                        <div id="collapse10" class="panel-collapse collapse">
                            <div class="">
                                <div class="panel-body">
                                    <div class="box">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Bordered Table</h3>
                                        </div>
                                        <!-- /.box-header -->
                                        <div class="box-body">
                                            <table class="table table-bordered">
                                                <tbody>
                                                    <tr>
                                                        <th style="width: 10px">#</th>
                                                        <th>Nombre</th>
                                                        <th>Descarga</th>
                                                    </tr>
                                                    <tr>
                                                        <td>1.</td>
                                                        <td>Solicitud de Inscripcion</td>
                                                        <td>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                <a id="descSolicitud" href="http://www.caen.edu.pe/wordpress/wp-content/uploads/2015/11/Solicitud-de-Inscripci%C3%B3n.xls" download>Descargar Solicitud de Inscripcion</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>2.</td>
                                                        <td>Solicitud de Admisión</td>
                                                        <td>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <a id="descSolicitud" href="http://www.caen.edu.pe/wordpress/wp-content/uploads/2015/11/Solicitud-de-Admisi%C3%B3n.docx" download>Descargar Solicitud de Admisión (Formato CAEN)</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>3.</td>
                                                        <td>Declaración Jurada de no tener antecedentes Penales, Judiciales ni policiales</td>
                                                        <td>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <a id="descSolicitud" href="http://www.caen.edu.pe/wordpress/wp-content/uploads/2015/11/Declaraci%C3%B3n-Jurada-Simple.docx" download>Descargar Declaración Jurada de no tener antecedentes Penales, Judiciales ni policiales (Formato CAEN). [</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                                
                                
                            </div>
                        </div>
                    </div>
                    <!--End Panel formatos-->

					<!--agregado -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <span class="glyphicon glyphicon-plus-sign"></span>
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">DATOS ACADÉMICOS</a>
                            </h4>
                        </div>
                        <div id="collapse3" class="panel-collapse collapse">
                            <form action="postulante/guardar/academico" method="post">
                                <div class="panel-body">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label>Título Universitario en<span style="color: red">(*)</span></label>
                                                <input type="text" class="form-control" id="titulo_obtenido" name="titulo_obtenido" value="">
                                            </div>
                                            <div class="col-sm-4">
                                                <label>Universidad<span style="color: red">(*)</span></label>
                                                <input type="text" class="form-control" id="universidad_titulo" name="universidad_titulo" value="">
                                            </div>
                                            <div class="col-sm-2">
                                                <label>Año<span style="color: red">(*)</span></label>
                                                <input type="date" class="form-control" id="fecha_titulo" name="fecha_titulo" value="">
                                            </div>
                                        </div>
                                    </div>
                                
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label>Grado Académico de<span style="color: red">(*)</span></label>
                                                <input type="text" class="form-control" id="grado_obtenido" name="grado_obtenido" value="">
                                            </div>
                                
                                            <div class="col-sm-4">
                                                <label>Universidad<span style="color: red">(*)</span></label>
                                                <input type="text" class="form-control" id="universidad_grado"  name ="universidad_grado" value="">
                                            </div>
                                
                                            <div class="col-sm-2">
                                                <label>Año<span style="color: red">(*)</span></label>
                                                <input type="date" class="form-control" id="fecha_grado" name="fecha_grado" value="">
                                            </div>
                                        </div>
                                    </div>
                                
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label>Maestrías/Doctorado en<span style="color: red">(*)</span></label>
                                                <input type="text" class="form-control" id="maestria_obtenida" name="maestria_obtenida" value="">
                                            </div>
                                            <div class="col-sm-4">
                                                <label>Universidad<span style="color: red">(*)</span></label>
                                                <input type="text" class="form-control" id="universidad_maestria" name="universidad_maestria" value="">
                                            </div>
                                            <div class="col-sm-2">
                                                <label>Año<span style="color: red">(*)</span></label>
                                                <input type="date" class="form-control" id="fecha_maestria"  name="fecha_maestria" value="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label>Maestrías/Doctorado en<span style="color: red">(*)</span></label>
                                                <input type="text" class="form-control" id="doctorado_obtenido" name="doctorado_obtenido" value="">
                                            </div>
                                            <div class="col-sm-4">
                                                <label>Universidad<span style="color: red">(*)</span></label>
                                                <input type="text" class="form-control" id="universidad_doctor" name="universidad_doctor" value="">
                                            </div>
                                            <div class="col-sm-2">
                                                <label>Año<span style="color: red">(*)</span></label>
                                                <input type="date" class="form-control" id="fecha_doctor" name="fecha_doctor" value="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <button type="sumbit" class="btn btn-primary btn-lg right" id="btnAcademico">Guardar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <span class="glyphicon glyphicon-plus-sign"></span>
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse7">DATOS DE SALUD</a>
                            </h4>
                        </div>
                        <div id="collapse7" class="panel-collapse collapse">
                            <form action="postulante/guardar/salud" method="post">
                                <div class="panel-body">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-10">
                                                <div>
                                                    <label >¿Sufré de alguna enfermedad crónica que pueda derivar en situación de emergencia médica?</label>
                                                    <div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="sufre_enfermedad" id="sufre_enfermedad_si" value="Si" checked="">
                                                            <label class="form-check-label" for="grupo3">
                                                                SI
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="sufre_enfermedad" id="sufre_enfermedad_no" value="No">
                                                            <label class="form-check-label" for="grupo3">
                                                                NO
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><br>
                                
                                        <div class="row">
                                            <input type="text" id="data-asma" name ="arrayTipoEnfermedad[0]" hidden="hidden">
                                            <input type="text" id="data-arterial" name ="arrayTipoEnfermedad[1]" hidden="hidden">
                                            <input type="text" id="data-diabetes" name ="arrayTipoEnfermedad[2]" hidden="hidden">
                                            <input type="text" id="data-cancer" name ="arrayTipoEnfermedad[3]" hidden="hidden">
                                            <input type="text" id="data-otros" name ="arrayTipoEnfermedad[4]" hidden="hidden">

                                            <div class="col-md-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="t_enfermedad_asma" name="tipo_enfermedad" value="Asma" data-pointed="#data-asma" >
                                                    <label class="form-check-label" for="t_enfermedad_asma">
                                                        Asma
                                                    </label>
                                                </div>
                                            </div>
                                
                                            <div class="col-md-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="t_enfermedad_arterial" name="tipo_enfermedad" value="Arterial" data-pointed="#data-arterial">
                                                    <label class="form-check-label" for="t_enfermedad_arterial">
                                                        Hipertensión Arterial
                                                    </label>
                                                </div>
                                            </div>
                                
                                            <div class="col-md-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="t_enfermedad_diabetes" name="tipo_enfermedad" value="Diabetes" data-pointed="#data-diabetes">
                                                    <label class="form-check-label" for="t_enfermedad_diabetes">
                                                        Diabetes
                                                    </label>
                                                </div>
                                            </div>
                                
                                            <div class="col-md-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="t_enfermedad_cancer" name="tipo_enfermedad" value="Cancer" data-pointed="#data-cancer">
                                                    <label class="form-check-label" for="t_enfermedad_cancer">
                                                        Cáncer
                                                    </label>
                                                </div>
                                            </div>
                                
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <label>otra </label>
                                
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <input id="t_enfermedad_otros" type="text" name="otraenfermedad" class="form-control" value="" data-pointed="#data-otros"/>
                                                </div>
                                            </div>
                                        </div>
                                
                                        <div class="row">
                                            <div class="col-sm-10">
                                                <div>
                                                    <label >Dispone de Seguro Médico</label>
                                                    <div >
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="seguro_medico" id="seguro_medico_si" value="SI" checked>
                                                            <label class="form-check-label" for="grupo4">
                                                                SI
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="seguro_medico" id="seguro_medico_no" value="NO">
                                                            <label class="form-check-label" for="grupo4">
                                                                NO
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><br>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <label>Indicar Nombre de la Compañia<span style="color: red">(*)</span></label>
                                                <input type="text" class="form-control" id="nombre_seguro" name="nombre_seguro" value="">
                                            </div>
                                
                                            <div class="col-sm-4">
                                                <label>Consignar Telefono<span style="color: red">(*)</span></label>
                                                <input type="text" class="form-control" id="telefono_seguro" name ="telefono_seguro" value="">
                                            </div>

                                        </div>
                                    </div>
                                
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <label>En caso de emergencia avisar a<span style="color: red">(*)</span></label>
                                                <input type="text" class="form-control" id="emergencia_familiar" name="emergencia_familiar" value="">
                                            </div>
                                
                                            <div class="col-sm-4">
                                                <label>Telefono<span style="color: red">(*)</span></label>
                                                <input type="text" class="form-control" id="telefono_familiar" name ="telefono_familiar" value="">
                                            </div>
                                
                                            <div class="col-sm-4">
                                                <label>Parentesco<span style="color: red">(*)</span></label>
                                                <input type="text"  class="form-control" id="parentesco" name ="parentesco" value="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <button type="sumbit" class="btn btn-primary btn-lg right" id="btnSalud">Guardar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <span class="glyphicon glyphicon-plus-sign"></span>
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse6">REFERENCIAS</a>
                            </h4>
                        </div>
                        <div id="collapse6" class="panel-collapse collapse">
                            <form action="postulante/guardar/referencia" method="post" name="formulario" id="formularioRef" class="form-horizontal">
                                <div class="panel-body"> 
                                    <div class="container form-group">
                                        <div class="row">
                                            <div class="col-sm-10">
                                                <label>Indique 2 personas que puedan proporcionar referencia sobre su vida profesional.<span style="color: red">(*)</span></label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-10">
                                                <label>1</label>
                                                <input type="text" class="form-control" id="referencia_personal1"  name="referencia_personal1" value="">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-10">
                                                <label>2</label>
                                                <input type="text" class="form-control" id="referencia_personal2"  name="referencia_personal2" value="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <button type="sumbit" class="btn btn-primary btn-lg right" id="btnRef">Guardar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>         
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <span class="glyphicon glyphicon-plus-sign"></span>
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse8">SOLICITUDES</a>
                            </h4>
                        </div>
                        <div id="collapse8" class="panel-collapse collapse">
                            <form action="" method="post" name="formulario" id="formulario" class="form-horizontal">
                                <div class=" panel-body">
                                        <div class="container form-group">
                                            <div class="row">
                                                <div class="col-sm-10">
                                                    <label>LIsta de solicitudes hechas por usted<span style="color: red">(*)</span></label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-8 col-md-8">
                                                    <div class="table-responsive">
                                                        <table class="table">
                                                            <thead>
                                                              <tr>
                                                                <th>Programa</th>
                                                                <th>Financiamiento</th>
                                                                <th>Ficha de Inscripcion</th>
                                                              </tr>
                                                            </thead>
                                                            <tbody id="contentSolicitudes">
                                                            <!-- content -->
                                                            </tbody>
                                                          </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-5">
                                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Agregar Solicitud</button>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">

                                        </div>
                                    
                                </div>
                            </form>         
                        </div>
                    </div>
                  </div><!-- end acordion -->
              </div>

      <!-- end contenido -->


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.4.0
    </div>
    <strong>Copyright &copy;<a href="/">CAEN EPG</a>.</strong> All rights
    reserved.
  </footer>

  <!-- Control Sidebar -->

  <!-- /.control-sidebar -->


  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form id="formSolictitud" action="/postulante/solicitar" method="post">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Nueva</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
        
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-10">
                        <label>Programa</label>
                        <select name="programa" id="selectPrograma" class="form-control" form="formSolictitud">
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-10">
                        <label>Tipo financiamiento</label>
                        <select name="tipoFinan" id="tipoFinan" class="form-control" form="formSolictitud">
                            <option value="Contado">Contado</option>
                            <option value="Cuotas">Cuotas</option>
                        </select>
                    </div>
                </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="submit" id="btnActualizarPr" class="btn btn-primary">Enviar Solicitud</button>
          </div>
        </div>
    </form>
  </div>
</div>
<!-- Modal -->
<?php $this->load->view('adminlte/scriptsFooter');?>
<script src="/assets/js/profile.js"></script>
<script src="/assets/js/fileComponent.js"></script>
</body>
</html>
