var tabla;
$("#btn-salir").prop('href','/administracion/salir');
$(document).ready(function(){
    $("#btn-salir").prop('href','/administracion/salir');
    //contruirTitulos(dataTables.solicitudes.thead);
    cargarDataTable();
    configurarFormAsistencia();
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
                        url: '/casede/datatable/listar',
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
    
    
    function marcaruno(id){
        var result;
        bootbox.confirm("Desea marcar como asistente?", function(scope){
            if(scope){
                $.ajax({
                	type: "post",
                	url: "/casede/marcaAsistenciaq",
                	data: {"inscrito":id},
                	dataType: "text",
                	success: function (response) {
                		console.log(response);
                		tabla.ajax.reload();
                		if(response=='1'){
                		   alert("Marcado correctamente");
                		}
                	},
                	error: function (xhr, ajaxOptions, thrownError) {
                        alert(xhr.status);
                        alert(thrownError);
                    }
                });
            }
            
        });
    }
    
        function marcardos(id){
        var result;
        bootbox.confirm("Desea marcar como asistente?", function(scope){
            if(scope){
                $.ajax({
                	type: "post",
                	url: "/casede/marcaAsistenciad",
                	data: {"inscrito":id},
                	dataType: "text",
                	success: function (response) {
                		console.log(response);
                		tabla.ajax.reload();
                		if(response=='1'){
                		   alert("Marcado correctamente");
                		}
                	},
                	error: function (xhr, ajaxOptions, thrownError) {
                        alert(xhr.status);
                        alert(thrownError);
                    }
                });
            }
            
        });
    }
    
    function configurarFormAsistencia(){
        $("#modal-registro-casede").submit(function(event){
            event.preventDefault();
            var nombres_ap=$("#formRegistroCasede #nombres_ap").val();
            var dni=$("#formRegistroCasede #dni").val();
            var edad=$("#formRegistroCasede #edad").val();
            var email=$("#formRegistroCasede #email").val();
            var centro_laboral=$("#formRegistroCasede #centro_laboral").val();
            var profesion=$("#formRegistroCasede #profesion").val();
            var celular=$("#formRegistroCasede #celular").val();
            var grado_academico=$("#formRegistroCasede #grado_academico").val();
            var consulta=$("#formRegistroCasede #consulta").val();
                $.ajax({
                	type: "post",
                	url: "/casede/registro/asistencia",
                	data: {
        	                "nombres_apellidos":nombres_ap,
                            "dni":dni,
                            "edad":edad,
                            "email":email,
                            "centro_trabajo":centro_laboral,
                            "profesion":profesion,
                            "telefono":celular,
                            "grado_academico":grado_academico,
                            "consulta":consulta
                	    
                	},
                	success: function (response) {
                		console.log(response);
                		tabla.ajax.reload();
                		if(response=='1'){
                		   alert("Registrado correctamente");
                		}
                	},
                	error: function (xhr, ajaxOptions, thrownError) {
                        alert(xhr.status);
                        alert(thrownError);
                    }
                });
        });
    }
    
    