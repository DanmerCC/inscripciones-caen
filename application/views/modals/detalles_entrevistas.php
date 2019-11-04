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
	makeBody:make_body_mdl_entrevistas_inscripcion,
	close:close_body_mdl_entrevistas_inscripcion,
	onsave:undefined
}

function open_mdl_entrevistas_inscripcion_function(id_inscripcion,successCallBack){
	//$("#mdl_entrevistas").modal('show')
	$.ajax({
		type: "get",
		url: "/admin/entrevista/byinscripcion/"+id_inscripcion,
		data: "",
		dataType: "json",
		success: function (response) {
			MDL_ENTREVISTAS_INSCRIPCION.clean();
			if(typeof response.id =='undefined' || response.id==null){
				$("#mdl_body_entrevistas").html(make_form_programar_entrevista(id_inscripcion))
			}else{
				$("#mdl_body_entrevistas").html(make_body_mdl_entrevistas_inscripcion(id_inscripcion,response))
			}
			
			$("#mdl_entrevistas").modal('show')
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
		}
	});
}

function limpiar_mdl_entrevistas_inscripcion(){
	$("#mdl_body_entrevistas").html("")
	$("#mdl_body_entrevistas #mdl_body_entrevistas").data("mdl-id",undefined);
}

function make_body_mdl_entrevistas_inscripcion(idInscripcion,programacion){
	return `
	<div class="info-box bg-yellow">
            <span class="info-box-icon"><i class="fa fa-calendar"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Entrevista Programada</span>
              <span class="info-box-number">${programacion.fecha_programado}</span>

              <div class="progress">
                <div class="progress-bar" style="width: 100%"></div>
              </div>
                  <span class="progress-description">
                    
                  </span>
			</div>
			<!-- /.info-box-content -->
			
		  </div>
	`;
}

function make_form_programar_entrevista(id){
	return `
		<div>
			<form id='frm-mdl-create-entrevista'>
				<div class="form-control">
					<label for="fecha_programado">Nueva Fecha programado</label>
					<input type="datetime-local" name="fecha_programado" id="fecha_programado">
					<input type="number" name="id_inscripcion" id="id_inscripcion" hidden="hidden" value="${id}">
				</div>
				<div class="form-group">
					<div class="btn btn-primary" onclick="agregarNuevaProgramacion();">Guardar</div>
				</div>
			</form>
		</div>
	`;
}

function make_form_reprogramar_entrevista(id){
	return `
		<div>
			<form id='frm-mdl-create-entrevista'>
				<div class="form-control">
					<label for="fecha_programado">Nueva Fecha programado</label>
					<input type="datetime-local" name="fecha_programado" id="fecha_programado">
					<input type="number" name="id_inscripcion" id="id_inscripcion" hidden="hidden" value="${id}">
				</div>
				<div class="form-group">
					<div class="btn btn-primary" onclick="cambiarFechaProgramacion();">Guardar</div>
				</div>
			</form>
		</div>
	`;
}

function agregarNuevaProgramacion(){
	if(validarDateInputlocal($("#fecha_programado"))){
		$.ajax({
			type: "post",
			url: "/admin/entrevista/create",
			data: {
				fecha_programado:$("#fecha_programado").val(),
				id_inscripcion:$("#id_inscripcion").val()
			},
			success: function (response) {
				if(response.status=='OK'){
					MDL_ENTREVISTAS_INSCRIPCION.close();
					if (typeof MDL_ENTREVISTAS_INSCRIPCION.onsave !='undefined'){
						MDL_ENTREVISTAS_INSCRIPCION.onsave();
					}
				}
			}
		});
	}
	
}

function validarDateInputlocal($object){
	if($object.val()==''){
		alert('Ingrese una fecha completa')
		return false
	}

	return true
}

function close_body_mdl_entrevistas_inscripcion(){
	$("#mdl_entrevistas").modal('hide')
	MDL_ENTREVISTAS_INSCRIPCION.clean()
}
$(document).ready(function(){
	$("#btnFormSave").on('click',function(){
		var fecha_programado=$("#mdl_body_entrevistas #fecha_programado").val();
		console.log(fecha_programado)
	});
	$('#mdl_body_entrevistas #fecha_programado_text').on('shown.bs.modal', function() {
		$('.daterangepicker').css('z-index','4000');
	}); 
});
</script>
