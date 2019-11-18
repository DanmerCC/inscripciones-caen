var tabla;

$(document).ready(function(){
	cargarDataTable()
	loadDataToSelect()
	searchByProgramaEvent()
	$("#input-evaluables").autocomplete({
		source: '/admin/evaluables',
		minLength: 1,
		open: function(){
			$("#input-evaluables").data('id',null)
			$(this).autocomplete('widget').css('z-index', 100);
			return false;
		},
		select: function (event, ui) {
			console.log(ui.item.nombres)
			$("#input-evaluables").val(ui.item.nombres)
			$("#input-evaluables").data('id',ui.item.id_inscripcion)
		},
	}).data("ui-autocomplete")._renderItem = function (ul, item) {
		return $("<li class='item-suggestions'></li>")
			.data("item.autocomplete", item)
			.append(`
				<option value="${item.id_inscripcion}">${item.nombres} ${item.apellido_paterno} ${item.apellido_materno} - ${item.full_name_programa}</option>
			`)
			.appendTo(ul);
	};
})

function searchByProgramaEvent(){
	$("#selectProgram").change(function(){
		tabla.column(3).search($("#selectProgram").val()).draw();
	});
}

function listProgramasActivos(array){
    result="<option value='' disabled required selected>Seleciona una opcion</option>";
    for (var i = 0; i < array.length; i++) {
        result=result+"<option value='"+array[i].id_curso+"'>"+array[i].numeracion+" "+array[i].tipoNombre+" "+array[i].nombre+"</option>";
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
				url: '/admin/dataTable/evaluaciones',
				type: "post",
				dataType: "json",
				data:{},
				error: function (e) {
					console.log(e.responseText);
				}
			},
	"initComplete":function( settings, json){
		//createRouteExport();
		//tabla.column(8).visible(false)
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
	"columnDefs": [{
		"targets": 2,
		"render": function ( data, type, row, meta ) {
			console.log(data)
		  return ` ${data.nombres} ${data.apellidos}`;
		}
	  }]
}).DataTable();
}


function guardarEntrevista(){
	var data = new FormData();
	let fileInput=$('#fl-evaluacion')[0].files;
	if(fileInput.length==1){
		data.append('file_evaluacion',fileInput[0]);
		let id_inscripcion=$("#input-evaluables").data('id');
		data.append('id_inscripcion',id_inscripcion);
		$.ajax({
			type: "post",
			url: "/admin/evaluacion/save",
            processData: false,
            contentType: false,
			data: data,
			enctype: 'multipart/form-data',
			success: function (response) {
				console.log(response)
			}
		});
	}else{
		alert("Solo se permite un archivo")
	}
	
}


