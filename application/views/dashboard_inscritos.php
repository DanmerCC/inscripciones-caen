<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Postulante CAEN</title>
<?php $this->load->view('adminlte/linksHead');?>
<!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/jquery.dataTables.min.css"> -->
<link rel="stylesheet" href="/assets/css/global.css">
<link rel="stylesheet" href="/dist/css/jquery-externs/jquery.dataTables.min.css">
<link href="/bower_components/select2/dist/css/select2.min.css" rel="stylesheet" />
<link href='<?=base_url()?>assets/plugins/calendar/core/main.css' rel='stylesheet' />
<link href='<?=base_url()?>assets/plugins/calendar/daygrid/main.css' rel='stylesheet' />
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
					<!--FILTROS FINANZAS-->
					<div class="col-md-3">
						<div class="box box-success box-solid collapsed-box">
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
										<select data-placeholder="Seleccione estado" name="filtro_estado_finanzas[]" multiple style="with:100%" class="chosen-select" id="select2-estado-finanzas">
										
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
					<!--FILTROS FINANZAS-->
					<!--FILTROS ADMISION-->
					<div class="col-md-3">
						<div class="box box-solid collapsed-box">
							<div class="box-header with-border">
								<h3 class="box-title">Filtros Admision</h3>

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
										<label class="label-checkbox" for="select2-estado-admision">Estados admision</label>
										<select data-placeholder="Seleccione estado" name="filtro_estado_admision[]" multiple class="chosen-select" id="select2-estado-admision">
										
											<?php for ($i=0; $i < count($estados_admision); $i++){ ?>
												<option value="<?=$estados_admision[$i]["id"];?>" selected><?=$estados_admision[$i]["nombre"];?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<!-- /.box-body -->
							</div>
							<!-- /.box -->
						</div>
					</div>
					<!--FILTROS ADMISION-->
					<div class='col-sm-2'>
						<input class="conic" type="checkbox" name="slct_anulados" value="true" id="slct_anulados">
						<label class="label-checkbox" for="slct_anulados">Incluir Anulados</label>
					</div>
					<div class='col-sm-2'>
						<a href="/administracion/vista/dowloadFilter" id="btnExport" class="btn btn-primary" target="_blank">Exportar completo</a>
					</div>
					<div class='col-sm-4'>
						<select class="form-control" name="prueba1" id="selectProgram">
							<!-- container -->
						</select>
					</div>
              
						</div>
						<div>
							<div>
								Ocultar/Mostrar:
								 <a class="toggle-vis" data-column="1">Nombres</a> -
									<a class="toggle-vis" data-column="2">Apellidos</a> -
									 <a class="toggle-vis" data-column="3">Programa</a> - 
									 <a class="toggle-vis" data-column="4">Documento</a> - 
									 <a class="toggle-vis" data-column="5">Correo</a>-
									 <a class="toggle-vis" data-column="6">Telefonos</a>-
									 <a class="toggle-vis" data-column="7">Fecha de Registro</a>-
									 <a class="toggle-vis" data-column="8">Finanzas</a>-
									 <a class="toggle-vis" data-column="9">Anulado</a>-
									 <a class="toggle-vis" data-column="10">Admision</a>-
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="box">
									<div class="box-body">
									<table id="dataTable1" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
										<thead>
											<th>Opciones</th>
											<th>Nombres</th>
											<th>Apellidos</th>
											<th>Programa</th>
											<th>Documento</th>
											<th>Correo</th>
											<th>Telefonos</th>
											<th>Fecha de Registro</th>
											<th>Finanzas</th>
											<th>Estado</th>
											<th>Admision</th>
											<th>Entrevistas</th>
										</thead>
										<tfoot>
										<th>Opciones</th>
											<th>Nombres</th>
											<th>Apellidos</th>
											<th>Programa</th>
											<th>Documento</th>
											<th>Correo</th>
											<th>Telefonos</th>
											<th>Fecha de Registro</th>
											<th>Finanzas</th>
											<th>Estado</th>
											<th>Admision</th>
											<th>Entrevistas</th>
										</tfoot>
									</table>
									</div>
								</div>
							</div>
						</div>
            
          </div>
      </div>
      <!-- end contenido -->
    </section>
    <!-- /.content -->
  </div>

  <!-- Creacion de Modal para ver datos -->
  <div class="modal fade" id="mdl_datos_inscritos">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">X</span>
          </button>
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
                  <b >Solicitudes</b> <a class="pull-right" id="mdl-solicitudes"></a>
                </li>
              </ul>

              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Otros datos</h3>
                </div>
                <div class="box-body">
					<div class="row">
						<div class="col-md-6">
							<strong><i class="fa fa-book margin-r-5"></i> Educacion</strong>
							<p class="text-muted" id="mdl-educacion"></p>
						</div>
						<div class="col-md-6">
							<strong><i class="fa fa-phone margin-r-5"></i> Numeros de celular</strong>
							<p class="text-muted" id="mdl-celphone"></p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<strong><i class="fa fa-envelope margin-r-5"></i> Email</strong>
							<p class="text-muted" id="mdl-email"></p>
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-md-6">
							<div class="box box-solid sombra">
								<div class="box-header bg-success">
									<strong><i class="fa fa-pencil margin-r-5"></i> Documentos</strong>
								</div>
								<div class="box-body">
									<div id="mdl-icons-documents"></div>
								</div>
							</div>
							<div class="box box-solid sombra">
								<div class="box-header bg-success">
								<strong><i class="fa fa-pencil margin-r-5"></i> Documentos De solicitud</strong>
								</div>
								<div class="box-body">
									<div id="mdl-icons-filesOfSol"></div>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="box box-solid sombra">
								<div class="box-header bg-success">
								<h3 class="box-title"><i class="fa fa-pencil margin-r-5"></i>Descuentos</h3>
								</div>
								<div class="box-body" id="discountsBodyAndRequirements">
								</div>
							</div>
						</div>
					</div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Final de Modal -->


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

  <div id="contentModals"></div>
	<!-- /.modal -->
	
	<?php
		$this->load->view('modals/detalles_finanzas');
	?>
<!-- 
  </div>
</div> -->


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
<script src="/assets/js/global_vars.js"></script>
<script src="/dist/js/jquery-externs/jquery.dataTables.min.js"></script>
<?php
	$this->load->view('modals/detalles_entrevistas'); 
	$this->load->view('modals/calendar_entrevistas');
	 
?>

<script src="/dist/js/jquery-externs/bootbox.min.js"></script>
<script src="/dist/js/jquery-externs/dataTables.buttons.min.js"></script>
<script src="/dist/js/jquery-externs/buttons.flash.min.js"></script>
<script src="/dist/js/jquery-externs/jszip.min.js"></script>
<script src="/dist/js/jquery-externs/pdfmake.min.js"></script>
<script src="/dist/js/jquery-externs/buttons.html5.min.js"></script>
<script src="/dist/js/jquery-externs/buttons.print.min.js"></script>
<script src="/bower_components/select2/dist/js/select2.min.js"></script>
<script src="/bower_components/datetimepicker/build/jquery.datetimepicker.full.min.js"></script>
<script src='<?=base_url()?>assets/plugins/calendar/core/main.js'></script>
<script src='<?=base_url()?>assets/plugins/calendar/interaction/main.js'></script>
<script src='<?=base_url()?>assets/plugins/calendar/daygrid/main.js'></script>
<script src="/assets/js/dboard_inscripciones.js"></script>
<style>
.datepicker {
      z-index: 1600 !important; /* has to be larger than 1050 */
    }
</style>
<script>
	$('#select2-estado-finanzas').select2();
	$('#select2-estado-admision').select2();
	$(document).ready(function(){
		$.datetimepicker.setLocale('es');
	})
</script>
</body>
</html>
