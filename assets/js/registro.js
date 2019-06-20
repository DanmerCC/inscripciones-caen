
var password = document.getElementById("password")
  , confirm_password = document.getElementById("password_repeat");

function validatePassword(){
  if(password.value != confirm_password.value) {
    confirm_password.setCustomValidity("Las contraseña no coincide");
  } else {
    confirm_password.setCustomValidity('');
  }
}

password.onchange = validatePassword;
confirm_password.onkeyup = validatePassword;

$(document).ready(function(){
	loadTipesOfPorgramas();
	$("#slctTipoPrograma").change(onChangeType);
	$("#frmRegistro").on('submit',function(evt){
		evt.preventDefault();
		if ($('#tac').prop('checked')) {
			this.submit();
		}else{
			alert("Debe leer y aceptar los terminos y condiciones de uso");
		}
	});

});

function loadTipesOfPorgramas(){
	var defaultType=$("#default-type").data('iddefaulttype');
	 $("#slctTipoPrograma").append("<option value='' disabled selected>Elija Un Tipo de programa</option>");
	$.ajax({
		type: "get",
		url: "/public/api/tipos",
		data: "",
		dataType: "json",
		success: function (response) {
			for (var ii = 0; ii < response.length; ii++) {
				if(defaultType==response[ii].idTipo_curso){
					$("#slctTipoPrograma").append(option(response[ii].idTipo_curso,response[ii].nombre,true));
				}else{
					$("#slctTipoPrograma").append(option(response[ii].idTipo_curso,response[ii].nombre));
				}
				$("#slctTipoPrograma").trigger('change');
			}
			
		}
	});
}

function  option(id,value,selected=false){
	var properties_select=selected?"selected='selected'":"";
	return "<option value='"+id+"' "+properties_select+">"+value+"</option>";
}

function onChangeType(){
	var typeSelected=$("#slctTipoPrograma").val();
	if(typeSelected!=null){
		$.ajax({
			type: "get",
			url: "/public/api/programas/"+typeSelected,
			data: "",
			dataType: "json",
			success: function (response) {
				var defaultId=$("#default-course").data("iddefault");
				if(defaultId==""){
					$("#slctPrograma").html("<option value='' selected>Selecione un programa</option>");
				}
				for (var ii = 0; ii < response.length; ii++) {
					if(response[ii].id_curso==defaultId){
						$("#slctPrograma").append(option(response[ii].id_curso,response[ii].numeracion+" "+response[ii].nombre,true));
					}else{
						$("#slctPrograma").append(option(response[ii].id_curso,response[ii].numeracion+" "+response[ii].nombre));
					}
					
				}
			}
		});
	}
	
}


