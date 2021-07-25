<div class="modal fade" tabindex="-1" role="dialog" id="newForm_programa">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Registro de nuevo Programa</h4>
      </div>
      <div class="modal-body">
      <div class="panel-body" style="height: 400px;" id="">
        <form name="formNewPrograma" id="formNewPrograma" method="post" action="">
            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <label>Nombre:</label>
                <input type="text" class="form-control" name="nnombre" id="nnombre" maxlength="150" placeholder="Nombre" required="">
            </div>
            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <label for ="numeracion">Numeracion:</label>
                <input type="text" class="form-control" name="nnumeracion" id="nnumeracion" maxlength="10" placeholder="Numeracion" required>
            </div>
            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <label>Duración:</label>
                <input type="text" class="form-control" name="nduracion" id="nduracion" maxlength="50" placeholder="Duración" required="">
            </div>

            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <label>Precio/Costo:</label>
                <input type="text" class="form-control" name="ncosto" id="ncosto" maxlength="50" placeholder="Precio/Costo" required="">
            </div>
            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <label>Vacantes:</label>
                <input type="text" class="form-control" name="nvacantes" id="nvacantes" maxlength="50" placeholder="Vacantes" required="">
            </div>
            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-sx-12" >
                <label>Fecha de Inicio: </label>
                <input type="date" id="nfecha_inicio" name="nfecha_inicio" class="form-control">
            </div>
            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-sx-12" >
                <label>Fecha Final: </label>
                <input type="date" id="nfecha_final" name="nfecha_final" class="form-control">
            </div>
            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-sx-12" >
                <label>Tipo de Curso: </label>
                <select id="nidTipo_curso" name="nidTipo_curso" class="form-control selectpicker" data-live-search="true">
                <?php for ($i=0; $i < count($tipo) ; $i++) { ?> 
                    <option value= <?=$tipo[$i]["idTipo_curso"]?> > <?=$tipo[$i]["nombre"] ?></option>
                <?php } ?>
                </select>
            </div>
        </form>
    </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" id="btnCForm" data-dismiss="modal">Cerrar</button>
        <button id="btnActualizarPr" type="submit" class="btn btn-primary" form="formNewPrograma" disabled="disabled">Guardar cambios</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
