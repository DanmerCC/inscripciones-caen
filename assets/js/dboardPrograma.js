var tabla2;
$("#btn-salir").prop('href','/administracion/salir');
$(document).ready(function(){

    ajaxCPws();
    cargarDtProgramas();

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
                tabla2.ajax.reload();
                bootbox.alert(msg);
                $('#form_programa').modal('hide');
                tabla2.ajax.reload();
            }
        })
        .fail(function() {
            console.log("error");
        })
        
    });

     $('#formNuevoPro').on('click',function(){

        if (typeof $("#formNewPrograma") !== 'undefined') {
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
                                console.log("success insertar");
                            })
                            .fail(function() {
                                console.log("error insertar");
                            })
                            .always(function() {
                                console.log("complete insertar");
                            });
                            
                        });


                        /*Terminamos de inicializar el modal*/

                    });
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
    });



});


function cargarDtProgramas(){
    tabla2 = $('#dataTable2').dataTable({
        "aProcessing": true, //activamos el procesamiento del datatables
        "aServerSide": true, //paginacion y filtrado realizados por el servidor 
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
        "order": [[0, "desc"]] //ordenar(columna, orden)
    }).DataTable();
}



function activarPrograma(valor){
    bootbox.confirm("Esta seguro que desea hacer visible el Programa?", function (result) {
        if (result) {
            $.post('/administracion/programa/activar', {id_curso: valor}, function (e) {
                bootbox.alert(e);
                tabla.ajax.reload();
                console.log(e);
                console.log(result);
                tabla2.ajax.reload();
            });
        }
    })
    
}

function desactivarPrograma(valor){
    bootbox.confirm("Esta seguro que desea hacer no visible el Programa?", function (result) {
        if (result) {
            $.post('/administracion/programa/desactivar', {id_curso: valor}, function (e) {
                bootbox.alert(e);
                tabla.ajax.reload();
                console.log(e);
                console.log(result);
                tabla2.ajax.reload();
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

        console.log("success");
    })
    .fail(function() {
        console.log("error");
    })
    .always(function() {
        console.log("complete");
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
