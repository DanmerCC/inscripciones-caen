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
		"serverSide": true, //paginacion y filtrado realizados por el servidor
		"sEcho":"1",
        dom: 'Bfrtip', //definimos los elementos del contro la tabla,
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdf'
        ],
        "fnInitComplete": function(){
            // Disable TBODY scoll bars
            $('.dataTables_scrollBody').css({
                'overflow': 'hidden',
                'border': '0'
            });
            
            // Enable TFOOT scoll bars
            $('.dataTables_scrollFoot').css('overflow', 'auto');
            
            $('.dataTables_scrollHead').css('overflow', 'auto');
            
            // Sync TFOOT scrolling with TBODY
            $('.dataTables_scrollFoot').on('scroll', function () {
                $('.dataTables_scrollBody').scrollLeft($(this).scrollLeft());
            });      
            
            $('.dataTables_scrollHead').on('scroll', function () {
                $('.dataTables_scrollBody').scrollLeft($(this).scrollLeft());
            });
        },
        "ajax":
                {
                    url: '/admin/dataTable/inscritos',
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



function setPdfData(data){
    $("#mdl_pdf_view #pdf-container").prop('src',data);
}
