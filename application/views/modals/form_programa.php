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
        <button id="btnActualizarPr" type="submit" class="btn btn-primary" form="formPro">Guardar cambios</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
