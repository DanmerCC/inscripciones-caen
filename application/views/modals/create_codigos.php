

<div id="mdl-manager-studentadmincodes-container"></div>
<script>
	var MDL_MNG_CREATE_CODESTUDENT = {
		
		dataadmid:[],
		create:function(objectdata){
			if(objectdata.filter(x=>x.cod_student_admin!=null).length>0){
				alert("Se a seleccionado un alumno que ya tiene codigo")
				return false
			}

			//var randomid = getRandomBetWeen(160,320).toString(16)
			var lastCode =
			getLastCode().then((response)=>{
				$("#mdl-manager-studentadmincodes-container").html(
					MDL_MNG_CREATE_CODESTUDENT.template(objectdata,response.data)
				).promise().then(()=>{
					$("#btn_mdlcodelaumn").on('click',function(){
						MDL_MNG_CREATE_CODESTUDENT.save()
					})
					$("#btn_close_mdlcodelaumn").on('click',function(){
						MDL_MNG_CREATE_CODESTUDENT.close()
					})
				})
				$("#mdl_codestudent_admin").modal('show')
			})

			

			return true
			
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
		template(inscripciondata,lastcode){
			var promLast = null
			
			var admitibles = ``
			var hasAInovate = false
			for (let indx = 0; indx < inscripciondata.length; indx++) {
				admitibles +=`
				<div class="">
					<div class="col-md-4">
						<div class='form-group'>
							<label>
							${inscripciondata[indx]["apellido_paterno"]} ${inscripciondata[indx]["apellido_materno"]} ${inscripciondata[indx]["nombres"]}:${inscripciondata[indx]["documento"]}
							</label>
							<input class='form-control' data-idalumn="${inscripciondata[indx]["alumno"]}" type='text' value="${lastcode+indx+1}"/>
						</div>
					</div>
				</div>
				`
			}
			return `
			<div class="modal fade" tabindex="-1" role="dialog" id="mdl_codestudent_admin">
				<div class="modal-dialog modal-lg" style="display: block; padding-right: 17px;">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title">Crear codigos</h4>
						</div>
						<div class="modal-body">
							<div class="row">
								<div class='col-md-12'>
									El codigo mas grande actualmente es :${lastcode}
								</div>
							</div>
							<br>
							<div class="row">
								<div class='col-md-12'>
									Se creara codigos para :
								</div>
							</div>
							<br>
							<div class="row" id="inputs-container-mdl-codes">
								${admitibles}
							</div>
						</div>
						<div class="modal-footer">
							<div class="btn btn-primary" id="btn_mdlcodelaumn">Crear codigos</div>
							<button type="button" class="btn btn-default" id="btn_close_mdlcodelaumn" data-dismiss="modal">Cerrar</button>
						</div>
					</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			</div><!-- /.modal -->

			`
		},
		save:function(){
			var data = this.dataadmid
			return new Promise((resolve, reject) => {

				var data = []
				$("#inputs-container-mdl-codes input").each((index,el)=>{
					data.push($(el).data('idalumn')+','+$(el).val())
				})
				var formdata = new FormData()
				
				formdata.append('std_cods',data.join(';'))
				$.ajax({
					url: '/admin/codestudent',
					type: 'POST',
					cache: false,
					contentType: false,
					processData: false,
					data: formdata,
					success: function (data) {
						if(data.status){
							var btnclose = $("#btn_mdlcodelaumn")
							btnclose.attr('disabled','disabled')
							btnclose.unbind('click')
							MDL_MNG_CREATE_CODESTUDENT.succesAdmids(data)
							MDL_MNG_CREATE_CODESTUDENT.close()
							
						}
						resolve(data)
					},
					error: function (error) {
						if(error.status == 401){
							alert("No tienes permisos necesarios para crear codigos de alumnos")
						}
						reject(error)
					},
				})
			})
		},
		close(){
			$("#mdl_codestudent_admin").modal('hide')
		}
	}
	function close_modal_code_student_admin(){
		MDL_MNG_CREATE_CODESTUDENT.close()
	}

	function getLastCode() {
		return new Promise((resolve,reject)=>{
			$.ajax({
				type: "get",
				url: "/administracion/lastcode",
				//dataType: "text",
				success:function(response){
					resolve(response)
				},
				error:function(err){
					reject(err)
				}
			})
		})
	}

	function getRandomBetWeen(min, max) {
		return Math.random() * (max - min) + min;
	}
</script>
