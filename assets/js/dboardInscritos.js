var tabla;
var ALUMNO_SELECTED = []
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
	
	tabla.on( 'select', function ( e, dt, type, indexes ) {
		var rowsData = tabla.rows( '.selected' ).data().toArray()
		var jsonData  = rowsData.map(x=>JSON.parse(x[0])) 
		ALUMNO_SELECTED = jsonData
		validateCodeAlumnoButton(rowsData)
	} ).on( 'deselect', function ( e, dt, type, indexes ) {
		var rowsData = tabla.rows( '.selected' ).data().toArray()
		var jsonData  = rowsData.map(x=>JSON.parse(x[0])) 
		ALUMNO_SELECTED = jsonData
		validateCodeAlumnoButton(rowsData)
	} );



	

});
/*fin de carga automatica*/

function validateCodeAlumnoButton(rowsData){
	var jsonData  = rowsData.map(x=>JSON.parse(x[0])) 
	var $btnCodeAlumno = $("#id-btn-codigo-unique")
	console.log(jsonData.filter(x => x.cod_alumno_increment))
	var hasCods  = jsonData.filter(x => x.cod_alumno_increment != null)
	changeStateCodeStudent(hasCods.length == 0)
}

function changeStateCodeStudent(state){
	var button = $("#id-btn-codigo-unique");
	if(state){
		button.unbind('click')
		button.removeAttr('disabled')
		button.removeAttr('onclick')
		button.click(openModalChargeCodigos)
	}else{
		button.unbind('click')
		button.attr('disabled', 'true')
	}
}

function openModalChargeCodigos(){
	var ids_concats = ALUMNO_SELECTED.map(x=>x.id_alumno).join(',')
	console.log(ids_concats)
	console.log("este es o son los ids");
	$.ajax({
		type: "post",
		url: "/admin/codestudent",
		data: {
			ids:ids_concats
		},
		dataType: "json",
		success: function (response) {
			console.log(response);
			if(response.status){
				alert(response.message)
			}else{
				alert(response.message)
			}
			tabla.ajax.reload(null,false)
		},
		error(code){
			if(code.status == 401){
				alert("No tienes permiso para crear codigos ")
			}
			
		}
		
	});
	
}

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
			'pdf',
			{
				text: 'Codigo unico',
				class:'createcodebtn',
                action: function ( e, dt, node, config ) {
					node
					console.log(e,dt,node,config);
                    alert( 'Button activated' );
                }
            }
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
			
			$('#dataTable1 thead th').each( function () {
				var title = $(this).text();
				$(this).html( '<input type="text" class="form-control" placeholder="Search '+title+'" />' );
			} );
			this.api().columns().every( function () {
                var that = this;
 
                $( 'input', this.footer() ).on( 'keyup change clear', function () {
                    if ( that.search() !== this.value ) {
                        that
                            .search( this.value )
                            .draw();
                    }
                } );
			} );
			
			 $('#dataTable1 thead th').each( function () {
				var title = $(this).text();
				$(this).html( '<input type="text" placeholder="Search '+title+'" />' );
			} );
        },
        "scrollX": true,
        "scrollCollapse": true,
        
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
		"order": [[0, "desc"]], //ordenar(columna, orden)
		"select": {
			style:    'multi',
			selector: 'td:first-child'
		},
		"columnDefs": [ 
				{
				orderable: false,
				className: 'select-checkbox',
				targets:   0,
				"render": function ( data, type, row, meta ) {
					return "";
				}
			}
		]
    }).DataTable();
}



function setPdfData(data){
    $("#mdl_pdf_view #pdf-container").prop('src',data);
}
