$("#frm1").submit(function(event){
	//alert("hola");
	event.preventDefault();
	$.ajax({
				type: "POST",
				url: "/informes/save",
				data: {nombres_ap: $("#nombres_ap").val(), email: $("#email").val(), celular: $("#celular").val(), centro_laboral: $("#centro_laboral").val(), programa: $("#programa").val(), opt: $("#opt").val() ,consulta: $("#consulta").val()},
				success: function(response){
				$("input").val("");
				$("textarea").val("");
				$("select").val("--");

				alert(response);
				},
				error: function (xhr, ajaxOptions, thrownError) {
			    alert(xhr.status);
			    alert(thrownError);
			      }
	});
})

