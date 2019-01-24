<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Postulante CAEN</title>
<?php $this->load->view('adminlte/linksHead');?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/jquery.dataTables.min.css">
</head>
<body class="hold-transition skin-blue-light sidebar-mini">
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
        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class=""><!-- container -->   
          <div class="panel-body table-responsive" id="listadoregistros">
            <table id="dataTable1" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
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

            <table id="dataTable2" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
              <thead>
                <th>Opciones</th>
                <th>nombre</th>
                <th>duracion</th>
                <th>costo_total</th>
                <th>vacantes</th>
                <th>fecha_inicio</th>
                <th>fecha_final</th>
                <th>Tipo</th>
                <th>estado</th>
              </thead>
              <tfoot>
                <th>Opciones</th>
                <th>nombre</th>
                <th>duracion</th>
                <th>costo_total</th>
                <th>vacantes</th>
                <th>fecha_inicio</th>
                <th>fecha_final</th>
                <th>Tipo</th>
                <th>estado</th>
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

  <div id="contentModals"></div>
</div>
<!-- ./wrapper -->

<?php $this->load->view("modals/form_programa");?>
<?php $this->load->view('adminlte/scriptsFooter');?>

<script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>
<script src="/assets/js/dashboard.js"></script>

</body>
</html>
