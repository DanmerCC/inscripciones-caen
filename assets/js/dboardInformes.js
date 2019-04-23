var tabla;
$("#btn-salir").prop('href','/administracion/salir');
$(document).ready(function(){

    //contruirTitulos(dataTables.solicitudes.thead);
    cargarDataTable();
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
                    url: '/admin/dataTable/informes',
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

function marcarInfo(valor){
    bootbox.confirm("Desea marcar como  Atendido?", function (result) {
        if (result) {
            $.post('/admin/informes/marcarInfo', {id: valor}, function (e) {
                bootbox.alert(e);
                tabla.ajax.reload(null,false);
                console.log(e);
                console.log(result);
            });
        }
    })
    
}

function quitarmarcaInfo(valor){
    bootbox.confirm("Esta seguro desea marcar como no atendido?", function (result) {
        if (result) {
            $.post('/admin/informes/quitarMarcaInfo', {id: valor}, function (e) {
                bootbox.alert(e);
                tabla.ajax.reload(null,false);
                console.log(e);
                console.log(result);
            });
        }
    })
    
}


