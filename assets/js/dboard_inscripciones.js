var tabla;

function cargarDataTable(){
	tabla = $('#dataTable1').dataTable({
	"aProcessing": true, //activamos el procesamiento del datatables
	"serverSide": true, //paginacion y filtrado realizados por el servidor 
	dom: 'Bfrtip', //definimos los elementos del contro la tabla
	buttons: [
		'copyHtml5',
		'excelHtml5',
		'csvHtml5',
		'pdf'
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
		tabla.column(8).visible(false)
	},
	"bDestroy": true,
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
	"columnDefs": [ {
		"targets": 10,
		"render": function ( data, type, row, meta ) {
		  return getHtmlEstadoAdmision(data);
		}
	  } ]
}).DataTable();

$('a.toggle-vis').on( 'click', function (e) {
		e.preventDefault();

		// Get the column API object
		var column = tabla.column( $(this).attr('data-column') );

		// Toggle the visibility
		column.visible( ! column.visible() );
	} );
}

$(document).ready(function(){

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
		tabla.column(8).search(input_select.checked).draw();
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


});


function listProgramasActivos(array){
    result="<option value='' disabled required selected>Seleciona una opcion</option>";
    for (var i = 0; i < array.length; i++) {
        result=result+"<option value='"+array[i].numeracion+" "+array[i].tipoNombre+" "+array[i].nombre+"'>"+array[i].numeracion+" "+array[i].tipoNombre+" "+array[i].nombre+"</option>";
    }
    return result;
}


function loadDataToSelect(){
    $.ajax({
        type: "get",
        url: "/api/programas/allInscripciones",
        data: "",
        dataType: "json",
        success: function (response) {
            // console.log(response);
            $("#selectProgram").html(listProgramasActivos(response));
        }
    });
}

ins={
	"cancel":cancelarById,
	"change_estado":callBackchangeEstado
};

function callBackchangeEstado(id,estado_id,nombre){
	if(estado_id==3){
			bootbox.prompt({
			title:"Observacion",
			message: "Esta seguro de querer cambiar de estado a <strong>"+nombre+"</strong>?",
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
		message: "Esta seguro de querer cambiar de estado a <strong>"+nombre+"</strong>?",
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

	});

	/*
	bootbox.confirm({
	message: "Esta seguro de querer cambiar de estado a <strong>"+nombre+"</strong>?",
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
});*/
}

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
    ((estado)?"<a href='/admin/view/pdf/"+identifier+"/"+nameFile+"' target='_blank'>":"")+
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
}

function createRouteExport(){
	let search = tabla.ajax.params().search.value;
	let anulado = tabla.ajax.params().columns[8].search.value;
	let estados = tabla.ajax.params().columns[9].search.value;
	document.getElementById('btnExport').attributes.href.nodeValue = "/administracion/vista/dowloadFilter?search="+search+"&anulado="+anulado+"&estados="+estados;
}

function load_details_state_finanzas(id){
	MDL_DETALLE_FINANZAS.open(id)
}


function getFormHtmlAutorizacion(successHtmlMakeCallBack){
	let tipos;
	getTiposAuthorizaciones(function(data){
		 tipos=data;
		 var htmlTipos="";
		tipos.forEach(x=>{
			htmlTipos=htmlTipos+`<option value="${x.id}">${x.nombre}</option>`;	
		})
		successHtmlMakeCallBack( `
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

function getHtmlEstadoAdmision(estado){
	if(estado.id==1){
		return label_success(estado.nombre)
	}
	if(estado.id==2){
		return label_danger(estado.nombre)
	}
	
		return label(estado.nombre)
}
 
function label_success(text){
	return `<span class="label label-success">${text}</span>`; 
}
function label_danger(text){
	return `<span class="label label-success">${text}</span>`; 
}
function label(text){
	return `<span class="label">${text}</span>`; 
}
