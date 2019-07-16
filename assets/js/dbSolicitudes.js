var tabla;
$("#btn-salir").prop('href','/administracion/salir');
$(document).ready(function(){

    //Load inicial para listar programas
    loadDataToSelect();

    $("#selectProgram").change(function(){
        tabla.search($(this).val()).draw();
    });

    //contruirTitulos(dataTables.solicitudes.thead);
    cargarDataTable();
    ajaxCPws();
    $('#solicitantes').on('click',function(){
        swtichTable('solicitantes');
    });

    $('#programas').on('click',function(){
        swtichTable('programas');
    });

    $("#form_comment").submit(function(event){
        event.preventDefault();
        $.ajax({
            url: '/admin/comentario/guardar/'+$("#id_solicitud").val(),
            type: 'post',
            dataType: 'json',
            data: {commet: $("#commet").val()},
            success:function(msg){
                console.log(msg);
                $("#id_solicitud").val("");
                $("textarea#commet").val("");
                if (msg) {
                    bootbox.alert("Cambiado correctamente");
                }else{
                    bootbox.alert("Ocurrio un error durante la carga");
                }
                tabla.ajax.reload(null,false);
                $('#mdl_form_comment').modal('hide');
            }
        })
        .done(function() {
            console.log("success");
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });
        
    });
});
/*fin de carga automatica*/



function cargarDataTable(){
	    tabla = $('#dataTable1').dataTable({
        "aProcessing": true, //activamos el procesamiento del datatables
        "serverSide": true, //paginacion y filtrado realizados por el servidor 
        dom: 'Bfrtip', //definimos los elementos del contro la tabla
        "sEcho":"1",
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdf'
        ],
        "ajax":
                {
                    url: '/admin/dataTable/solicitud',
                    type: "post",
                    dataType: "json",
                    error: function (e) {
                        console.log(e.responseText);
                    }
                },
        "bDestroy": true,
        "iDisplayLength": 15, // paginacion
        "order": [[0, "desc"]] //ordenar(columna, orden)
    }).DataTable();
}


function marcar(valor){
    bootbox.confirm("Esta seguro de marcar la solicitud?", function (result) {
        if (result) {
            $.post('/admin/solicitud/marcar', {id: valor}, function (e) {
                bootbox.alert(e);
                tabla.ajax.reload(null,false);
                console.log(e);
                console.log(result);
            });
        }
    })
    
}

function quitarmarca(valor){
    bootbox.confirm("Esta seguro desea marcar como no atendido?", function (result) {
        if (result) {
            $.post('/admin/solicitud/quitarmarca', {id: valor}, function (e) {
                bootbox.alert(e);
                tabla.ajax.reload(null,false);
                console.log(e);
                console.log(result);
            });
        }
    })
    
}



//Marcas de pagos

function marcarPago(valor){
    bootbox.confirm("Esta seguro de marcar la solicitud?", function (result) {
        if (result) {
            $.post('/admin/solicitud/marcarPago', {id: valor}, function (e) {
                bootbox.alert(e);
                tabla.ajax.reload(null,false);
                console.log(e);
                console.log(result);
            });
        }
    })
    
}

function quitarmarcaPago(valor){
    bootbox.confirm("Esta seguro desea marcar como no atendido?", function (result) {
        if (result) {
            $.post('/admin/solicitud/quitarmarcaPago', {id: valor}, function (e) {
                bootbox.alert(e);
                tabla.ajax.reload(null,false);
                console.log(e);
                console.log(result);
            });
        }
    })
    
}
// cONFIGURACION DE ALTERNADO PARA DATATABLES

function swtichTable(tabla){
    $("table").parents('div.dataTables_wrapper').hide();
    switch(tabla) {
    case 'programas':
        $('#dataTable2').parents('div.dataTables_wrapper').first().show();
        break;
    case 'solicitantes':
        $('#dataTable1').parents('div.dataTables_wrapper').first().show();
        break;
    default:
        break;
    }

}

function editComent (id){
    $("#mdl_form_comment").modal('show');
    $.ajax({
        url: '/admin/comentario/'+id,
        type: 'post',
        dataType: 'json',
        data: {param1: 'value1'},
        success:function(msg){
            var data=msg[0];
            $("#id_solicitud").val(data.idSolicitud);
            $("#commet").val(data.comentario);
        }
    })
    .done(function() {
        console.log("success");
    })
    .fail(function() {
        console.log("error");
    })
    .always(function() {
        console.log("complete");
    });
    
}

function loadDataToSelect(){
    $.ajax({
        type: "get",
        url: "/api/programas/all",
        data: "",
        dataType: "json",
        success: function (response) {
            //console.log(response);
            $("#selectProgram").html(listProgramasActivos(response));
        }
    });
}

function listProgramasActivos(array){
    result="<option value='' disabled required selected>Seleciona una opcion</option>";
    for (var i = 0; i < array.length; i++) {
        result=result+"<option value='"+array[i].numeracion+" "+array[i].tipoNombre+" "+array[i].nombre+"'>"+array[i].numeracion+" "+array[i].tipoNombre+" "+array[i].nombre+"</option>";
    }
    return result;
}

var modalDataAlumno={
    target:"#mdl_datos_alumno",
    limpiar:eliminarContenido,
    loadData:cargarData,
    init:inicio

}

var modalMensaje={
	target:"#mdl_danger_msg",
	init:function(){
		var targered=this.target;
		$(this.targered).on('hide.bs.modal', function (event) {
			$(targered+' #msg-modal').val("");
		});
	}
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
		$(idquerytarget+' #mdl-email').html("");
	});
}

modalDataAlumno.init();

modalMensaje.init();

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
function cargarData(id){
    var idquerytarget=this.target;
    $.ajax({
        type: "get",
        url: "/secure/alumno/"+id,
        data: "",
        dataType: "json",
        success: function (response) {
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
                var upload_link="#";
				for (var i = 0; i < documentos.length; i++) {
                    var upload_link="/admin/upload/page/"+documentos[i].identifier+'/'+alumno.documento;
                    console.log(alumno.documento);
					htmlDocuments=htmlDocuments+makeTemplateIconsDocuments(documentos[i].name,documentos[i].stateUpload,documentos[i].identifier,documentos[i].fileName,upload_link,id);
					
				}
				//documents for solicitud
				var filesOfSol =alumno.solicitudFiles;
                var htmlfilesOfSol="";
				for (var ii = 0; ii < filesOfSol.length; ii++) {
                    var upload_link="/admin/upload/page/"+filesOfSol[ii].identifier+'/'+id;
					htmlfilesOfSol += makeTemplateIconsDocuments(filesOfSol[ii].name,filesOfSol[ii].stateUpload,filesOfSol[ii].identifier,filesOfSol[ii].fileName,upload_link,id);
					
				}
				$(idquerytarget+' #mdl-icons-filesOfSol').html(htmlfilesOfSol);
				$(idquerytarget+' #mdl-icons-documents').html(htmlDocuments);
            }
            
        }
    });
}

function makeTemplateIconsDocuments(nombre,estado,identifier,nameFile,urlUpload,id){

    var onclick= "";
    onclick=(estado)?"":" onclick='reiniciarModalAlumno("+id+",this);' link="+urlUpload+" ";

    template=''+
    ((estado)?"<a href='/admin/view/pdf/"+identifier+"/"+nameFile+"' target='_blank'>":"<div class='container' ></div>")+
    '<span class="'+((estado)?"label label-primary":"label label-danger")+'" '+onclick+' >'+
    nombre+
    '</span>'+
    ((estado)?'</a>':"");
    return template;
}

function cerrarModalAlumno(callback){
   
    if(callback !== 'undefined'){
        $("#mdl_datos_alumno").modal('hide').promise().then(callback);
    }else{
        $("#mdl_datos_alumno").modal('hide');
    }
}

function reiniciarModalAlumno(id,obj_dom){
    cerrarModalAlumno(function(){
        var win = window.open(obj_dom.getAttribute("link"), '_blank');
        var status = confirm("Desea volver a ver los datos?");
        //win.focus();
        if(status){
            modalDataAlumno.loadData(id); 
            $("#mdl_datos_alumno").modal('show');
        }
            
        
    });
}


function request_bootbox(id){
	bootbox.confirm({
		title: "Desea inscribir",
		message: "Esta seguro de enviar a INSCRITOS esta solicitud",
		buttons: {
			cancel: {
				label: '<i class="fa fa-times"></i> Cancelar'
			},
			confirm: {
				label: '<i class="fa fa-check"></i> Enviar'
			}
		},
		callback: function (result) {
            if(result){
                $.ajax({
                    type: "post",
                    url: "/admin/inscr/create",
                    dataType: "json",
                    data: {
                        "id_sol":id
                    },
                    success: function (response) {
                        console.log(response);
                        if(response.result){
                            tabla.ajax.reload(null,false);
                            alert("Completado correctamente");
                        }else{
							$("#mdl_danger_msg #msg-modal").html("Verifique el estado de la solicitud");
							$("#mdl_danger_msg").modal('show');
							setTimeout(function(){
								$("#mdl_danger_msg").modal('hide');
							},1000)
                            //alert("verifica que la solicitud esta procesada");
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        alert("No es posible inscribir ");
                        console.log("Error: "+xhr);
                      }
                });
            }
			
		}
	});
}


function inscription_call_back(result){

}
