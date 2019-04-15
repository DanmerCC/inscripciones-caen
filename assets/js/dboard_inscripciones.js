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

	loadDataToSelect();

    $("#selectProgram").change(function(){
        tabla.search($(this).val()).draw();
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
        url: "/api/programas",
        data: "",
        dataType: "json",
        success: function (response) {
            console.log(response);
            $("#selectProgram").html(listProgramasActivos(response));
        }
    });
}

ins={
	"cancel":cancelarById
};

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
