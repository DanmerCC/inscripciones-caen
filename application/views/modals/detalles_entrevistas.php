<div class="modal fade" tabindex="-1" role="dialog" id="mdl_entrevistas">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Entrevista</h4>
      </div>
      <div class="modal-body">
      <div class="panel-body"  id="mdl_body_entrevistas">
				<a class="btn btn-block btn-social btn-vk">
					<i class="fa fa-vk"></i> Cometnario
				</a>
	</div>
		<div id="mdl-id" data-idinscripcion=""></div>
      </div>
      <div class="modal-footer">
		<button type="button" class="btn btn-primary" id="btnFormSave" data-dismiss="modal">Guardar</button>
		<button type="button" class="btn btn-default" id="btnCForm" data-dismiss="modal">Cerrar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>
var MDL_ENTREVISTAS_STATE_PENDIENTE=<?=$this->StateInterviewProgramed_model->PENDIENTE; ?>;
var MDL_ENTREVISTAS_STATE_REALIZADA=<?=$this->StateInterviewProgramed_model->REALIZADA; ?>;

var MDL_ENTREVISTAS_INSCRIPCION={
	open:open_mdl_entrevistas_inscripcion_function,
	clean:limpiar_mdl_entrevistas_inscripcion,
	makeBody:make_body_mdl_entrevistas_inscripcion
}

function open_mdl_entrevistas_inscripcion_function(id_inscripcion,successCallBack){
	$("#mdl_entrevistas").modal('show')
	$.ajax({
		type: "get",
		url: "/admin/entrevista/byinscripcion/"+id_inscripcion,
		data: "",
		dataType: "json",
		success: function (response) {
			MDL_ENTREVISTAS_INSCRIPCION.clean();
			if(typeof response.id =='undefined' || response.id!=null){
				$("#mdl_body_entrevistas").html(make_form_programar_entrevista())
			}else{
				$("#mdl_body_entrevistas").html(make_body_mdl_entrevistas_inscripcion())
				
			}
			$("#mdl_entrevistas").modal('show')
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
		}
	});
}

function limpiar_mdl_entrevistas_inscripcion(id){
	$("#mdl_body_entrevistas").html("")
	$("#mdl_body_entrevistas #mdl_body_entrevistas").data("mdl-id",NULL);
}

function make_body_mdl_entrevistas_inscripcion(){
	return `
	<div class="info-box bg-yellow">
            <span class="info-box-icon"><i class="fa fa-calendar"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Entrevista Programada</span>
              <span class="info-box-number">41,410</span>

              <div class="progress">
                <div class="progress-bar" style="width: 70%"></div>
              </div>
                  <span class="progress-description">
                    70% Increase in 30 Days
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
	`;
}

function make_form_programar_entrevista(){
	return `
		<div>
			<form id='frm-mdl-create-entrevista'>
				<div class="form-control">
					<label for="fecha_programado">Fecha programado</label>
					<input type="date" name="fecha_programado" id="fecha_programado">
				</div>
			</form>
		</div>
	`;
}

$(document).ready(function(){
	$("#btnFormSave").on('click',function(){
		var fecha_programado=$("#mdl_body_entrevistas #fecha_programado").val();
		console.log(fecha_programado)
	});
});
</script>
