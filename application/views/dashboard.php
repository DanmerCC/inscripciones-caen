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
      <div>
				<div class="row">
				<div class="col-lg-3 col-xs-6">
				<?php for($i = 0;$i< count($resume_programas);$i++): ?>

					<?php

					$acum_count = 0;

					/*for ($ii=0; $ii <count($resume_data) ; $ii++) { 
						if($resume_data->id_curso == $resume_programas[$i]["id_curso"]){
							$acum_count = $acum_count +$resume_data->incripcion_count;
						}
					}*/
					?>
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3> <?=$acum_count ?></h3>

              <p><?=$resume_programas["nombre_programa"] ?></p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer">
              More info <i class="fa fa-arrow-circle-right"></i>
            </a>
					</div>
					<!-- small box -->
				<?php endfor; ?>
        </div>
				</div>


				<?php
					echo'<br>';
					print_r($resume_data);
					echo'<br>';

					echo'<br>';
					print_r($resume_programas);
					echo'<br>';
				?>
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
