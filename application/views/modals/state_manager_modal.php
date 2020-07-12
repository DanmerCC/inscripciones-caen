

<div id="mdl-manager-admision-container"></div>
<script>
	var COLUMN_NAME = 3 
	var COLUMN_STATE = 11
	var MDL_MNG_STATE_ADMISION = {
		/**
		 * objects
		 * [{
		 * 		alumno_id: 0,
		 *		id_curso: 0,
		 *		inscripcion_id: 0,
		 * },...]
		 */
		dataadmid:[],
		create:function(inscripciondata){
			this.dataadmid = this.getIds()
			$("#mdl-manager-admision-container").html(
				this.template(inscripciondata)
			)
			$("#mdl_manager_admision").modal('show')
		},
		succesAdmids:null,
		getIdInscriptions:null,
		getIds:function(){
			if(typeof this.getIdInscriptions == 'null'){
				
				console.error("No se ha definido getIdInscriptions");
				return []
			}else{
				var ids = this.getIdInscriptions()
				return ids
			}
		},
		template(inscripciondata){

			var admitibles = ``
			var hasAInovate = false
			if (Array.isArray(inscripciondata)) {
				for (let indx = 0; indx < inscripciondata.length; indx++) {
					admitibles +=`<button type="button" class="btn btn-default btn-block">${inscripciondata[indx][COLUMN_NAME]}</button>`
				}
			}else{
				`<button type="button" class="btn btn-default btn-block">${inscripciondata[COLUMN_NAME]}</button>`
			}
			return `
			<div class="modal fade" tabindex="-1" role="dialog" id="mdl_manager_admision">
				<div class="modal-dialog modal-lg" style="display: block; padding-right: 17px;">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title">Admitir</h4>
						</div>
						<div class="modal-body">
							<div class="panel-body" id="mdl_body_manager_admision">
							Para esta accion debe tomar en cuenta que las actas de admision no pueden ser borradas solo anuladas ,
							en dicho caso queda sin efecto todos los inscritos que esten incluidos en la acta de admision
							<div class="row">
								${admitibles}
							</div>
							<br>
							<div class="row">
								<div id="admd-container-input">
									<label for="">Acta de admision</label>
									<input class="form-control" type="file" name="file-admd" id="file-admd" onchange="validateInputFile(this)" accept="application/pdf">
								</div>
								</div>
							</div>
							<div id="mdl-id" data-idinscripcion=""></div>
						</div>
						<div class="modal-footer">
							<div class="btn btn-primary" onclick="savemdladmisions()" id="btn-save-admisions" disabled>Guardar</div>
							<button type="button" onclick="closeadmisionmodal()" class="btn btn-default" id="btn_close_manager_admision" data-dismiss="modal">Cerrar</button>
						</div>
					</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			</div><!-- /.modal -->

			`
		},
		save:function(){
			var data = this.dataadmid
			return new Promise((resolve, reject) => {
				var formdata  = new FormData
				for (let index = 0; index < data.length; index++) {

					formdata.append('inscripcion_id['+index+']',data[index].inscripcion_id)
					formdata.append('id_curso['+index+']',data[index].id_curso)
					formdata.append('alumno_id['+index+']',data[index].alumno_id)
					
				}
				
				formdata.append('file-admd',document.getElementById('file-admd').files[0])
				$.ajax({
					url: '/administracion/admidslist',
					type: 'POST',
					cache: false,
					contentType: false,
					processData: false,
					data: formdata,
					success: function (data) {
						if(data.success){
							//$('#mdl_manager_admision').modal('hide')
							$('#admd-container-input').html(`
								<div class="callout callout-success">
									<h4>Se logro crear las admisiones con exito!</h4>
								</div>
								<iframe src="${data.data.url}" frameborder="0" width="100%" height="500px"></iframe>
							`)
							activateButton(false)
						}
						resolve(data)
					},
					error: function (error) {
						reject(error)
					},
				})
			})
		},
		close(){
			$("#mdl_manager_admision").modal('hide')
		}
	}

	function validateInputFile(object){
		if(object.files.length == 1){
			$("#btn-save-admisions").removeAttr('disabled')
		}else{
			$("#btn-save-admisions").attr('disabled',true)
		}
	}

	function activateButton(state){
		if(state){
			$("#btn-save-admisions").removeAttr('disabled')
		}else{
			$("#btn-save-admisions").attr('disabled',true)
		}
	}

	function savemdladmisions(){
		MDL_MNG_STATE_ADMISION.save().
		then(MDL_MNG_STATE_ADMISION.succesAdmids).
		catch((error)=>{
			console.error(error)
			console.error(error.status)
			if(error.status==401){
				alert('No tienes los permisos suficientes para hacer esto consulta con el administrador del sistema')
			}
		});
	}

	function closeadmisionmodal(){
		MDL_MNG_STATE_ADMISION.close()
	}
</script>
