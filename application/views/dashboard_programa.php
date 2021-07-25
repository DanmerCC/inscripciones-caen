<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Postulante CAEN</title>
<?php $this->load->view('adminlte/linksHead');?>
<!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/jquery.dataTables.min.css"> -->
<link rel="stylesheet" href="/dist/css/jquery-externs/jquery.dataTables.min.css">
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
        <li><a href="/"><i class="fa fa-dashboard"></i> Mi sitio</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class=""><!-- container -->
          <div class="panel-body table-responsive" id="listadoregistros">
					
						<div class="box box-primary" >
							<div class="box-body" style="">
								<table id="dataTable2" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
									<thead>
										<th>Opciones</th>
										<th>Nombre</th>
										<th>Duracion</th>
										<th>Costo Total</th>
										<th>Vacantes</th>
										<th>Fecha Inicio</th>
										<th>Fecha Final</th>
										<th>Tipo de curso</th>
										<th>Estado</th>
									</thead>
									<tfoot>
										<th>Opciones</th>
										<th>Nombre</th>
										<th>Duracion</th>
										<th>Costo Total</th>
										<th>Vacantes</th>
										<th>Fecha Inicio</th>
										<th>Fecha Final</th>
										<th>Tipo de curso</th>
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
    <div class="modal fade" tabindex="-1" role="dialog" id="form_programa">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Programa</h4>
        </div>
        <div class="modal-body">
        <div class="panel-body" style="height: 400px;" id="formularioregistros">
          <form name="formulario" id="formPro" method="post" action="">
              <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                  <label>Nombre:</label>
                  <input type="hidden" name="id_curso" id="id_curso">
                  <input type="text" class="form-control" name="nombre" id="nombre" maxlength="150" placeholder="Nombre" required="">
              </div>
              <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                  <label for ="numeracion">Numeracion:</label>
                  <input type="text" class="form-control" name="numeracion" id="numeracion" maxlength="10" placeholder="Numeracion" required>
              </div>
              <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                  <label>Duración:</label>
                  <input type="text" class="form-control" name="duracion" id="duracion" maxlength="50" placeholder="Duración" required="">
              </div>

              <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                  <label>Precio/Costo:</label>
                  <input type="text" class="form-control" name="costo" id="costo" maxlength="50" placeholder="Precio/Costo" required="">
              </div>

              <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                  <label>Vacantes:</label>
                  <input type="text" class="form-control" name="vacantes" id="vacantes" maxlength="50" placeholder="Vacantes" required="">
              </div>

              <div class="form-group col-lg-6 col-md-6 col-sm-6 col-sx-12" >
                  <label>Fecha de Inicio: </label>
                  <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control">
              </div>

              <div class="form-group col-lg-6 col-md-6 col-sm-6 col-sx-12" >
                  <label>Fecha Final: </label>
                  <input type="date" id="fecha_final" name="fecha_final" class="form-control">
              </div>

              <div class="form-group col-lg-6 col-md-6 col-sm-6 col-sx-12" >
                  <label>Tipo de Curso: </label>
                  <select id="idTipo_curso" name="idTipo_curso" class="form-control selectpicker" data-live-search="true"></select>
              </div>
          </form>
      </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" id="btnFormPorgrama" data-dismiss="modal">Cerrar</button>
          <button id="btnActualizarPr" type="submit" class="btn btn-primary" form="formPro" disabled="disabled">Guardar cambios</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

  </div>
</div>

<?php $this->load->view('modals/modal-danger.php');?>

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

<script src="/assets/js/dboardPrograma.js"></script>
<style>
.dropdown:hover .dropdown-menu {
    display: block;
    margin-top: 0; // remove the gap so it doesn't close
 }</style>

</body>
</html>
