var tabla;
var actionMethod;
var campos_global = [ 'name', 'description', 'percentage' ];
var selectedDiscountId; 
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
                url: '/admin/dataTable/discounts',
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

function agregarNuevoBeneficio(){
    reloadForm();
    actionMethod = 'add';
	$("#form_discount .modal-title").text("Agregar nuevo beneficio");
	$("#form_discount").modal("show");
}

function verProgramas(discount_id,text = ''){

    selectedDiscountId = discount_id;
    document.getElementById('nombreBeneficiop').textContent = text;
    recargarTodoProgramas(discount_id);
    $("#viewDiscountModal").modal("show");
}

function recargarTodoProgramas(discount_id)
{
    $.ajax({
        type: "GET",
        url: "/administracion/programa/discountrestante/"+discount_id,
        data: {},
        dataType: "json",
        success: function (response) {
            if(response.status == 'OK'){
                document.getElementById("cuerpoTablePrograma").innerHTML = makeTemplateTablePrograma(response.data.programas,discount_id)
                document.getElementById("programa_id").innerHTML = makeTemplateSelectPrograma(response.data.new_programas);
            }else{
                alert("Ocurrio un error al traer datos");
            }
        }
    });
}

function makeTemplateTablePrograma(data,discount_id)
{
    let template = '';
    if(data.length>0){
        data.forEach((element,i) => {
            template +=`<tr>
                <td>${i+1}</td>
                <td>${element.numeracion} ${element.tipo.nombre} ${element.nombre}</td>
                <td>
                    <button class="btn btn-danger btn-sm" 
                    onclick="quitarPrograma(${element.id_curso},${discount_id})">Quitar</button>
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

function makeTemplateSelectPrograma(data)
{
    let template = '<option value="">Seleccionar:</option>';
    if(data.length>0){
        data.forEach((element,i) => {
            template +=`<option value="${element.id_curso}">${element.numeracion} ${element.tipo.nombre} ${element.nombre}</option>`;
        });
    }else{
    }
    
    return template;
}

function quitarPrograma(id,discount_id)
{
    bootbox.confirm("Estas seguro de quitar el programa?", function (result) {
        if (result) {
            $.ajax({
                type: "POST",
                url: "/administracion/cursosdiscount/delete",
                data: {
                    programa_id:id,
                    discount_id:discount_id
                },
                dataType: "json",
                success: function (response) {
                    if (response.status=='OK') {
                        alert("Se elimino con éxito")
                        recargarTodoProgramas(discount_id)
                    }else{
                        alert(response.data.message)
                    }
                }
            });
        }
    })
}

function addNewPrograma()
{
    let programa_id = document.getElementById('programa_id').value;
    if (programa_id!='') {
        $.ajax({
            type: "POST",
            url: "/administracion/cursosdiscount/save",
            data: {
                discount_id:selectedDiscountId,
                programa_id:programa_id
            },
            dataType: "JSON",
            success: function (response) {
                if(response.status == 'OK'){
                    recargarTodoProgramas(selectedDiscountId);
                }else{
                    alert("Error al guardar datos");
                }
            }
        });
    }else{
        alert("Por favor elejir un requerimiento")
    }
}

function agregarRequisitos(discount_id,text='')
{
    selectedDiscountId = discount_id;
    document.getElementById('nombreBeneficio').textContent = text;
    recargarTodoRequirements(discount_id);
    $("#viewDiscountRequirementModal").modal("show");
}

function makeTemplateTableRequirements(requirements,discount_id)
{
    let template = '';
    if(requirements.length>0){
        requirements.forEach((element,i) => {
            template +=`<tr>
                <td>${i+1}</td>
                <td>${element.name}</td>
                <td>
                    <button class="btn btn-danger btn-sm" 
                    onclick="quitarRequirement(${element.id},${discount_id})">Quitar</button>
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

function makeTemplateSelectRequirement(data)
{
    let template = '<option value="">Seleccionar:</option>';
    if(data.length>0){
        data.forEach((element,i) => {
            template +=`<option value="${element.id}">${element.name}</option>`;
        });
    }else{
    }
    
    return template;
}

function quitarRequirement(id,discount_id)
{
    bootbox.confirm("Estas seguro de quitar el requerimiento?", function (result) {
        if (result) {
            $.ajax({
                type: "POST",
                url: "/administracion/discountrequirement/delete",
                data: {
                    requirement_id:id,
                    discount_id:discount_id
                },
                dataType: "json",
                success: function (response) {
                    if (response.status=='OK') {
                        alert("Se elimino con éxito")
                        recargarTodoRequirements(discount_id)
                    }else{
                        alert(response.data.message)
                    }
                }
            });
        }
    })
}

function recargarTodoRequirements(discount_id)
{
    $.ajax({
        type: "GET",
        url: "/administracion/requirements/discountrestante/"+discount_id,
        data: "",
        dataType: "json",
        success: function (response) {
            if(response.status == 'OK'){
                document.getElementById("cuerpoTableRequisitos").innerHTML = makeTemplateTableRequirements(response.data.requirement,discount_id)
                document.getElementById("requirement_id").innerHTML = makeTemplateSelectRequirement(response.data.new_requirement);
                
            }else{
                alert("Ocurrio un error al traer datos");
            }
        }
    });
}

function addNewRequirement()
{
    let requirement_id = document.getElementById('requirement_id').value;
    if (requirement_id!='') {
        $.ajax({
            type: "POST",
            url: "/administracion/discountrequirement/save",
            data: {
                discount_id:selectedDiscountId,
                requirement_id:requirement_id
            },
            dataType: "JSON",
            success: function (response) {
                if(response.status == 'OK'){
                    recargarTodoRequirements(selectedDiscountId)
                }else{
                    alert("Error al guardar datos");
                }
            }
        });
    }else{
        alert("Por favor elejir un requerimiento")
    }
}

function mostrarFormPro(id){
    reloadForm();
    actionMethod = 'update';
    $.ajax({
        type: "GET",
        url: "/administracion/discounts/edit/"+id,
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
    bootbox.confirm("Estas seguro de eliminar este beneficio?", function (result) {
        if (result) {
            $.ajax({
                type: "POST",
                url: "/administracion/discounts/delete",
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
        url = '/administracion/discounts/save';
    }else{
        url = '/administracion/discounts/update';
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
