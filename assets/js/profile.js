var configuracion = function(){
    ///$("#aDocs").trigger('click');
    //charge fileObject
    var cargaCv=cc.fileComponent("#containerBoxCV",{
        "state":false,
        "target":null,
        "urlUpload":"/postulante/upload/cv",
        "verification":"/postulante/",
        "tittle":"Curriculum",
		"identifier":"cv",
        "urlview":"/admin/view/pdf",           
        "pathInfo":"/file/info",
        "pathDelete":"/file/delete"
    });
    var cargaDJ=cc.fileComponent("#containerBoxDJ",{
        "state":false,
        "target":null,
        "urlUpload":"/postulante/upload/dj",
        "tittle":"DeclaracionJurada",
        "identifier":"dj",
		"urlview":"/admin/view/pdf",           
        "pathInfo":"/file/info",
        "pathDelete":"/file/delete"
    });
    var cargaDJ=cc.fileComponent("#containerBoxCopys",{
        "state":false,
        "target":null,
        "urlUpload":"/postulante/upload/cp",
        "tittle":"Copia de Dni",
        "identifier":"dni",
		"urlview":"/admin/view/pdf",           
        "pathInfo":"/file/info",
        "pathDelete":"/file/delete"
    });

    var cargaDJ=cc.fileComponent("#containerBoxBachiller",{
        "state":false,
        "target":null,
        "urlUpload":"/postulante/upload/bach",
        "tittle":"Constancia de Bachiller",
        "identifier":"bach",
		"urlview":"/admin/view/pdf",           
        "pathInfo":"/file/info",
        "pathDelete":"/file/delete"
    });

    var cargaDJ=cc.fileComponent("#containerBoxMaestria",{
        "state":false,
        "target":null,
        "urlUpload":"/postulante/upload/maes",
        "tittle":"Constancia de maestria",
        "identifier":"maes",
		"urlview":"/admin/view/pdf",           
        "pathInfo":"/file/info",
        "pathDelete":"/file/delete"
    });

    var cargaDJ=cc.fileComponent("#containerBoxDoctorado",{
        "state":false,
        "target":null,
        "urlUpload":"/postulante/upload/doct",
        "tittle":"Constancia de Doctorado",
        "identifier":"doct",
		"urlview":"/admin/view/pdf",           
        "pathInfo":"/file/info",
        "pathDelete":"/file/delete"
    });
    var cargaDJ=cc.fileComponent("#containerBoxSolicitud",{
        "state":false,
        "target":null,
        "urlUpload":"/postulante/upload/sins",
        "tittle":"Solicitud de Admision",
        "identifier":"sins",
		"urlview":"/admin/view/pdf",           
        "pathInfo":"/file/info",
        "pathDelete":"/file/delete"
    });
    //configuracion de uploads
    //configInputsFile("#frmUploadCv input[type='file']","/postulante/upload/cv");

	var solicitudComponets=[];
	var solicitudFormalComponets=[];
    var proInvest=[];

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

    //updatepwd
    
    
    //*DESABILITACION DE LOS CHECKBOXES CON LOS SIGUIENTES ID´S*//
    var chks_enfermedad=["t_enfermedad_asma","t_enfermedad_arterial","t_enfermedad_diabetes","t_enfermedad_cancer","t_enfermedad_otros"];

    //activa y desactiva campos con respecto a un radio button
    $("input[name=sufre_enfermedad]").change(function(){
        if ($("input[name=sufre_enfermedad]:checked").val()=="Si") {
            for (var i = chks_enfermedad.length - 1; i >= 0; i--) {
                $("#"+chks_enfermedad[i]).prop("disabled",false);
                $("#"+chks_enfermedad[i]).prop("readonly",false);
            }
        }
        if ($("input[name=sufre_enfermedad]:checked").val()=="No") {
            for (var i = chks_enfermedad.length - 1; i >= 0; i--) {
                $("#"+chks_enfermedad[i]).prop("disabled",true);
                $("#"+chks_enfermedad[i]).prop("checked",false);
                $("#"+chks_enfermedad[i]).prop("readonly",true);
            }
        }

        
    });
    
    
	//Seleciones
	$("ul.treeview-menu > li").on("click",function(){
		if(!$(this).hasClass("active")){
			$("ul.treeview-menu > li").removeClass("active");
			$(this).addClass("active");
		}else{
			$("ul.treeview-menu > li").removeClass("active");
		}
		
	});

	/*Efecto de desactivar */
	relacionarColapseLi('#aInfPersonal','#collapse1');
	relacionarColapseLi('#aInfAcademica','#collapse2');
	relacionarColapseLi('#aInfLaboral','#collapse3');
	relacionarColapseLi('#aInfSalud','#collapse7');
	relacionarColapseLi('#aInfReferencias','#collapse6');
    relacionarColapseLi('#aSolicitudes','#collapse8');
    relacionarColapseLi('#aDocs','#collapse9');
    relacionarColapseLi('#formatesPanel','#collapse10');
    relacionarColapseLi('#aInfOtros','#collapse11');
    
	reflejarDatos("#t_enfermedad_asma");
	reflejarDatos("#t_enfermedad_arterial");
	reflejarDatos("#t_enfermedad_diabetes");
	reflejarDatos("#t_enfermedad_cancer");
	reflejarDatos("#t_enfermedad_otros");


	$("#t_enfermedad_asma").trigger('change');
	$("#t_enfermedad_arterial").trigger('change');
	$("#t_enfermedad_diabetes").trigger('change');
	$("#t_enfermedad_cancer").trigger('change');
	$("#t_enfermedad_otros").trigger('change');

    $("input[name=curso_caen]").change(function(){
        if ($(this).val()=="SI") {
            $("#indicar1").prop("readonly",false);
        }else{
            $("#indicar1").prop("readonly",true);
            $("#indicar1").val();
        }
    });

    $("input[name=curso_maestria]").change(function(){
        if ($(this).val()=="SI") {
            $("#indicar2").prop("readonly",false);
        }else{
        	$("#indicar2").val("");
            $("#indicar2").prop("readonly",true);
        }
    });

	$.ajax({
        url: "/api/alumno",
        type: "post",
        data:{},
        contentType: false,
        processData: false,

        success: function (data) {
            var datos= JSON.parse(data);
        	for (var i = datos.length - 1; i >= 0; i--) {


        		$("#grado_profesion").val(datos[i].grado_profesion);
        		$("#apellido_paterno").val(datos[i].apellido_paterno);
        		$("#apellido_materno").val(datos[i].apellido_materno);
        		$("#nombres").val(datos[i].nombres);
                $("#tipoDocumento").val(datos[i].idTipoDocumento);
        		$("#dni").val(datos[i].documento);

        		$("#estado_civil").val(datos[i].estado_civil);
        		$("#fecha_nac").val(datos[i].fecha_nac);
        		$("#telefono_casa").val(datos[i].telefono_casa);
        		$("#celular").val(datos[i].celular);
        		$("#email").val(datos[i].email);
        		$("#distrito_nac").val(datos[i].distrito_nac);
        		$("#provincia").val(datos[i].provincia);
        		$("#departamento").val(datos[i].departamento);
        		$("#direccion").val(datos[i].direccion);
        		$("#interior").val(datos[i].interior);
        		$("#distrito").val(datos[i].distrito);
        		$("#lugar_trabajo").val(datos[i].lugar_trabajo);
        		$("#area_direccion").val(datos[i].area_direccion);
        		$("#tiempo_servicio").val(datos[i].tiempo_servicio);
        		$("#cargo_actual").val(datos[i].cargo_actual);
        		$("#direccion_laboral").val(datos[i].direccion_laboral);
        		$("#distrito_laboral").val(datos[i].distrito_laboral);
        		$("#telefono_laboral").val(datos[i].telefono_laboral);
        		$("#anexo_laboral").val(datos[i].anexo_laboral);
        		$("#experiencia_laboral1").val(datos[i].experiencia_laboral1);
        		$("#fecha_inicio1").val(datos[i].fecha_inicio1);
        		$("#fecha_fin1").val(datos[i].fecha_fin1);
        		$("#experiencia_laboral2").val(datos[i].experiencia_laboral2);
        		$("#fecha_inicio2").val(datos[i].fecha_inicio2);
        		$("#fecha_fin2").val(datos[i].fecha_fin2);
                $("#desc_discapacidad").val(datos[i].espec_discapacidad);
                
                //$("#si_militar").val(datos[i].si_militar);
                if (datos[i].si_militar=='1') {
                    $("#si_militar").prop('checked','checked');
                }else{
                    $("#si_militar").prop('checked','');
                }

                if (datos[i].def_democracia=='1') {
                    $("#def_democracia").prop('checked','checked');
                }else{
                    $("#def_democracia").prop('checked','');
                }
                
                if (datos[i].def_patria=='1') {
                    $("#def_patria").prop('checked','checked');
                }else{
                    $("#def_patria").prop('checked','');
                }

                desactStateMil(!(datos[i].si_militar=='1'));

                $("#plana_militar").val(datos[i].planaMilitar);
                $("#grado_militar").val(datos[i].gradoMilitar);
                $("#cip_militar").val(datos[i].cip_militar);
                $("#situacion_laboral").val(datos[i].situacion_laboral);
                $("#situacion_militar").val(datos[i].situacion_militar);

        		if (datos[i].curso_caen=="SI") {
        			$("#curso_caen_si").attr('checked','checked');
        			$("#indicar1").prop("readonly",false);
        		}else{
        			$("#curso_caen_no").attr('checked','checked');
        			$("#indicar1").prop("readonly",true);
        		}


        		$("#indicar1").val(datos[i].indicar1);

        		
        		if (datos[i].curso_maestria=="SI") {
        			$("#curso_maestria_si").attr('checked','checked');
        			$("#indicar2").prop("readonly",false);
        		}else{
        			$("#curso_maestria_no").attr('checked','checked');
        			$("#indicar2").prop("readonly",true);
        		}

        		$("#indicar2").val(datos[i].indicar2);


        		$("#titulo_obtenido").val(datos[i].titulo_obtenido);
        		$("#universidad_titulo").val(datos[i].universidad_titulo);
        		$("#fecha_titulo").val(datos[i].fecha_titulo);
        		$("#grado_obtenido").val(datos[i].grado_obtenido);
        		$("#universidad_grado").val(datos[i].universidad_grado);
        		$("#fecha_grado").val(datos[i].fecha_grado);
        		$("#maestria_obtenida").val(datos[i].maestria_obtenida);
        		$("#universidad_maestria").val(datos[i].universidad_maestria);
        		$("#fecha_maestria").val(datos[i].fecha_maestria);
        		$("#doctorado_obtenido").val(datos[i].doctorado_obtenido);
        		$("#universidad_doctor").val(datos[i].universidad_doctor);
        		$("#fecha_doctor").val(datos[i].fecha_doctor);
        		$("#referencia_personal1").val(datos[i].referencia_personal1);
        		$("#referencia_personal2").val(datos[i].referencia_personal2);

        		/*Enfermedad*/
        		$("#tipoFinan").val(datos[i].tipo_financiamiento);

        		if(datos[i].sufre_enfermedad=="Si"){
        			$("#sufre_enfermedad_si").attr('checked', datos[i].sufre_enfermedad);
        		}

        		if(datos[i].sufre_enfermedad=="No"){
        			$("#sufre_enfermedad_no").attr('checked', datos[i].sufre_enfermedad);
        		}

        		if(JSON.parse(datos[0].tipo_enfermedad).Asma=="SI"){
        			$("#t_enfermedad_asma").attr('checked', 'checked');
        		}

        		if(JSON.parse(datos[0].tipo_enfermedad).Arterial=="SI"){
        			$("#t_enfermedad_arterial").attr('checked', 'checked');
        		}

        		if(JSON.parse(datos[0].tipo_enfermedad).Diabetes=="SI"){
        			$("#t_enfermedad_diabetes").attr('checked', 'checked');
        		}

        		if(JSON.parse(datos[0].tipo_enfermedad).Cancer=="SI"){
        			$("#t_enfermedad_cancer").attr('checked', 'checked');
        		}

        		$("#t_enfermedad_otros").val(JSON.parse(datos[0].tipo_enfermedad).otros);
        		$("#t_enfermedad_otros").trigger('change');

        		
        		if (datos[i].seguro_medico=="SI") {
        			$("#seguro_medico_si").attr('checked','checked');
        		}else{
        			$("#seguro_medico_no").removeAttr('checked');
        		}

        		$("#nombre_seguro").val(datos[i].nombre_seguro);
        		$("#telefono_seguro").val(datos[i].telefono_seguro);
        		$("#emergencia_familiar").val(datos[i].emergencia_familiar);
        		$("#telefono_familiar").val(datos[i].telefono_familiar);
                $("#parentesco").val(datos[i].parentesco);
                       
                
                // $("#").val(datos[i].gradoMilitar);
        		// $("#").val(datos[i].planaMilitar);
        		// $("#").val(datos[i].tipodocumento);

        	}
            
        },error: function (xhr, ajaxOptions, thrownError) {
            console.log(xhr.status);
            console.log(thrownError);
		}
    });

$.ajax({
        url: "/api/programas",
        type: "post",
        data:{},
        contentType: false,
        processData: false,

        success: function (data) {

            var datos= JSON.parse(data);
            
            for (var i = datos.length - 1; i >= 0; i--) {
                var option = document.createElement("option");
                option.innerHTML=datos[i].numeracion+"  "+datos[i].tipoNombre+" de "+datos[i].nombre;
                option.value=datos[i].id_curso
                
                $("#selectPrograma").append(option);
            }


        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(xhr.status);
            console.log(thrownError);
        }
});

$.ajax({
        url: "/api/solicitudes",
        type: "post",
        data:{},
        contentType: false,
        processData: false,

        success: function (data) {

            var datos= JSON.parse(data);
            
            for (var i = datos.length - 1; i >= 0; i--) {

                var alink = "/postulante/pdf/"+datos[i].idSolicitud;
                var alinkdel = "/postulante/solicitud/eliminar/"+datos[i].idSolicitud;
                var alinknotification = ((!datos[i].completeFile)?"<div class='col-xs-12 col-md-6'><a href='#'><button class='btn btn-sm bg-light-blue disabled color-palette' data-dismiss='modal' data-toggle='collapse' data-parent='#accordion' href='#collapse9' data-target=''>"+datos[i].msgUploadFile+"</button></a></div>":"");
                
                //Creacion de modal a mostrar en Despegable SOLICITUDES
                var modal =
                "<div class='modal fade' id='modalDocument"+(i+1)+"' tabindex='-1' role='dialog' aria-labelledby='modalDocumentLabel"+(i+1)+"'>"+
                    "<div class='modal-dialog' role='document'>"+
                        "<div class='modal-content'>"+
                            "<div class='modal-header'>"+
                                "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>"+
                                    "<span aria-hidden='true'>&times;</span>"+
                                "</button>"+
                                "<h4 class='modal-title' id='myModalLabel'><strong>Documentos para: </strong>"+
                                    datos[i].numeracion+" "+datos[i].tipoCurso+" "+datos[i].nombreCurso+
                                "</h4>"+
                            "</div>"+
                            "<div class='modal-body'>"+
                                "<div class='row'>"+
                                    "<div class='col-xs-12 col-md-6' id='SolicitudFileComponent"+(i+1)+"'></div>"+
                                    "<div class='col-xs-12 col-md-6' id='SolicitudFormalFileComponent"+(i+1)+"'></div>"+
                                    "<div class='col-xs-12 col-md-6' id='proInvest"+(i+1)+"'></div>"+
                                    alinknotification+
                                "</div>"+    
                            "</div>"+
                            "<div class='modal-footer'>"+
                                "<button type='button' class='btn btn-primary' data-dismiss='modal'>Cerrar</button>"+
                            "</div>"+
                        "</div>"+
                    "</div>"+
                "</div>";
                
                //Creacion de diseño de Despegable SOLICITUDES
                var diseño = 
                "<div class='row'>"+
                    "<div class='col-xs-3 col-md-4'>"+datos[i].numeracion+" "+datos[i].tipoCurso+" "+datos[i].nombreCurso+"</div>"+
                    "<div class='col-xs-4 col-md-2'>"+datos[i].tipo_financiamiento+"</div>"+
                    "<div class='col-xs-5 col-md-6'>"+
                        "<div class='row'>"+
                            "<div class='col-xs-6 col-md-2'><a href="+alink+">Ficha</a></div>"+
                            "<div class='col-xs-6 col-md-2'><a href="+alinkdel+">Eliminar</a></div>"+
                            "<div class='col-xs-12 col-md-4'>"+
                                "<button type='button' class='btn btn-block btn-primary btn-xs' data-toggle='modal' data-target='#modalDocument"+(i+1)+"'>"+
                                    "Información requerida"+
                                "</button>"+
                            "</div>"+
                        "</div>"+
                    "</div>"+
                "</div><br>"+
                modal;
                
                //Insercion en Despegable SOLICITUDES
                $("#contentSolicitudes").append(diseño);

                solicitudComponets["SolicitudFileComponent"+(i+1)]=cc.fileComponent("#SolicitudFileComponent"+(i+1),{
					"state":false,
					"target":"SolicitudFileComponent"+(i+1),
					"urlUpload":"/solicitud/upload/"+datos[i].idSolicitud,
					"urlVerify":"/solicitud/stateFile/"+datos[i].idSolicitud,

					"tittle":"Hoja de datos",
					"identifier":"hdatos",
					"sizeTemplate":"min",
                    "urlview":"/solicitud/view/pdf",                      
                    "pathInfo":"/file/info",
                    "pathDelete":"/file/delete",
                    "id":datos[i].idSolicitud
                });

				solicitudFormalComponets["SolicitudFormalFileComponent"+(i+1)]=cc.fileComponent("#SolicitudFormalFileComponent"+(i+1),{
					"state":false,
					"target":"SolicitudFormalFileComponent"+(i+1),
					"urlUpload":"/soladmision/upload/"+datos[i].idSolicitud,
					"urlVerify":"/soladmision/stateFile/"+datos[i].idSolicitud,

					"tittle":"Solicitud admisión",
					"identifier":"solad",
					"sizeTemplate":"min",
                    "urlview":"/solicitud/view/pdf",                      
                    "pathInfo":"/file/info",
                    "pathDelete":"/file/delete",
                    "id":datos[i].idSolicitud
                });

                proInvest["proInvest"+(i+1)]=cc.fileComponent("#proInvest"+(i+1),{
					"state":false,
					"target":"proInvest"+(i+1),
					"urlUpload":"/proinves/upload/"+datos[i].idSolicitud,
					"urlVerify":"/proinves/stateFile/"+datos[i].idSolicitud,

					"tittle":"Proyecto de Investigacion",
					"identifier":"pinvs",
					"sizeTemplate":"min",
                    "urlview":"/solicitud/view/pdf",                      
                    "pathInfo":"/file/info",
                    "pathDelete":"/file/delete",
                    "id":datos[i].idSolicitud
                });
            }

        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(xhr.status);
            console.log(thrownError);
        }
});

$("#si_militar").on('change',function(){
    desactStateMil(!$(this).prop('checked'));
});


}

/*Carga de configuracion*/
$(document).ready(configuracion);

function desactStateMil(val){
    if (val) {
        $("#cip_militar").prop({
            readonly: 'readonly'
        });
        $("#cip_militar").val("");


        $("#plana_militar").prop({
            readonly: 'readonly'
        });
        $("#plana_militar").val("");

        $("#grado_militar").prop({
            readonly: 'readonly'
        });
        $("#grado_militar").val("");

        $("#situacion_militar").prop({
            disabled: 'disabled'
        });

        $("#plana_militar").prop({
            disabled: 'disabled'
        });
    }else
    {
        $("#cip_militar").prop({
            readonly: ''
        });
        $("#plana_militar").prop({
            readonly: ''
        });

        $("#grado_militar").prop({
            readonly: ''
        });

        $("#situacion_militar").prop({
            disabled: ''
        });

        $("#plana_militar").prop({
            disabled: ''
        });
    }

}

/*Definicion de funciones*/
function relacionarColapseLi(idelemento,collapse){
/*Manipula clase li que contiene el elemento 'li'*/
	$(collapse).on('hidden.bs.collapse', function () {
		$("li:has(> "+idelemento+")").removeClass('active');
	});
	$(collapse).on('show.bs.collapse', function () {
		$("li:has(> "+idelemento+")").addClass('active');
	});
}

/*Copia de datos alos especificados en data-pointed*/
function reflejarDatos(idelemento){
	if($(idelemento).attr('type')=='checkbox'){
		$(idelemento).on('change',function(){
			if ($(idelemento).prop('checked')) {
				$($(this).data('pointed')).val("SI");
			}else{
				$($(this).data('pointed')).val("NO");
			}

		});
	}else{
		$(idelemento).on('change',function(){
			$($(this).data('pointed')).val($(this).val());
		});

	}

}

/*MOSTRAR IMAGENES*/
$('#foto').change(function(e) {
    addImage(e); 
});

function addImage(e){
    var file = e.target.files[0],
    imageType = /image.*/;

    if (!file.type.match(imageType))
    return;

    var reader = new FileReader();
    reader.onload = fileOnload;
    reader.readAsDataURL(file);
}
  
function fileOnload(e) {
    var result=e.target.result;
    $('#imagenpersona').attr("src",result);
}
 
function sendCv(){
	var fileSelect = document.getElementById('file_cv');
	var formData= new FormData();
	formData.append('cv',fileSelect.files[0],fileSelect.files[0].name);
	$.ajax({
		type: "POST",
		url: "/postulante/upload/cv",
		data: formData,
		processData:false,
		contentType:false,
		success: function (response) {
			console.log(response);
		},
		error: function (xhr, ajaxOptions, thrownError) {
            console.log(xhr.status);
            console.log(thrownError);
		}
	});
}

function uploadFile(target,urlTarget){
	var fileSelect = document.querySelector(target);
	var formData= new FormData();
	formData.append('cv',fileSelect.files[0],fileSelect.files[0].name);
	$.ajax({
		type: "POST",
		url: urlTarget,
		data: formData,
		processData:false,
		contentType:false,
		success: function (response) {
			console.log(response);
		},
		error: function (xhr, ajaxOptions, thrownError) {
            console.log(xhr.status);
            console.log(thrownError);
		}
	});
}

function downloadCv(){

	
	$.ajax({
		type: "POST",
		url: "/postulante/download/cv",
		dataType:"text",
		success: function (response) {
			console.log(response.length);
			openPDFv2(response);
		},
		error: function (xhr, ajaxOptions, thrownError) {
            console.log(xhr.status);
            console.log(thrownError);
		}
	});
}

function openPDFv2(cadena) {
	var container = document.querySelector('#magicContainer');
	var tempLink = document.createElement('a');
	tempLink.href = `data:application/pdf;base64,${cadena}`;
	tempLink.setAttribute('download', 'my-fancy.pdf');
	//console.log('click now!', tempLink.click);
	//container.append(tempLink);
	tempLink.click();
}

function configInputsFile(target,url){
    $(target).change(function(){
        console.log(this.id);
        alert(this.id);
        uploadFile(target,url)
    });
}

// function unfoldSecond(data){
//     var acordeon1 = document.getElementById(data+"1");
//     acordeon1.classList.remove("in");

//     var acordeon2 = document.getElementById(data+"2");
//     acordeon2.classList.add("in");
// }

// function unfoldThird(data){
//     var acordeon1 = document.getElementById(data+"1");
//     acordeon1.classList.remove("in");

//     var acordeon2 = document.getElementById(data+"9");
//     acordeon2.classList.add("in");
// }

