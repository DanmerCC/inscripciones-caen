var tabla;
var actionMethod;
var campos_global = [ 'name', 'description', 'percentage' ];

//$("#"+nameId).parent('.input-group').next('span').text('Este campo es requerido.')
$('input.validar').change(function(){
    $(this).parent('.input-group').next('span').text('')
    $(this).parent('.input-group').parent().parent().removeClass('has-error')
});

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
                url: '/admin/dataTable/cursosdiscount',
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

function verRequisitos(discount_id){
    $.ajax({
        type: "GET",
        url: "/administracion/requirements/discount/"+discount_id,
        data: {},
        dataType: "json",
        success: function (response) {
            if(response.status == 'OK'){
                document.getElementById("cuerpoTableRequirements").innerHTML = makeTemplateTable(response.data)
                $("#viewRequirementModal").modal("show");
            }else{
                alert("Ocurrio un error al traer datos");
            }
        }
    });
}

function makeTemplateTable(data)
{
    let template = '';
    if(data.length>0){
        data.forEach((element,i) => {
            template +=`<tr>
                <td>${i+1}</td>
                <td>${element.name}</td>
                <td>
                    <button class="btn btn-danger btn-sm" 
                    onclick="quitarPrograma(${element.id})">Quitar</button>
                </td>
            </tr>`;
        });
    }else{
        template +=`<tr>
            <td colspan="3">No se entronto datos</td>
        </tr>`;
    }
    return template;
}

function quitarPrograma(id)
{
    alert("Quitado de la lista");
}

function agregarNuevoBeneficioPrograma(){
    reloadForm();
    actionMethod = 'add';
	$("#form_discount .modal-title").text("Agregar nuevo beneficio");
	$("#form_discount").modal("show");
}

function mostrarFormPro(id){
    reloadForm();
    actionMethod = 'update';
    $.ajax({
        type: "GET",
        url: "/administracion/cursosdiscount/edit/"+id,
        data: {},
        dataType: "json",
        success: function (response) {
            if(response.status=='OK'){
                loadDataForm(response.data);
            }else{
                alert(response.data.message)
            }
        }
    });
    $("#discount_id").val(id);
	$("#form_discount .modal-title").text("Modificar beneficio");
	$("#form_discount").modal("show");
}

function loadDataForm(model_data){
    $.each(campos_global, function (indexInArray, valueOfElement) {
        document.getElementById(valueOfElement).value = model_data[valueOfElement];
    });
}

function eliminar(id) {
    bootbox.confirm("Estas seguro de eliminar esta relación?", function (result) {
        if (result) {
            $.ajax({
                type: "POST",
                url: "/administracion/cursosdiscount/delete",
                data: {
                    id:id
                },
                dataType: "json",
                success: function (response) {
                    if (response.status=='OK') {
                        alert("Se elimino con éxito")
                        realoadDatatable();
                    }else{
                        alert(response.data.message)
                    }
                }
            });
        }
    })
}

function save(){

    saving();

    let url = '';
    if(actionMethod=='add'){
        url = '/administracion/cursosdiscount/save';
    }else{
        url = '/administracion/cursosdiscount/update';
    }
    if(validFormData()){
        $.ajax({
            type: "POST",
            url: url,
            data: $('#formularioregistros').serialize(),
            dataType: "json",
            processData: true,
            success: function (response) {
                if(response.status=='OK'){
                    realoadDatatable()
                    $("#form_discount").modal("hide");
                }else{
                    alert(response.data.message)
                }
            },
            complete: finishSaving()
        });
    }else{
        finishSaving()
    }
    
}

function reloadForm(){
    $('#formularioregistros')[0].reset();

    $(".help-block").each(function (index, element) {
        element.textContent='';
    });
    $(".has-error").each(function (index, element) {
        $(element).removeClass('has-error');
    });
}

function saving(){
    $("#btnActualizarPr").attr('disabled','disabled');
    $("#btnActualizarPr").text('Guardando...');
}

function finishSaving(){
    $("#btnActualizarPr").removeAttr('disabled');
    $("#btnActualizarPr").text('Guardar');
}

function validFormData(){
    let status = true;
    campos_global.forEach(element => {
        let value = document.getElementById(element).value;
        if(value==''){
            status=false;
        }
        processError(element,value);
    });
    return status;
}

function processError(nameId,value){
    if(value==''){
        $("#"+nameId).parent('.input-group').next('span').text('Este campo es requerido.')
        $("#"+nameId).parent('.input-group').parent().parent().addClass('has-error')
    }
}

function realoadDatatable(){
    tabla.ajax.reload(false,null);
}
