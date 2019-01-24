var tabla;
$("#btn-salir").prop('href','/administracion/salir');
$(document).ready(function(){

    //contruirTitulos(dataTables.solicitudes.thead);
    cargarDataTable();

    $('#solicitantes').on('click',function(){
        swtichTable('solicitantes');
    });

    $('#programas').on('click',function(){
        swtichTable('programas');
    });
    ajaxCPws();

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