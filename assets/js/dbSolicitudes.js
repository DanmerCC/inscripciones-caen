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
                cargarDataTable();
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
                tabla.ajax.reload();
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
                tabla.ajax.reload();
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
                tabla.ajax.reload();
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
                tabla.ajax.reload();
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
        url: "/api/programas",
        data: "",
        dataType: "json",
        success: function (response) {
            console.log(response);
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