// variablesGlobales
var tablamatriculas;
$("#btn-salir").prop('href','/administracion/salir');
$(document).ready(function(){

	/*carga automatica*/
	cargarDataTable();
    cargar2DataTable();

    ajaxCPws();

	// fin de carga
});

// declaracion de funciones

function cargarDataTable(){
	    tablamatriculas = $('#dataTable1').dataTable({
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
                    url: '/admin/dataTable/matricula',
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

function cargar2DataTable(){
        tablamatriculas = $('#tblInscritos').dataTable({
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
                    url: '/admin/dataTable/solicitudaceptada',
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
function mostrarForm(){
    
}


function nuevaMatricula(id){
    $("#form_matricula").modal('show');
    $.ajax({
        url: '/admin/solicitud/'+id,
        type: 'post',
        dataType: "json",
        data: {val:'default'},
        success: function(msg){
            var data =msg[0];
            console.log(msg);
            $("#id_alumno").val(data.alumno);
            $("#nombre").val(data.nombres+" "+data.apellido_paterno+" "+data.apellido_materno);
            $("#id_programa").val(data.programa);
            $("#nombre_programa").val(data.nombreCurso);
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

function limpiarModalMatricula(){
    $("#id_alumno").val("");
    $("#nombre").val("");
    $("#id_programa").val("");
    $("#nombre_programa").val("");
}