
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
	$("#frmRegistro").on('submit',function(evt){
		evt.preventDefault();
		if ($('#tac').prop('checked')) {
			this.submit();
		}else{

			alert("Debe leer y aceptar los terminos y condiciones de uso");
		}
	});

});