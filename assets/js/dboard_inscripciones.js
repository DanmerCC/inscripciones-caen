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
				error: function (e) {
					console.log(e.responseText);
				}
			},
	"bDestroy": true,
	"iDisplayLength": 15, // paginacion
	"order": [[0, "desc"]] //ordenar(columna, orden)
}).DataTable();
}

$(document).ready(function(){

    //contruirTitulos(dataTables.solicitudes.thead);
    cargarDataTable();


});
