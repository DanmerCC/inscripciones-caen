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
		<div style="z-index: 99999;font-weight: bold; width: 100%; height: 48px; background-color: #e5e53a; display:grid; place-items: center">
			Esta versión Pronto se dejará de usar, te recomendamos el nuevo sistema de Matriculas
			<a href="https://matriculas.caen.edu.pe/" target="_blank">enlace aquí</a>
		</div>
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
          <div class="panel-body table-responsive" id="listadoregistros">
						<div class="box box-primary" >
							<div class="box-body" style="">
								<table id="dataTable1" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
									<thead>
											<th>Conteo</th>
										<th>Nombres y apellidos</th>
										<th>Correo</th>
										<th>Celular</th>
										<th>Centro laboral</th>
										<th>Consulta</th>
										<th>Programa</th>
										<th>Fecha de registro</th>
										<th>Condicion</th>
									</thead>
									<tfoot>
										<th>Conteo</th>
										<th>Nombres y apellidos</th>
										<th>Correo</th>
										<th>Celular</th>
										<th>Centro laboral</th>
										<th>Consulta</th>
										<th>Programa</th>
										<th>Fecha de registro</th>
										<th>Condicion</th>
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

<!-- <script src="/assets/js/dboardAlumno.js"></script> -->
<script src="/assets/js/dboardInformes.js"></script>
</body>
</html>
