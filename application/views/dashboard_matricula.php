<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
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
        <li><a href="/administracion/home"><i class="fa fa-dashboard"></i> Home</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class=""><!-- container -->
          <div class="panel-body table-responsive" id="listaInscritos">
            Inscripciones
            <table id="tblInscritos" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
              <thead>
                <th>Opciones</th>
                <th>nombres</th>
                <th>apellido_paterno</th>
                <th>apellido_materno</th>
                <th>tipo_financiamiento</th>
                <th>documento</th>
                <th>curso_numeracion</th>
                <th>fecha_registro</th>
                <th>Estado</th>
              </thead>
              <tfoot>
                <th>Opciones</th>
                <th>nombres</th>
                <th>apellido_paterno</th>
                <th>apellido_materno</th>
                <th>tipo_financiamiento</th>
                <th>documento</th>
                <th>curso_numeracion</th>
                <th>fecha_registro</th>
                <th>Estado</th>
              </tfoot>
            </table>
          </div>
          <div class="panel-body table-responsive" id="listadoregistros">
            Solicitudes Admitidas
            <table id="dataTable1" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
              <thead>
                <th>Resolucion</th>
                <th>Dni</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Programa</th>
                <th>Fecha de pago</th>
                <th>Fecha de Registro</th>
              </thead>
              <tfoot>
                <th>Resolucion</th>
                <th>Dni</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Programa</th>
                <th>Fecha de pago</th>
                <th>Fecha de Registro</th>
              </tfoot>
            </table>
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
    <div class="modal fade" tabindex="-1" role="dialog" id="form_matricula">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Matricula</h4>
        </div>
        <div class="modal-body">
        <div class="panel-body" style="height: 100px;" id="formularioregistros">
          <form name="formulario" id="formPro" method="post" action="">
            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <label>Alumno:</label>
                <input type="hidden" name="id_alumno" id="id_alumno" disabled="" readonly="">
                <input type="text" class="form-control" name="nombre" id="nombre" maxlength="150" placeholder="Nombre" readonly="" required="">
            </div>
            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <label for ="numeracion">Programa:</label>
                <input type="hidden" name="id_programa" id="id_programa" disabled="">
                <input type="text" class="form-control" name="nombre_programa" id="nombre_programa" maxlength="10" placeholder="Numeracion" readonly="" required>
            </div>
          </form>
      </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" id="btnFormPorgrama" data-dismiss="modal">Cerrar</button>
          <button id="btnActualizarPr" type="submit" class="btn btn-primary" form="formPro">Guardar nueva matricula</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

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

<script src="/assets/js/dboardMatricula.js"></script>

</body>
</html>
