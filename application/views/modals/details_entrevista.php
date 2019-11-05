<div class="modal fade" tabindex="-1" role="dialog" id="mdl_entrevistas_options">
	<div class="modal-dialog modal-lg" style="display: block; padding-right: 17px;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Entrevista</h4>
			</div>
			<div class="modal-body">
				<div class="panel-body" id="mdl_body_entrevistas_options">
					
					
				</div>
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" id="btnSave" >Guardar Cambios</button>
				<button type="button" class="btn btn-default" id="btnCForm" data-dismiss="modal">Cerrar</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
	<div id="update-calendar"></div>
</div><!-- /.modal -->
<script>

var MDL_ENTREVISTAS_STATE_PENDIENTE=<?=$this->StateInterviewProgramed_model->PENDIENTE; ?>;
var MDL_ENTREVISTAS_STATE_REALIZADA=<?=$this->StateInterviewProgramed_model->REALIZADA; ?>;

var MDL_ENTREVISTAS_DETAILS={
	id:"mdl_entrevistas_options",
	open:open_mdl_details_entrevista_function,
	clean:limpiar_mdl_details_entrevista,
	close:close_body_mdl_details_entrevista,
	onsave:undefined,
	makeBody:function(entrevista){
		let programa =entrevista.inscripcion.solicitud.programa;
		return `
		<div class="box box-primary">
			<div id="mdl-id" data-entrevistaid="${entrevista.id}"></div>
            <div class="box-header with-border">
              <h3 class="box-title"></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <strong><i class="fa fa-book margin-r-5"></i> Programa</strong>

              <p class="text-muted">
               ${programa.nombre} 
              </p>

              <hr>

              <strong> Estado</strong>

			  <div>
				 <select class='form-control' name="select-mdl-details-entrevistas" id="select-mdl-details-entrevistas">
				 	<option ${entrevista.estado_id==MDL_ENTREVISTAS_STATE_PENDIENTE?'selected':''}value="${MDL_ENTREVISTAS_STATE_PENDIENTE}">Pendiente</option>
				 	<option ${entrevista.estado_id==MDL_ENTREVISTAS_STATE_REALIZADA?'selected':''} value="${MDL_ENTREVISTAS_STATE_REALIZADA}">Realizado</option>
				 </select> 
			  </div>
            </div>
            <!-- /.box-body -->
          </div>`;
	}
}


$(document).ready(function(){
	$('#'+MDL_ENTREVISTAS_DETAILS.id+' #btnSave').click(function(){
		$.ajax({
			type: "POST",
			url: "/admin/entrevista/update",
			data: {
				entrevista_id:$('#'+MDL_ENTREVISTAS_DETAILS.id+" #mdl-id").data('entrevistaid'),
				estado_id:$('#select-mdl-details-entrevistas').val()
			},
			dataType: "json",
			success: function (response) {
				if(response.status=='OK'){
					MDL_ENTREVISTAS_DETAILS.close();
					$("#update-calendar").trigger("click")
				}
			}
		});
	});
})
function open_mdl_details_entrevista_function(id){
	$.ajax({
		type: "get",
		url: "/admin/entrevista/"+id,
		dataType: "json",
		success: function (response) {
			if(response.status=="OK"){
				let entrevista=response.data;
				let _this_modal=$('#'+MDL_ENTREVISTAS_DETAILS.id)
				$('#'+MDL_ENTREVISTAS_DETAILS.id+' #mdl_body_entrevistas_options').html(
					MDL_ENTREVISTAS_DETAILS.makeBody(entrevista)
					);
				$('#'+MDL_ENTREVISTAS_DETAILS.id).modal("show");
			}
		}
	});
}
function limpiar_mdl_details_entrevista(){
	$('#'+MDL_ENTREVISTAS_DETAILS.id+' #mdl_body_entrevistas_options').html('')
}
function close_body_mdl_details_entrevista(){
	$('#'+MDL_ENTREVISTAS_DETAILS.id).modal('hide')
	MDL_ENTREVISTAS_DETAILS.clean()
}
</script>
