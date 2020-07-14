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
<link href='https://cdn.datatables.net/select/1.3.1/css/select.dataTables.min.css' rel='stylesheet' />
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
        <li><a href="/"><i class="fa fa-dashboard"></i> Admision</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
			<div class=""><!-- container -->
					<table class="table table-striped table-bordered table-condensed">
						<thead>
							<tr>
								<th>Alumno</th>
							<th>Programa</th>
							<th>Codigo de Inscripcion</th>
							</tr>
							
						</thead>
						<tbody>
							<?php for ($i=0; $i < count($admisions); $i++):?>
							<tr>
								<td><?=$admisions[$i]->alumno_nombres ?> <?=$admisions[$i]->alumno_apellido_paterno ?> <?=$admisions[$i]->alumno_apellido_materno ?></td>
								<td><?=$admisions[$i]->curso_nombre ?></td>
								<td><?=$admisions[$i]->alumno_id ?></td>
							</tr>
							<?php endfor; ?>
						</tbody>
					</table>
					
					<iframe src="/administracion/acta/view/<?=$id_acta?>" frameborder="0" width="100%" height="500px"></iframe>
					<!--<div class="btn btn-danger btn-lg">Anular esta acta</div>-->
      </div>
      <!-- end contenido -->
    </section>
    <!-- /.content -->
  </div>

  <!-- Creacion de Modal para ver datos -->
  
  <div id="uniquedinamiccontainer">
	  
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
<script src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
<script src='<?=base_url()?>assets/plugins/calendar/core/main.js'></script>
<script src='<?=base_url()?>assets/plugins/calendar/interaction/main.js'></script>
<script src='<?=base_url()?>assets/plugins/calendar/daygrid/main.js'></script>
<script>
	var NO_COLUMN_VISIBLE_VAR_FROM_BACK = <?php echo json_encode(empty($_GET["ca"])?[]:$_GET["ca"]); ?>;
	var can_change_inscription_to_admision = !!!<?php echo (int)$can_change_to_admision ?>;
</script>
<?php
	$this->load->view('modals/state_manager_modal'); 
?>
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
