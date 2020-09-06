/**
 * global vars
 * can_change_inscription_to_admision
 */

var tabla;
var CACHE_PROGRAMAS_SELECT = [];
var DEFAULT_NO_VISIBLE=[]
var DEFAULT_LENGTH = 15;

var STATE_ID_PENDIENTE_ADMISION  = 1 

/**
 * asign var from back if is correct
 */
if(typeof NO_COLUMN_VISIBLE_VAR_FROM_BACK != 'undefined'){

	if(!Array.isArray(NO_COLUMN_VISIBLE_VAR_FROM_BACK)){
		console.log("NO_COLUMN_VISIBLE_VAR_FROM_BACK no es un array valido")
	}else{
		DEFAULT_NO_VISIBLE = NO_COLUMN_VISIBLE_VAR_FROM_BACK
	}
		
}


var MDL_ACTA_ADMINDS =  {
	show(id){
		//$("#uniquedinamiccontainer").html(this.template(id))
		//$("#mdl_acta_visor_admision").modal('show')
		var _this  = this
		$.ajax({
			type: "GET",
			url: "/administracion/inscripcion/actas/"+id,
			data: "data",
			dataType: "json",
			success: function (response) {
				console.log(response)
				$("#uniquedinamiccontainer").html(_this.template(JSON.parse(response)))
				$("#mdl_acta_visor_admision").modal('show')
			}
		});
	},
	template(actas){
		var template = ``
		var _this = this
		console.log(actas)
		actas.forEach(acta => {
			template = template + _this.maximixableframe(acta)
		});
		return `
		<div class="modal fade" tabindex="-1" role="dialog" id="mdl_acta_visor_admision">
			<div class="modal-dialog modal-lg" style="display: block; padding-right: 17px;">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">Actas de inscripcion</h4>
					</div>
					<div class="modal-body">
						<div class="">
							<div class="">
								${template}
							</div>
						</div>
					</div>
					<div class="modal-footer">
						
						<button type="button" onclick="close()" class="btn btn-default"  data-dismiss="modal">Cerrar</button>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
		`
	},
	maximixableframe(acta){
		return `
		<div>
		  <div class="small-box bg-aqua" style="height:560px;">
		  	
			<div class="inner">
			<h4><a target="_blank" href='/administracion/acta/details/${acta.id}'>Ver</a>  info de acta</h4>
				<iframe src="/administracion/acta/view/${acta.id}" frameborder="0" width="100%" height="500px"></iframe>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
		  </div>
		</div>
		`
	}
}

function cargarDataTable(){
	tabla = $('#dataTable1').dataTable({
	"fnInitComplete": function(){
		// Enable THEAD scroll bars
		$('.dataTables_scrollHead').css('overflow', 'auto');

		// Sync THEAD scrolling with TBODY
		$('.dataTables_scrollHead').on('scroll', function () {
			$('.dataTables_scrollBody').scrollLeft($(this).scrollLeft());
		});
		var label  = document.createElement('label')
		label.innerHTML = "Codigo"
		var input = document.createElement('input')
		input.setAttribute('placeholder','Buscar por codigo')
		//input.setAttribute('class','form-control')
		input.addEventListener('input',(e)=>{
			tabla.column(8).search(e.target.value).draw()
		})
		label.appendChild(input)
		$('#dataTable1_filter').append(label)
	},
	deferRender: true,
    scrollY:     700,
    scroller:    false,
	"aProcessing": true, //activamos el procesamiento del datatables
	"serverSide": true, //paginacion y filtrado realizados por el servidor 
	dom: 'Bfrltip', //definimos los elementos del contro la tabla
	buttons: [
		'copyHtml5',
		'excelHtml5',
		'csvHtml5',
		'pdf',
		'selectAll',
		'selectNone'
	],
	"ajax":
			{
				url: '/admin/dataTable/inscripciones',
				type: "post",
				dataType: "json",
				data:{
					"asdasd":1
				},
				error: function (e) {
					console.log(e.responseText);
				}
			},
	"initComplete":function( settings, json){
		createRouteExport();
		for (let indexx = 0; indexx < DEFAULT_NO_VISIBLE.length; indexx++) {
			
			tabla.column(DEFAULT_NO_VISIBLE[indexx]).visible(false)

		}
	},
	"bDestroy": true,
	"bLengthChange":true,
	//"bLengthMenu": [ 10, 15,25, 50, 75, 100 ],
	//"aLengthMenu": [ 10, 15,25, 50, 75, 100 ],
	//"sLengthMenu": [ 10, 15,25, 50, 75, 100 ],
	"lengthMenu": [ 10, 15,25, 50, 75, 100 ],
	"iDisplayLength": 15, // paginacion
	"order": [[0, "desc"]],
	language: {
        "decimal": "",
        "emptyTable": "No hay información",
        "info": "Mostrando de _START_ a _END_ de _TOTAL_ Inscripciones",
        "infoEmpty": "Mostrando de 0 to 0 of 0 Inscripciones",
        "infoFiltered": "(Filtrado de _MAX_ total Inscripciones)",
        "infoPostFix": "",
        "thousands": ",",
        "lengthMenu": "Mostrar _MENU_ Inscripciones",
        "loadingRecords": "Cargando...",
        "processing": "Procesando...",
        "search": "Buscar:",
        "zeroRecords": "Sin resultados encontrados",
        "paginate": {
            "first": "Primero",
            "last": "Ultimo",
            "next": "Siguiente",
            "previous": "Anterior"
        }
	}, //ordenar(columna, orden)
	"columnDefs": [ 
		{
            orderable: false,
            className: 'select-checkbox',
			targets:   0,
			"render": function ( data, type, row, meta ) {
				return "";
			}
        },
		{
		"targets": 12,
		"render": function ( data, type, row, meta ) {
		  return getHtmlEstadoAdmision(data,row);
		}
	  },
	  
	  {
		"targets": 13,
		"render": function ( data, type, row, meta ) {
		  return getHtmlEstadoEntrevista(data);
		}
	  } ],
	  "select": {
		style:    'multi',
		selector: 'td:first-child'
	}
}).DataTable();

$('a.toggle-vis').on( 'click', function (e) {
		e.preventDefault();

		// Get the column API object
		var column = tabla.column( $(this).attr('data-column') );

		// Toggle the visibility
		column.visible( ! column.visible() );
		$(this).removeClass('btn-success')
		$(this).removeClass('btn-danger')
		$(this).addClass(column.visible()?'btn-success':'btn-danger')
	} );


}

$(document).ready(function(){

	MDL_ENTREVISTAS_INSCRIPCION.onsave=function(){
		tabla.ajax.reload(null,false);
	}

	console.log(MDL_ENTREVISTAS_INSCRIPCION.getIdInscriptions);

	$('#descprogramas[type="checkbox"]').click(function(){

		$current_val = $("#selectProgram").val()

		$("#selectProgram").html(listProgramasActivos(CACHE_PROGRAMAS_SELECT,$(this).prop("checked")==true))
		$("#selectProgram").val($current_val)
	});

	$('#select2-estado-admision').change((evt)=>{
		var select=$('#select2-estado-admision');
		//console.log(select.val());
		tabla.column(10).search(select.val()).draw();
		createRouteExport();
	})

	$('#select2-estado-finanzas').change((evt)=>{
		var select=$('#select2-estado-finanzas');
		//console.log(select.val());
		tabla.column(9).search(select.val()).draw();
		createRouteExport();
	})

	$("#slct_anulados").change(()=>{
		var input_select=document.getElementById('slct_anulados');
		//console.log(input_select.checked)
		tabla.column(11).search(input_select.checked).draw();
		createRouteExport();
		//tabla.ajax.reload(null,false);
	})

	loadDataToSelect();

    $("#selectProgram").change(function(){
        tabla.search($(this).val()).draw();
		createRouteExport();
    });

    //contruirTitulos(dataTables.solicitudes.thead);
	cargarDataTable();
	
	tabla.on( 'select', function ( e, dt, type, indexes ) {
		var rowsData = tabla.rows( '.selected' ).data().toArray()
		var rowData = tabla.rows( indexes ).data().toArray()
		var jsonData = tabla.rows( [0] ).data().toArray()
		
		rowData = rowData.length == 1 ? rowData[0]:null
		var rowsJsonData = rowsData.map(x=>JSON.parse(x[0]))

		var hasANotAdmitible = rowsJsonData.filter(x => {
			var number = Number.parseInt(x.estado_admisions_id)
			return x.estado_admisions_id != STATE_ID_PENDIENTE_ADMISION || number != STATE_ID_PENDIENTE_ADMISION
		}).length>0;

		
		console.log(rowsJsonData);
		var hasCodeInSelection = rowsJsonData.filter(x=>{return hasCodeStudent(x)}).length>0
		
		changeStateMultipleAdmidsButton(rowsJsonData.length>0 && !hasANotAdmitible)

		changeStateMultipleCodeCreateButton(!hasCodeInSelection)

		/*if(rowData[11].id != STATE_ID_PENDIENTE_ADMISION){
			alert("Solo puedes admitir inscritos como pendientes")
			dt.row().deselect()
		}*/
	} )
	.on( 'deselect', function ( e, dt, type, indexes ) {
		var rowsData = tabla.rows( '.selected' ).data().toArray()
		var rowData = tabla.rows( indexes ).data().toArray()
		var hasInvalids = rowsData.filter(hasNotValidateAdmisibleRow).length > 0 || rowsData.length == 0
		changeStateMultipleAdmidsButton(!hasInvalids)
		var rowsJsonData = rowsData.map(x=>JSON.parse(x[0]))
		var hasCodeInSelection = rowsJsonData.filter(x=>{return hasCodeStudent(x)}).length>0|| rowsData.length == 0
		changeStateMultipleCodeCreateButton(!hasCodeInSelection)
		
	} );

	MDL_MNG_STATE_ADMISION.getIdInscriptions = function(){
		return tabla.rows('.selected').data().toArray().map(x=>{
			
			var object = JSON.parse(x[0])
			
			return {
				id_curso:object.id_curso,
				inscripcion_id:object.id_inscripcion,
				alumno_id:object.alumno,
			}
		})
	}

	MDL_MNG_STATE_ADMISION.succesAdmids = function (response){
		tabla.ajax.reload(null,false);
	}

	MDL_MNG_CREATE_CODESTUDENT.succesAdmids= function (data){
		tabla.ajax.reload(null,false);
	}

});

function hasCodeStudent(jsonRow){
	return jsonRow.cod_student_admin!=null
}

function openModalAdmision(){
	MDL_MNG_STATE_ADMISION.create(tabla.rows('.selected').data().toArray())
}

function openModalCreaCodigos(){
	var jsonData = tabla.rows('.selected').data().toArray().map(x=>JSON.parse(x[0]))
	MDL_MNG_CREATE_CODESTUDENT.create(jsonData)
}

function hasNotValidateAdmisibleRow(inscripcion){
	
	return inscripcion[12].id != 1
}

function changeStateMultipleAdmidsButton(state = true){
	var button = $("#btn-admd-mult");
	if(state){
		button.unbind('click')
		button.removeAttr('disabled')
		button.removeAttr('onclick')
		button.click(openModalAdmision)
	}else{
		button.unbind('click')
		button.attr('disabled', 'true')
	}
}

function changeStateMultipleCodeCreateButton(state = true){
	var button = $("#btn-student-cod-mult");
	if(state){
		button.unbind('click')
		button.removeAttr('disabled')
		button.removeAttr('onclick')
		button.click(openModalCreaCodigos)
	}else{
		button.unbind('click')
		button.attr('disabled', 'true')
	}
}

function createCodigosModal(){

}

function loadDiscountAndRequirements(solicitud)
{
    $.ajax({
        type: "GET",
        url: "/postulante/misdescuentos/"+solicitud,
        data: {},
        dataType: "json",
        success: function (response) {
            if (response.status) {
                document.getElementById('discountsBodyAndRequirements').innerHTML = makeDiscountsHtml(response.data.programa);
            } else {
                document.getElementById('discountsBodyAndRequirements').innerHTML = '<span class="alert alert-danger"></span>';
            }
        },
        error: function (error){

        }
    });
}

function makeDiscountsHtml(parametros) {
    let discountsRows = '';
    parametros.discount.forEach(discount => {
        discountsRows += `<div class="form-group">
            <label for="">${discount.name}</label>
            <ul class="list-group">
                ${makeRequirementsHtml(parametros.requirements,discount.id)}
            </ul>
        </div>`;
    });
    return discountsRows;
}

function makeRequirementsHtml(requirements,discount_id)
{
    let requiremenstRows = '';
    requirements.forEach(requirement => {
        if(requirement.discount_id == discount_id){
            requiremenstRows += `<li class="list-group-item"><a href="/administracion/requirements/document/${requirement.file}" target="_blank" class="">${requirement.name}</a></li>`;
        }
    });

    return requiremenstRows;
}

function listProgramasActivos(array,lastfirst=false){
	
	result="";
	if(lastfirst){
		for (var i = 0; i < array.length; i++) {
			result="<option value='"+array[i].numeracion+" "+array[i].tipoNombre+" "+array[i].nombre+"'>"+array[i].numeracion+" "+array[i].tipoNombre+" "+array[i].nombre+"</option>"+result;
		}
	}else{
		for (var i = 0; i < array.length; i++) {
			result=result+"<option value='"+array[i].numeracion+" "+array[i].tipoNombre+" "+array[i].nombre+"'>"+array[i].numeracion+" "+array[i].tipoNombre+" "+array[i].nombre+"</option>";
		}
	}

	
    
    return "<option value='' disabled required selected>Seleciona una opcion</option>"+result;
}


function loadDataToSelect(lastfirst=false){
    $.ajax({
        type: "get",
        url: "/api/programas/allInscripciones",
        data: "",
        dataType: "json",
        success: function (response) {
            CACHE_PROGRAMAS_SELECT = response
            $("#selectProgram").html(listProgramasActivos(response,lastfirst));
        }
    });
}

ins={
	"cancel":cancelarById,
	"change_estado":callBackchangeEstado
};

function callBackchangeEstado(id,estado_id,nombre,descripcion){
	if(estado_id==3){
			bootbox.prompt({
			title:"Observacion <br>"+descripcion,
			message: "Esta seguro de querer cambiar de estado a <strong>"+nombre+"</strong> ?",
			buttons: {
				confirm: {
					label: 'Guardar',
					className: 'btn-success'
				},
				cancel: {
					label: 'Cancelar',
					className: 'btn-danger'
				}
			},
			callback: function (result) {
				
				if(result!=null){
					$.ajax({
						type: "post",
						url: "/admin/inscripcion/changestatefinan",
						data: {
							"id":id,
							"estado_id":estado_id,
							"comentario":result
						},
						dataType: "json",
						success: function (response) {
							console.log(response);
							if(response.content=="OK"){
								alert("Cambio correcto correctamente");
								tabla.ajax.reload(null,false);
							}
						},
						error: function (e) {
							console.log(e.responseText);
						}
					});
				}
			}
		});
	}

	if(estado_id!=3 && estado_id!=VARS.inscripcion_finanzas.estados.AUTORIZADO){
		bootbox.confirm({
		message: "Esta seguro de querer cambiar de estado a <strong>"+nombre+"</strong>?<br>"+descripcion,
		buttons: {
			confirm: {
				label: 'Si',
				className: 'btn-success'
			},
			cancel: {
				label: 'Cancelar',
				className: 'btn-danger'
			}
		},
		callback: function (result) {
			if(result){
				$.ajax({
					type: "post",
					url: "/admin/inscripcion/changestatefinan",
					data: {
						"id":id,
						"estado_id":estado_id
					},
					dataType: "json",
					success: function (response) {
						console.log(response);
						if(response.content=="OK"){
							alert("Cambio correcto correctamente");
							tabla.ajax.reload(null,false);
						}
					},
					error: function (e) {
						console.log(e.responseText);
					}
				});
			}
		}
	});
}
	
	if(estado_id==VARS.inscripcion_finanzas.estados.AUTORIZADO){
		
		getFormHtmlAutorizacion(htmlResult=>{
			bootbox.confirm(htmlResult, function(result) {
				if(result){
					var object_data={
						tipo_id:$('#frm-bootbox-autorization #txtarea-mdl-tipos').val(),
						comentario:$('#frm-bootbox-autorization #slct-mdl-tipos').val(),
					}
					console.log(object_data)
					$.ajax({
						type: "post",
						url: "/admin/inscripcion/changestatefinan",
						data: {
							"id":id,
							"estado_id":estado_id,
							tipo_id:$('#frm-bootbox-autorization #slct-mdl-tipos').val(),
							comentario:$('#frm-bootbox-autorization #txtarea-mdl-tipos').val()
						},
						dataType: "json",
						success: function (response) {
							if(response.content=="OK"){
								alert("Cambio correcto correctamente");
								tabla.ajax.reload(null,false);
							}
						},
						error: function (e) {
							console.log(e.responseText);
						}
					});
				}
		})

	},descripcion);
}

}

function loadBootbox(configObject){
	bootbox.prompt(configObject)
}

function cancelarById(id){

	bootbox.confirm({
		message: "Esta seguro de querer anular esta inscripcion?",
		buttons: {
			confirm: {
				label: 'Si',
				className: 'btn-success'
			},
			cancel: {
				label: 'Cancelar',
				className: 'btn-danger'
			}
		},
		callback: function (result) {
			if(result){
				$.ajax({
					type: "post",
					url: "/admin/inscr/cancel",
					data: {
						"id":id
					},
					dataType: "json",
					success: function (response) {
						console.log(response);
						if(response.content=="OK"){
							alert("Anulado correctamente");
							tabla.ajax.reload(null,false);
						}
					},
					error: function (e) {
						console.log(e.responseText);
					}
				});
			}
		}
	});
	
}

var modalDataInscrito={
    target:"#mdl_datos_inscritos",
    limpiar:eliminarContenido,
    loadData:cargarData,
    init:inicio
}

function inicio(){
    var idquerytarget=this.target;
	$(this.target).on('hide.bs.modal', function (event) {
		$(idquerytarget+' #mdl-foto').prop("src","");
        $(idquerytarget+' #mdl-name').html("");
        $(idquerytarget+' #mdl-name').html("");
        $(idquerytarget+' #mdl-profesion').html("");
        $(idquerytarget+' #mdl-solicitudes').html("");
        $(idquerytarget+' #mdl-educacion').html("");
        $(idquerytarget+' #mdl-celphone').html("");
        $(idquerytarget+' #mdl-icons-documents').html("");
	});
}

modalDataInscrito.init();

function eliminarContenido(){
    var idquerytarget=this.target;
    $(idquerytarget+' #mdl-foto').prop("src","");
    $(idquerytarget+' #mdl-name').html("");
    $(idquerytarget+' #mdl-name').html("");
    $(idquerytarget+' #mdl-profesion').html("");
    $(idquerytarget+' #mdl-solicitudes').html("");
    $(idquerytarget+' #mdl-educacion').html("");
    $(idquerytarget+' #mdl-celphone').html("");
	$(idquerytarget+' #mdl-icons-documents').html("");
	$(idquerytarget+' #mdl-email').html("");
}

function makeTemplateIconsDocuments(nombre,estado,identifier,nameFile){
    template=''+
    ((estado)?"<a href='/admin/view/pdf/"+identifier+"/"+nameFile+"' target='_blank'>":"<div class='container' ></div>")+
    '<span class="'+((estado)?"label label-primary":"label label-danger")+'">'+
    nombre+
    '</span>'+
    ((estado)?'</a>':"");
    return template;
}

function cargarData(id){
	
	var idquerytarget=this.target;
	//console.log(id);
    $.ajax({
        type: "get",
        url: "/secure/inscrito/"+id,
        data: "",
        dataType: "json",
        success: function (response) {
			//console.log(response);
            if(response.status=="NO FOUND"){
                alert("Ocurrio un error. El alumno no pudo ser encontrado");
            }else{
				alumno=response.result;
                $(idquerytarget+' #mdl-name').html(((alumno.nombres!=null)?alumno.nombres:'')+' '+((alumno.apellido_paterno!=null)?alumno.apellido_paterno:'')+' '+((alumno.apellido_materno!=null)?alumno.apellido_materno:''));
                $(idquerytarget+' #mdl-profesion').html(alumno.grado_profesion);
                $(idquerytarget+' #mdl-solicitudes').html(alumno.solicitudes);
                $(idquerytarget+' #mdl-educacion').html(alumno.grado_profesion);
                $(idquerytarget+' #mdl-celphone').html(' - '+alumno.celular+' - '+alumno.telefono_casa+' - ');
                $(idquerytarget+' #mdl-icons-documents').html(makeTemplateIconsDocuments(alumno.estado));
				$(idquerytarget+' #mdl-email').html(alumno.email);
				//fotoData
				$(idquerytarget+' #mdl-foto').prop("src",alumno.fotoData);
				var documentos=alumno.documentosObject;
				var htmlDocuments="";
				for (var i = 0; i < documentos.length; i++) {
					htmlDocuments=htmlDocuments+makeTemplateIconsDocuments(documentos[i].name,documentos[i].stateUpload,documentos[i].identifier,documentos[i].fileName);
					
				}

				//documents for solicitud
				var filesOfSol =alumno.solicitudFiles;
				var htmlfilesOfSol="";
				for (var ii = 0; ii < filesOfSol.length; ii++) {
					htmlfilesOfSol += makeTemplateIconsDocuments(filesOfSol[ii].name,filesOfSol[ii].stateUpload,filesOfSol[ii].identifier,filesOfSol[ii].fileName);
					
				}
				$(idquerytarget+' #mdl-icons-filesOfSol').html(htmlfilesOfSol);
				$(idquerytarget+' #mdl-icons-documents').html(htmlDocuments);
				$("#mdl_datos_inscritos").modal('show');
            }
            
		},
		error: function (e) {
			console.log(e.responseText);
		}
	});
	loadDiscountAndRequirements(id);
}

function createRouteExport(){
	let search = tabla.ajax.params().search.value;
	let anulado = tabla.ajax.params().columns[9].search.value;
	let estados = tabla.ajax.params().columns[10].search.value;
	document.getElementById('btnExport').attributes.href.nodeValue = "/administracion/vista/dowloadFilter?search="+search+"&anulado="+anulado+"&estados="+estados;
}

function load_details_state_finanzas(id){
	MDL_DETALLE_FINANZAS.open(id)
}


function getFormHtmlAutorizacion(successHtmlMakeCallBack,title){
	title=typeof title == 'undefined'?'':title;
	let tipos;
	getTiposAuthorizaciones(function(data){
		 tipos=data;
		 var htmlTipos="";
		tipos.forEach(x=>{
			htmlTipos=htmlTipos+`<option value="${x.id}">${x.nombre}</option>`;	
		})
		successHtmlMakeCallBack( `
				<h3>${title}</h3>
				<form id='frm-bootbox-autorization'>
					<div class='form-group'>
						<label>Tipo</label>
						<select name='slct-mdl-tipos' class='form-control' id="slct-mdl-tipos">
							${htmlTipos}
						</select>
					</div>
					<div class='form-group'>
						<label>Comentario</label>
						<textarea id='txtarea-mdl-tipos' rows="4" style="margin: 0px; width: 570px; height: 126px;" cols="60" name='textarea'/>
					</div>
				</form>
				`);
	})
	
	
}

function getTiposAuthorizaciones(successCallBakc){
	$.ajax({
		type: "get",
		url: "/admin/tipoAutorizaciones",
		data: "",
		dataType: "json",
		success: successCallBakc
	});
}

function getHtmlEstadoAdmision(estado,inscripcion){

	if(can_change_inscription_to_admision){
		if(estado.id==1){

			return label_default(estado.nombre)
		}
		if(estado.id==2){
			console.log(inscripcion)
			var id_inscripcion = JSON.parse(inscripcion[0]).id_inscripcion
			var fulltemplate = `
				<div onclick="MDL_ACTA_ADMINDS.show(${id_inscripcion})">
					${label_success(estado.nombre,'<i class="fa fa-file-pdf-o" aria-hidden="true"></i>')}
				</div>
			`
			return fulltemplate
		}
	}else{
		return dropDownAdmision(estado,inscripcion)
	}
	
	
		return label(estado.nombre)
}

function getHtmlEstadoEntrevista(estado){

	
	if(estado==null){
		return label_danger("No registrado")
	}else{
		if(estado.id=="1"){
			return label_danger(estado.nombre)
		}
		if(estado.id=="2"){
			return label_success(estado.nombre)
		}
	}
	
	
		return 'ERROR'
}

function dropDownAdmision(admision_state){
	return `
	<div class="input-group-btn">
		<button type="button" class="  btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
			sin revision
			<span class="fa fa-caret-down"></span>
		</button>
		<ul class="dropdown-menu">
		<li onclick="sol.change_estado(1410,1,&quot;sin revision&quot;)"><a class="" href="#">${JSON.stringify(admision_state)}sin revision</a></li>
		<li onclick="sol.change_estado(1410,2,&quot;validado&quot;)"><a class=" text-green " href="#">validado</a></li>
		<li onclick="sol.change_estado(1410,3,&quot;observado&quot;)"><a class=" text-red " href="#">observado</a></li>
		</ul>
		<a class="btn btn-social-icon btn-instagram" disabled="" onclick=""><i class="fa fa-fw fa-info-circle"></i></a>	  
	 </div>
	`
}
 
function label_success(text,inject=''){
	return `<span class="label label-success">${inject} ${text}</span>`; 
}
function label_danger(text){
	return `<span class="label label-danger">${text}</span>`; 
}

function label_info(text){
	return `<span class="label label-info">${text}</span>`; 
}
function label_default(text){
	return `<span class="label label-default">${text}</span>`; 
}
function label(text){
	return `<span class="label">${text}</span>`; 
}
