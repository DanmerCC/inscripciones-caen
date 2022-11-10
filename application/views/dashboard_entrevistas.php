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
	<link href="/bower_components/select2/dist/css/select2.min.css" rel="stylesheet">
	<style>
	* {
		box-sizing: border-box;
	}

	#inputSearchName {
		background-image: url('<?=base_url()?>assets/img/searchicon.png');
		background-position: 10px 12px;
		background-repeat: no-repeat;
		width: 100%;
		font-size: 16px;
		padding: 12px 20px 12px 40px;
		border: 1px solid #ddd;
		margin-bottom: 12px;
	}
	li.select2-selection__choice {
		color: black !important;
	}
	</style>
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
			<div style="z-index: 99999;font-weight: bold; width: 100%; height: 48px; background-color: #e5e53a; display:grid; place-items: center">
				Esta versión Pronto se dejará de usar, te recomendamos el nuevo sistema de Matriculas
				<a href="https://matriculas.caen.edu.pe/" target="_blank">enlace aquí</a>
			</div>
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
									<input type="text" id="inputSearchName" onkeyup="buscarPorNombre()" placeholder="Buscar por nombres" title="Ingrese un nombre">
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
							<div class="box box-primary">
								<div class="box-header">
									<button class="btn btn-success" onclick="openModalForExport()"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Exportar en excel</button>
								</div>
								<div class="box-body">
									<div id="calendar"></div>		
								</div>
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
		<div class="control-sidebar-bg"></div>
		<div id="virutal"></div>
		<div id="contentModals">
		</div>
	</div>

	<div class="modal fade" tabindex="-1" role="dialog" id="mdl_export_entrevistas">
		<div class="modal-dialog" style="display: block; padding-right: 17px;">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Filtro para exportar entrevistas</h4>
				</div>
				<div class="modal-body">
					<div class="panel-body">
						<div class="form-group">
							<label for="">Curso</label>
							<select class="form-control" style="width:100%;" id="programasExport" name="programasExport[]" multiple="multiple" placeholder="Selecciona cursos">
							</select>
						</div>
						<div class="form-group">
							<label for="">Estado entrevista</label>
							<select class="form-control" style="width:100%;" id="estado_entrevista" name="estado_entrevista" placeholder="Selecciona estado">
								<option value="">Todos</option>
								<option value="1">Pendiente</option>
								<option value="2">Realizado</option>
							</select>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<a href="<?=base_url()?>administracion/vista/exportarData/?estado=" target="_blank" class="btn btn-primary" id="btnExportEntrevista" >Exportar</a>
					<button type="button" class="btn btn-default" id="btnCancelExport" data-dismiss="modal">Cancelar</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<!-- ./wrapper -->
	<?php $this->load->view('adminlte/scriptsFooter'); ?>
	<?php $this->load->view('modals/details_entrevista'); ?>
	<script src=" /build/app.bundle.js"></script>
	<script src=" /assets/js/dboard_entrevistas.js"></script>
	<script>
		function openModalForExport(){
			$("#mdl_export_entrevistas").modal("show");
		}

		function buscarPorNombre() {
			var input, filter, ul, li, a, i, txtValue;
			input = document.getElementById("inputSearchName");
			filter = input.value.toUpperCase();
			ul = document.getElementById("entrevistas-pendientes");
			li = ul.getElementsByTagName("li");
			for (i = 0; i < li.length; i++) {
				a = li[i].getElementsByTagName("a")[0];
				txtValue = a.textContent || a.innerText;
				if (txtValue.toUpperCase().indexOf(filter) > -1) {
					li[i].style.display = "";
				} else {
					li[i].style.display = "none";
				}
			}
		}
		
		function makeUrlToExportData(){
			let programasArray = $("#programasExport").val();
			let estadoEntrevista = $("#estado_entrevista").val();
			let stringProgramas = makeArrayToString(programasArray);
			let rutaExport = '<?=base_url()?>administracion/vista/exportarData/?estado='+estadoEntrevista+''+stringProgramas;
			document.getElementById('btnExportEntrevista').attributes.href.value = rutaExport;
		}
		function makeArrayToString(programasArray){
			var newString = '';
			if(programasArray.length>0){
				for (let indice = 0; indice < programasArray.length; indice++) {
					newString += '&programa[]='+programasArray[indice];
				}
			}
			return newString;
		}

		$(document).ready(function() {
			document.getElementById('programasExport').change = function(){
				makeUrlToExportData();
			};
			document.getElementById('estado_entrevista').change = function(){
				makeUrlToExportData();
			};

			$('#programasExport').select2();
			$('#estado_entrevista').select2();
		});
		
	</script>
</body>

</html>
