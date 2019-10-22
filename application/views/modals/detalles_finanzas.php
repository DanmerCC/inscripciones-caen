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
var MDL_DETALLE_FINANZAS_AUTORIZADO=<?=$this->EstadoFinanzas_model->AUTORIZADO; ?>

var MDL_DETALLE_FINANZAS={
	open:open_function,
	clean:limpiar_function
}

function open_function(id_inscripcion,successCallBack){
	$.ajax({
		type: "get",
		url: "/admin/details/inscripcion/"+id_inscripcion,
		data: "",
		dataType: "json",
		success: function (response) {
			let inscripcion=response;
			let observacion=response.ultima_observacion
			let autorizacion=response.ultima_autorizacion

			limpiar_function()
			var new_content_html="";
			if(inscripcion.estado_finanzas_id==MDL_DETALLE_FINANZAS_AUTORIZADO){
				new_content_html=new_content_html+make_html_infobox('Aprobado por Finanzas:'+autorizacion.autor.correo,autorizacion.tipo.nombre,autorizacion.comentario)
			}else{
				if(typeof observacion !='undefined'){
					new_content_html=new_content_html+make_html_comentario(observacion.comentario)
				}
			}
			
				
			if( typeof successCallBack !='undefined'){
				successCallBack()
			}
			$("#mdl_body_details_finance").html(new_content_html)
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

function make_html_infobox(title,subtitle,description){
	return `<div class="info-box bg-green">
		<span class="info-box-icon"><i class="fa fa-thumbs-o-up"></i></span>

		<div class="info-box-content">
			<span class="info-box-text">${title}</span>
			<span class="info-box-number">${subtitle}</span>

			<div class="progress">
			<div class="progress-bar" style="width: 100%"></div>
			</div>
				<span class="progress-description">
				${description}
				</span>
		</div>
		<!-- /.info-box-content -->
	</div>
	`
}
</script>
