<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Postulante CAEN</title>
<?php $this->load->view('adminlte/linksHead');?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/jquery.dataTables.min.css">
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
        <li><a href="/"><i class="fa fa-dashboard"></i> Mi sitio</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class=""><!-- container -->
          <div class="container">
			  <div class="row">
					  <?php
					 	for($i=0;$i<12;$i++): 
					  ?>
					  <div class="col-md-6">
					  	<div id="calendar<?=$i;?>"></div>
					  </div>
					  <?php
					 	endfor;
					  ?>
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

  </div>
</div>


<!-- ./wrapper -->
<?php $this->load->view('adminlte/scriptsFooter');?>

<script src='<?=base_url()?>assets/plugins/calendar/core/main.js'></script>
<script src='<?=base_url()?>assets/plugins/calendar/interaction/main.js'></script>
<script src='<?=base_url()?>assets/plugins/calendar/daygrid/main.js'></script>
<script src="/assets/js/dboardProgramaCalendar.js"></script>


</body>
</html>
