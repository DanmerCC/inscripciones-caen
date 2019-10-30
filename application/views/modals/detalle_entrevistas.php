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
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" id="btnCForm" data-dismiss="modal">Cerrar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>
var MDL_ENTREVISTAS_STATE_PENDIENTE=<?=$this->StateInterviewProgramed_model->PENDIENTE; ?>
var MDL_ENTREVISTAS_STATE_REALIZADA=<?=$this->StateInterviewProgramed_model->REALIZADA; ?>

var MDL_ENTREVISTAS_INSCRIPCION={
	open:open_function,
	clean:limpiar_function
}

function open_function(id_inscripcion,successCallBack){
	$.ajax({
		type: "get",
		url: "/admin/entrevista/byinscripcion/"+id_inscripcion,
		data: "",
		dataType: "json",
		success: function (response) {
			console.log(response)
			//$("#mdl_body_entrevistas").html(new_content_html)
			$("#mdl_entrevistas").modal('show')
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
		}
	});
}
</script>
