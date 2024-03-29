var tabla2;
$("#btn-salir").prop('href','/administracion/salir');
$(document).ready(function(){

    ajaxCPws();
	cargarDtProgramas();
	$("div.toolbar").html(
							'<div class="row">'+
								'<div class="col-md-2">'+
									'<label for="slct-tipo">Visibilidad</label>'+
								'</div>'+
								'<div class="col-md-4">'+
									'<select id="slct-visibility" class="form-control">'+
										'<option value selected>'+'Todos'+'</option>'+
										'<option value="visible">'+'Visible'+'</option>'+
										'<option value="no visible">'+'No VIsible'+'</option>'+
									'</select>'+
								'</div>'+
							'</div>'+
							'<div class="row">'+
								'<div class="col-md-2">'+
									'<label for="slct-tipo">Tipo de programa</label>'+
								'</div>'+
								'<div class="col-md-4">'+
									'<select id="slct-tipo"  class="form-control">'+
										'<option value selected>'+'Todos'+'</option>'+
									'</select>'+
								'</div>'+
							'</div>'
							).promise().done(function(){
								$.ajax({
									type: "get",
									url: "/public/api/tipos",
									data: "",
									dataType: "json",
									success: function (response) {
										response.forEach(type=>{
											$("#slct-tipo").append('<option value='+type.idTipo_curso+'>'+type.nombre+'</option>');
										});
										
									}
								});
							});
	$("#slct-visibility").change(function(){
		tabla2.column(8).search($(this).val()).draw();
	});
	$("#slct-tipo").change(function(){
		tabla2.column(7).search($(this).val()).draw();
	});
    $.ajax({
        url: '/api/programas/tipos',
        type: 'post',
        data: {param1: '1'},
        success:function(msg){
            var data=JSON.parse(msg);
            for (var i in data) {
                var op=document.createElement('option');
                op.value=data[i].idTipo_curso;
                op.innerHTML=data[i].nombre;
                $("#idTipo_curso").append(op);
            }
        }
    })
    .fail(function() {
        console.log("error");
    })

	$('#form_programa').modal('hide');

    $('#formPro').on('submit',function(evt){
        evt.preventDefault();
        $.ajax({
            url: '/administracion/programa/actualizar',
            type: 'post',
            dataType:'text',
            data: {
                id_curso:$('#id_curso').val(),
                nombre:$('#nombre').val(),
                numeracion:$('#numeracion').val(),
                duracion:$('#duracion').val(),
                costo:$('#costo').val(),
                vacantes:$('#vacantes').val(),
                fecha_inicio:$('#fecha_inicio').val(),
                fecha_final:$('#fecha_final').val(),
                idTipo_curso:$('#idTipo_curso').val()
            },
            success:function(msg){
                limpiar();
                //tabla2.ajax.reload();
                bootbox.alert(msg);
                $('#form_programa').modal('hide');
                tabla2.ajax.reload(null,false);
            }
        })
        .fail(function() {
            console.log("error");
        })
        
    });

     $('#formNuevoPro').on('click',function(){

        if ($("#formNewPrograma").length == 0) {
            $.ajax({
                url: '/admin/parts/nuevoprograma',
                type: 'post',
                dataType: 'text',
                data: {param1: 'value1'},
                success:function(msg){
                    $("#contentModals").append(msg).promise().done(function(){
                        /*Incializamos el modal*/
                        $('#newForm_programa').modal('show');
                        $("#formNewPrograma").on('submit',function(event) {
                            event.preventDefault();

                            /* Act on the event */
                            //var formData = new FormData($("#formNewPrograma")[0]);
                            $.ajax({
                                url: '/administracion/programa/insertar',
                                type: 'post',
                                data: {
                                    nnombre:$('#nnombre').val(),
                                    nnumeracion:$('#nnumeracion').val(),
                                    nduracion:$('#nduracion').val(),
                                    ncosto:$('#ncosto').val(),
                                    nvacantes:$('#nvacantes').val(),
                                    nfecha_inicio:$('#nfecha_inicio').val(),
                                    nfecha_final:$('#nfecha_final').val(),
                                    nidTipo_curso:$('#nidTipo_curso').val()
                                    },
                                success:function(msg){
                                    bootbox.alert(msg);

                                    $('#newForm_programa').modal('hide');
                                    $('#newForm_programa input').val('');
                                }
                            })
                            .done(function() {
                                //console.log("success insertar");
                            })
                            .fail(function() {
                                //console.log("error insertar");
                            })
                            .always(function() {
                                //console.log("complete insertar");
                            });
                            
                        });


                        /*Terminamos de inicializar el modal*/

                    });
                }

            })
            .done(function() {
                //console.log("success");
            })
            .fail(function() {
                console.log("error");
            })
            .always(function() {
                //console.log("complete");
            });
            
		}
	if ($("#newForm_programa").length == 1) {
		$("#newForm_programa").modal('show');
	}
    });



});


function cargarDtProgramas(){
    tabla2 = $('#dataTable2').dataTable({
        "Processing": true, //activamos el procesamiento del datatables
		"serverSide": true, //paginacion y filtrado realizados por el servidor
		"sEcho":"1",
		"createdRow": function ( row, data, index ) {
			if(data[5]>=getDate()){
				$(row).addClass('success');
			}else{
				$(row).addClass('warning');
			}
			/*if ( data[5].replace(/[\$,]/g, '') * 1 > 150000 ) {
				$('td', row).eq(5).addClass('danger');
			}*/
		},
        dom: 'Bfrtip', //definimos los elementos del contro la tabla
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdf'
        ],
        "ajax":
                {
                    url: '/admin/dataTable/programa',
                    type: "post",
                    dataType: "json",
                    error: function (e) {
                        console.log(e.responseText);
                    }
                },
        "bDestroy": true,
        "iDisplayLength": 15, // paginacion
		"order": [[0, "desc"]], //ordenar(columna, orden)
		"dom": '<"toolbar">frtip'
    }).DataTable();
}



function activarPrograma(valor){
    bootbox.confirm("Esta seguro que desea hacer visible el Programa?", function (result) {
        if (result) {
            $.post('/administracion/programa/activar', {id_curso: valor}, function (e) {
                bootbox.alert(e);
                tabla2.ajax.reload(null,false);
            });
        }
    })
    
}

function desactivarPrograma(valor){
    bootbox.confirm("Esta seguro que desea hacer no visible el Programa?", function (result) {
        if (result) {
            $.post('/administracion/programa/desactivar', {id_curso: valor}, function (e) {
                bootbox.alert(e);
                tabla2.ajax.reload(null,false);
            });
        }
    })
    
}

function mostrarFormPro(curso) {
    limpiar();
    $.ajax({
        url: '/administracion/programa/'+curso,
        type: 'post',
        dataType: 'text',
        data: {param1: 'value1'},
        success:function(msg){
            var data=JSON.parse(msg)[0];
            $("#idTipo_curso").val(data.idTipo_curso);
            $("#nombre").val(data.nombre);
            $("#numeracion").val(data.numeracion);
            $("#duracion").val(data.duracion);
            $("#costo").val(data.costo_total);
            $("#vacantes").val(data.vacantes);
            $("#fecha_inicio").val(data.fecha_inicio);
            $("#fecha_final").val(data.fecha_final);
            $("#id_curso").val(data.id_curso);
        }
    })
    .done(function() {

        //console.log("success");
    })
    .fail(function() {
        //console.log("error");
    })
    .always(function() {
        //console.log("complete");
    });
    
$('#form_programa').modal('show');
}


function limpiar() {
    $("#id_curso").val("");
    $("#nombre").val("");
    $("#numeracion").val("");
    $("#duracion").val("");
    $("#costo").val("");
    $("#vacantes").val("");
    $("#fecha_inicio").val("");
    $("#fecha_final").val("");
}

function getDate(){
	var today = new Date();
	var dd = String(today.getDate()).padStart(2, '0');
	var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
	var yyyy = today.getFullYear();

	today =  yyyy + '-' + mm + '-' + dd;
	return today;
}

function postergacion(id,obj){
    if(validarFormatoFecha($("#"+$(obj).data('inputinit')).val())&&validarFormatoFecha($("#"+$(obj).data('inputend')).val())){
        $.ajax({
            type: "post",
            url: "/administracion/programa/postergar",
            data: {
                "programa_id":id,
				"nueva_fecha":$("#"+$(obj).data('inputinit')).val(),
				"nueva_fecha_final":$("#"+$(obj).data('inputend')).val()
            },
            dataType: "json",
            success: function (response) {
                if(response){
                    bootbox.alert("Correctamente actualizado");
                }
                tabla2.ajax.reload(null,false);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });
    }else{
		if($("#"+$(obj).data('inputinit')).val()==""){
			show_error_msg("fecha de inicio incompleta");
		}
		else if($("#"+$(obj).data('inputend')).val()==""){
			show_error_msg("fecha de termino incompleta");
		}else{
			show_error_msg("Error al validar una fecha ");
		}
        
    }
    
}


function validarFormatoFecha(campo) {
    var RegExPattern = /^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/;
    if ((campo.match(RegExPattern)) && (campo!='')) {
          return true;
    } else {
          return false;
    }
}

function show_error_msg(msg,tiempo=null){
    $("#mdl_danger_msg #msg-modal").html(msg);
    $("#mdl_danger_msg").modal('show');
    if(tiempo!=null){
        setTimeout(function(){
            $("#mdl_danger_msg").modal('hide');
        },tiempo);
    }

}


function copy_clipboard(object){
	var copyText = $(object).data('url');
	console.log(copyText);

    var el = document.createElement('textarea');
    el.value = copyText;
    document.body.appendChild(el);
    el.select();
    document.execCommand('copy');
    document.body.removeChild(el);

	/* Alert the copied text */
	alert("Copied the text: " + copyText.value);
}