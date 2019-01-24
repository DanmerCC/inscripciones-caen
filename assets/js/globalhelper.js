function ajaxCPws(){
    $("#formChangePwd").submit(function(evt){
        evt.preventDefault();
        $.ajax({
            url: '/postulante/password/cambiar',
            type: 'post',
            dataType: 'text',
            data: {
                pwdActual:$("#pwdActual").val(),
                pwdNew:$("#pwdNew").val(),
                pwdRenew:$("#pwdRenew").val()
            },
            success:function(msg){
                if (msg) {
                    $("#pwdActual").val();
                    $("#pwdNew").val();
                    $("#pwdRenew").val();
                    alert("Completado Correctamente");
                }else{
                    alert("no se pudo actualizar");

                }

            }
        })
        .done(function() {
            $("#modal-change-pwd").modal('hide');
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });
        
    });
}