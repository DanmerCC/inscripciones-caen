<div class="modal fade" tabindex="-1" role="dialog" id="mdl_details_finance">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Detalles Finanzas</h4>
      </div>
      <div class="modal-body">
      <div class="panel-body"  id="mdl_body_details_finance">
				<a class="btn btn-block btn-social btn-vk">
					<i class="fa fa-vk"></i> Cometnario
				</a>
    </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" id="btnCForm" data-dismiss="modal">Cerrar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>
var MDL_DETALLE_FINANZAS={
	open:open_function,
	clean:limpiar_function
}

function open_function(id_inscripcion,successCallBack){
	$.ajax({
		type: "get",
		url: "/admin/finobservacion/inscripcion/"+id_inscripcion,
		data: "",
		dataType: "json",
		success: function (response) {
			limpiar_function()
			if(typeof response.comentario !='undefined'){
				$("#mdl_body_details_finance").html(make_html_comentario(response.comentario))
			}
				
			if( typeof successCallBack !='undefined'){
				successCallBack()
			}
			$("#mdl_details_finance").modal('show')
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
		}
	});
}

function limpiar_function(){
	$("#mdl_body_details_finance").html("");
}

function make_html_comentario(comentario){
	return `<a class="btn btn-block btn-social btn-vk">
					<i class="fa fa-commenting"></i> ${comentario}
				</a>`;
}
</script>
