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
        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class=""><!-- container -->
          <div class="panel-body table-responsive" id="listadoregistros">
                <div class="box box-primary">
                    <div class="box-header">
                        <button class="btn btn-primary pull-right" onclick="agregarNuevoBeneficioPrograma()"> <i class="fa fa-plus"></i> Agregar nuevo beneficio programa</button>
                    </div>
                    <div class="box-body">
                        <table id="dataTable1" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
                            <thead>
                                <th>Opciones</th>
                                <th>Curso</th>
                                <th>Nombre beneficio</th>
                            </thead>
                            <tfoot>
                                <th>Opciones</th>
                                <th>Curso</th>
                                <th>Nombre beneficio</th>
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
    <div class="modal fade" tabindex="-1" role="dialog" id="form_discount" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Beneficio programa</h4>
                </div>
                <div class="modal-body">
                    <div class="panel-body">
                        <form class="form-horizontal" id="formularioregistros" role="form">
                            <input type="hidden" name="cursodiscount_id" id="cursodiscount_id">
                            <div class="form-group">
                                <label for="curso_id" class="col-lg-2 control-label">Cursos</label>
                                <div class="col-lg-10">
                                    <div class="input-group col-lg-12">
                                        <select class="form-control validar" id="curso_id" name="curso_id" placeholder="Cursos">
                                            <option value="">Elejir::</option>
                                            <option value="">Mastreria em dadas</option>
                                            <option value="">Desarrollo y defensa nacionañ</option>
                                            <option value="">Otro</option>
                                        </select>
                                    </div>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="discount_id" class="col-lg-2 control-label">Beneficios</label>
                                <div class="col-lg-10">
                                    <div class="input-group col-lg-12">
                                        <select class="form-control validar" id="discount_id" name="discount_id" placeholder="Beneficio">
                                            <option value="">Elejir::</option>
                                            <option value="">Beca 19</option>
                                            <option value="">Primer puesto</option>
                                            <option value="">Model</option>
                                        </select>
                                    </div>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" id="btnFormPorgrama" data-dismiss="modal">Cerrar</button>
                    <button id="btnActualizarPr" type="submit" class="btn btn-primary" onclick="save()" form="formPro">Guardar</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="viewRequirementModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Requerimientos de beneficios: </h4>
                </div>
                <div class="modal-body">
                    <div class="panel">
                        <div class="panel-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Nombre</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody id="cuerpoTableRequirements">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" id="btnFormPorgrama" data-dismiss="modal">Cerrar</button>
                    <button id="btnActualizarPr" type="submit" class="btn btn-primary" onclick="save()" form="formPro">Guardar</button>
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

<script src="/assets/js/dboard_cursodiscount.js"></script>

</body>
</html>