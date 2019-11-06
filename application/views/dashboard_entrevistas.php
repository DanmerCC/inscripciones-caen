<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=gb18030">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Entrevistas CAEN</title>
	<?php $this->load->view('adminlte/linksHead'); ?>
	<link href='/assets/plugins/@fullcalendar/core/main.css' rel='stylesheet' />
	<link href='/assets/plugins/@fullcalendar/daygrid/main.css' rel='stylesheet' />
	<link href='/assets/plugins/@fullcalendar/timegrid/main.css' rel='stylesheet' />
	<link href='/assets/plugins/@fullcalendar/list/main.css' rel='stylesheet' />
</head>

<body class="hold-transition skin-blue-light sidebar-mini">
	<!-- Site wrapper -->
	<div class="wrapper">


		<?= $mainHeader; ?>
		<!-- =============================================== -->

		<!-- Left side column. contains the sidebar -->
		<?= $mainSidebar; ?>

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
				<div class="">
					<div class="row">
						<div class="col-md-4">
							<div>
								<select class="form-control" name="" id="slct-programs-filter-calendar"></select>
							</div>
							<div class="box box-primary" id="box-entrevistas-pendientes">
								<div class="box-header with-border">
									<h3 class="box-title">Pendientes por programar</h3>

									<div class="box-tools pull-right">
										<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
										</button>
										<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
									</div>
								</div>
								<!-- /.box-header -->
								<div class="box-body" style="">
									<ul class="products-list product-list-in-box" id="entrevistas-pendientes">
										
									</ul>
								</div>
								<!-- /.box-body -->
								<div class="box-footer text-center" style="">
									<a href="javascript:void(0)" class="uppercase"></a>
								</div>
								<!-- /.box-footer -->
							</div>
						</div>
						<div class="col-md-8">
							<div id="calendar"></div>
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
		<div id="virutal"></div>
		<div id="contentModals">

		</div>
	</div>


	<!-- ./wrapper -->
	<?php $this->load->view('adminlte/scriptsFooter'); ?>
	<?php $this->load->view('modals/details_entrevista'); ?>
	<script src=" /build/app.bundle.js"></script>
	<script src=" /assets/js/dboard_entrevistas.js"></script>
</body>

</html>
