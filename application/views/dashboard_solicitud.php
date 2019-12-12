<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Postulante CAEN</title>
<?php $this->load->view('adminlte/linksHead');?>
<!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/jquery.dataTables.min.css"> -->
<link rel="stylesheet" href="/dist/css/jquery-externs/jquery.dataTables.min.css">
<link href="/bower_components/select2/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="/assets/css/effects.css">
</head>
<body class="hold-transition skin-blue-light sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">


<?=$mainHeader;?>
  <!-- =============================================== -->

  <!-- Left side column. contains the sidebar -->
<?=$mainSidebar;?>

  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>

      </h1>
      <ol class="breadcrumb">
				<li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class=""><!-- container -->
          <div class="panel-body table-responsive" id="listadoregistros">
          <div class='row'>
            <!---->
					<div class="col-md-6">
						<div class="box box-solid collapsed-box">
							<div class="box-header with-border">
								<h3 class="box-title">Filtros Finanzas</h3>

								<div class="box-tools pull-right">
									<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
									</button>
								</div>
								<!-- /.box-tools -->
							</div>
							<!-- /.box-header -->
							<div class="box-body" style="">
								<div class="row">
									<div class="col-md-12">
										<label class="label-checkbox" for="select2-estado-finanzas">Estados Finanzas</label>
										<select data-placeholder="Seleccione estado" name="filtro_estado_finanzas[]" multiple class="chosen-select" id="select2-estado-finanzas">
										
											<?php for ($i=0; $i < count($estados_finanzas); $i++){ ?>
												<option value="<?=$estados_finanzas[$i]["id"];?>" selected><?=$estados_finanzas[$i]["nombre"];?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<!-- /.box-body -->
							</div>
							<!-- /.box -->
						</div>
					</div>
					<!---->
            <div class='col-sm-6'>
              <select class="form-control" name="prueba1" id="selectProgram">
                <!-- container -->
              </select>
            </div>
            
          </div>
						<div class="box box-primary" >
							<div class="box-body" style="">
								<table id="dataTable1" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
									<thead>
										<th>N°</th>
										<th>Opciones</th>
										<th>nombres</th>
										<th>apellido_paterno</th>
										<th>apellido_materno</th>
										<th>tipo_financiamiento</th>
										<th>documento</th>
										<th>curso_numeracion</th>
										<th>Finanzas</th>
										<th>Comentario</th>
										<th>fecha_registro</th>
										<th>Estado</th>
									</thead>
									<tfoot>
										<th>N°</th>
										<th>Opciones</th>
										<th>nombres</th>
										<th>apellido_paterno</th>
										<th>apellido_materno</th>
										<th>tipo_financiamiento</th>
										<th>documento</th>
										<th>curso_numeracion</th>
										<th>Finanzas</th>
										<th>Comentario</th>
										<th>fecha_registro</th>
										<th>Estado</th>
									</tfoot>
								</table>
							</div>
						</div>
          </div>
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

  <div id="contentModals">
<!-- Modal de comentarios -->
    <div class="modal fade" tabindex="-1" role="dialog" id="mdl_form_comment">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Comentario</h4>
        </div>
        <div class="modal-body">
        <div class="panel-body" style="height: 100px;" id="formularioregistros">
          <form name="form_comment" id="form_comment" method="post" action="/admin/comentario/guardar">
            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <label for ="commet">Editar Comentario:</label>
                <input type="hidden" name="id_solicitud" id="id_solicitud">
                <textarea class="form-control col-lg-12 col-md-12 col-sm-12 col-xs-12" maxlength="255" name="commet" id="commet" form="form_comment">
                </textarea>
            </div>
          </form>
      </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" id="btnFormPorgrama" data-dismiss="modal">Cerrar</button>
          <button id="btnActualizarComent" type="submit" class="btn btn-primary" form="form_comment" style="resize:vertical;">Guardar Comentario</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
<!-- Modal de comentarios -->
  </div>
</div>

<!-- Modal de Datos de alumno -->
<div class="modal fade" id="mdl_datos_alumno">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title">Datos del alumno</h4>
      </div>
      <div class="modal-body">
      <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" id="mdl-foto" src="" alt="User profile picture">
              <h3 class="profile-username text-center" id="mdl-name"></h3>
              <p class="text-muted text-center" id="mdl-profesion"></p>
              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b >Solicitudes</b> <a class="pull-right" id="mdl-solicitudes">1,322</a>
                </li>
              </ul>
            </div>
            <!-- /.box-body -->
          </div>
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Otros datos</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                  <div class="col-md-6">
                    <strong><i class="fa fa-phone margin-r-5"></i> Numeros de celular</strong>
                    <p class="text-muted" id="mdl-celphone">
                    </p>
                  </div>
                  <div class="col-md-6">
                    <strong><i class="fa fa-envelope margin-r-5"></i> Email</strong>
                    <p class="text-muted" id="mdl-email">
                    </p>
                  </div>
                  <div class="col-md-6">
                    <strong><i class="fa fa-book margin-r-5"></i> Educacion</strong>
                    <p class="text-muted" id="mdl-educacion">
                    </p>
                  </div>
              </div>
              <hr>
              <div class="row">
                  <div class="col-md-6">
                      <div class="box box-solid sombra">
                        <div class="box-header">
                          <strong><i class="fa fa-pencil margin-r-5"></i> Documentos</strong>
                        </div>
                        <div class="box-body">
                          <div id="mdl-icons-documents">
                          </div>
                        </div>
                      </div>
                      <div class="box box-solid sombra">
                        <div class="box-header">
                          <strong><i class="fa fa-pencil margin-r-5"></i> Documentos De solicitud</strong>
                        </div>
                        <div class="box-body">
                          <div id="mdl-icons-filesOfSol">
                          </div>
                        </div>
                      </div>
                  </div>
                  <div class="col-md-6">
                        
                  </div>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
        
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- Modal de Datos de alumno -->

<!-- Modal de Datos de alert danger -->
<div class="modal modal-danger fade" id="mdl_danger_msg">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title">Ups !</h4>
      </div>
      <div class="modal-body">
				
				<div id="msg-modal">
					<h2>Algo salio mal</h2>
				</div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
        
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- Modal de Datos de Alert -->
<div class="modal fade" tabindex="-1" role="dialog" id="mdl_details_finance">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Detalles Finanzas</h4>
      </div>
      <div class="modal-body">
      <div class="panel-body"  id="mdl_body_details_finance">
				<a class="btn btn-block btn-social btn-vk">
					<i class="fa fa-vk"></i> Cometnario
				</a>
    </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" id="btnCForm" data-dismiss="modal">Cerrar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

Copy
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  Launch demo modal
</button>

<!-- Modal -->
<div class="modal fade" id="modalObservationMessage" tabindex="-1" role="dialog" aria-labelledby="modalObservationMessageModalLabelLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="modalObservationMessageModalLabel">Mensaje</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="cuerpoModalException">
				<label class="alert alert-danger" style="width:100%;" for="" >Este alumno tiene una observacion esto hace que impida la inscripcion.</label>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!-- ./wrapper -->
<?php $this->load->view('adminlte/scriptsFooter');?>

<!-- <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>

<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script> -->

<script src="/dist/js/jquery-externs/jquery.dataTables.min.js"></script>
<script src="/dist/js/jquery-externs/bootbox.min.js"></script>
<script src="/dist/js/jquery-externs/dataTables.buttons.min.js"></script>
<script src="/dist/js/jquery-externs/buttons.flash.min.js"></script>
<script src="/dist/js/jquery-externs/jszip.min.js"></script>
<script src="/dist/js/jquery-externs/pdfmake.min.js"></script>
<script src="/dist/js/jquery-externs/buttons.html5.min.js"></script>
<script src="/dist/js/jquery-externs/buttons.print.min.js"></script>
<script src="/bower_components/select2/dist/js/select2.min.js"></script>

<script src="/assets/plugins/bootbox/bootbox.all.min.js"></script>
<!-- <script src="/assets/js/dboardAlumno.js"></script> -->
<script src="/assets/js/dbSolicitudes.js"></script>
</body>
</html>
