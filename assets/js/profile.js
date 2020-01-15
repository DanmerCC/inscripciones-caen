var tempDiscountId=-1;
var global_requirement_id = [];
var solicitudComponets=[];
var solicitudFormalComponets=[];
var proInvest=[];
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

    //configuracion de uploads
    //configInputsFile("#frmUploadCv input[type='file']","/postulante/upload/cv");

	
    configuracionInputErrors()
    
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

	/*Efecto de desactivar 
	relacionarColapseLi('#aInfPersonal','#collapse1');
	relacionarColapseLi('#aInfAcademica','#collapse2');
	relacionarColapseLi('#aInfLaboral','#collapse3');
	relacionarColapseLi('#aInfSalud','#collapse7');
	relacionarColapseLi('#aInfReferencias','#collapse6');
    relacionarColapseLi('#aSolicitudes','#collapse8');
    relacionarColapseLi('#aDocs','#collapse9');
    relacionarColapseLi('#formatesPanel','#collapse10');
    relacionarColapseLi('#aInfOtros','#collapse11');
    */
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
                $("#genero").val(datos[i].genero);
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

                

                // $("#collapse2").each(function(){
                //     console.log("Aqui estoy");
                //     var git = $("#t_enfermedad_otros").val();
                //     if( git === ''){
                //         alert('Prueba');
                //     }
                //     else{
                //         console.log("Fuera");
                //     }
                // });

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




$("#si_militar").on('change',function(){
    desactStateMil(!$(this).prop('checked'));
});
realoadAllSolicitudes()
loadAllDiscountList();

}

/*Carga de configuracion*/
$(document).ready(configuracion);

function realoadAllSolicitudes()
{
    $.ajax({
        url: "/api/solicitudes",
        type: "post",
        data:{},
        contentType: false,
        processData: false,

        success: function (data) {

            var datos = JSON.parse(data);
            $("#contentSolicitudes").html('');
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
                
                //conditional if exist discount
                var htmlHasDiscount = '';
                if (datos[i].solicitud_discount) {
                    htmlHasDiscount = `<a class='btn btn-block btn-info btn-xs' title="Ver descuento" 
                                        onclick="openModalDiscountInfo(${datos[i].idSolicitud})">
                                            <i class="fa fa-eye"></i> Desc.</a>`;
                }else{
                    htmlHasDiscount = `<a class='btn btn-block btn-success btn-xs' title="Agregar descuento" 
                                        onclick="openModalNewDiscountBySolicitud(${datos[i].idSolicitud},'${datos[i].numeracion} ${datos[i].tipoCurso} ${datos[i].nombreCurso}')">
                                        <i class="fa fa-plus"></i> Desc.</a>`;
                }
                //Creacion de diseño de Despegable SOLICITUDES
                var htmlDelete = '';
                if(datos[i].is_deletable == true) {
                    htmlDelete = `<div class='col-xs-6 col-md-2'><a href="${alinkdel}" class='btn btn-block btn-danger btn-xs' onclick="if(!confirm('Estas seguro de eliminar')){ event.preventDefault() }"><i class='fa fa-trash'></i></a></div>`;
                }else{
                    htmlDelete = "<div class='col-xs-6 col-md-2'><a class='btn btn-block btn-warning btn-xs' onclick='alertExistRelationForDelete()'><i class='fa fa-exclamation'></i></a></div>";
                }
                var diseño = 
                "<div class='row panel box box-success'>"+
                    "<div class='col-xs-3 col-md-4'>"+datos[i].numeracion+" "+datos[i].tipoCurso+" "+datos[i].nombreCurso+"</div>"+
                    "<div class='col-xs-4 col-md-2'>"+datos[i].tipo_financiamiento+"</div>"+
                    "<div class='col-xs-5 col-md-6'>"+
                        "<div class='row'>"+
                            "<div class='col-xs-6 col-md-1' title='Hoja de datos completa lista para ser firmada'><a target='_blank' href="+alink+">Ficha completa</a></div>"+
                            "<div class='col-xs-12 col-md-4'>"+
                                "<button type='button' class='btn btn-block btn-primary btn-xs' data-toggle='modal' data-target='#modalDocument"+(i+1)+"'>"+
                                    "Información requerida"+
                                "</button>"+
							"</div>"+
							
							"<div class='col-xs-12 col-md-2'>"+htmlHasDiscount+"</div>"+
							
                            htmlDelete+
                        "</div>"+
                    "</div>"+
                "</div><br>"+
                modal;
                
                //Insercion en Despegable SOLICITUDES
				$("#contentSolicitudes").append(diseño);
				$("#contentSolicitudesDocument").append(div_row(row_diseño(i,datos[i])+div_modal_document(i,datos[i])));

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
				
				solicitudComponets["fSolicitudFileComponent"+(i+1)]=cc.fileComponent("#fSolicitudFileComponent"+(i+1),{
					"state":false,
					"target":"fSolicitudFileComponent"+(i+1),
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
				
				solicitudFormalComponets["fSolicitudFormalFileComponent"+(i+1)]=cc.fileComponent("#fSolicitudFormalFileComponent"+(i+1),{
					"state":false,
					"target":"fSolicitudFormalFileComponent"+(i+1),
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
				
				proInvest["fproInvest"+(i+1)]=cc.fileComponent("#fproInvest"+(i+1),{
					"state":false,
					"target":"fproInvest"+(i+1),
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
}

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

function div_row(content){
	return "<div class='row'>"+content+"<div class='row'>";
}

function div_modal_document(index,solicitud){
return "<div class='modal fade' id='fmodalDocument"+(index+1)+"' tabindex='-1' role='dialog' aria-labelledby='modalDocumentLabel"+(index+1)+"'>"+
			"<div class='modal-dialog' role='document'>"+
				"<div class='modal-content'>"+
					"<div class='modal-header'>"+
						"<button type='button' class='close' data-dismiss='modal' aria-label='Close'>"+
							"<span aria-hidden='true'>&times;</span>"+
						"</button>"+
						"<h4 class='modal-title' id='myfModalLabel'><strong> Otros Documentos </strong>"+
							solicitud.numeracion+" "+solicitud.tipoCurso+" "+solicitud.nombreCurso+
						"</h4>"+
					"</div>"+
					"<div class='modal-body'>"+
                        "<div class='row'>"+
                            "<div class='col-xs-12 col-md-6'>"+
                                "<div class='bg-gray panel'>"+
                                    "<div class='container'>"+
                                        "<div class='row'>"+
                                            "<div class='col-xs-12 col-md-6' >"+
                                                "<a class='btn btn-default btn-sm' target='_blank' href='/postulante/pdf/"+solicitud.idSolicitud+"'>imprimir para firmar</a>"+
                                            "</div>"+
                                        "</div>"+
                                        "<div class='row'>"+
                                            "<div class='col-xs-12 col-md-12' id='fSolicitudFileComponent"+(index+1)+"'></div>"+
                                        "</div>"+
                                    "</div>"+
                                "</div>"+
                            "</div>"+

                            /**fsolicitud */
                            "<div class='col-xs-12 col-md-6'>"+
                                "<div class='bg-gray panel'>"+
                                    "<div class='container'>"+
                                        "<div class='row'>"+
                                            "<div class='col-xs-12 col-md-6' >"+
                                                "<a class='btn btn-default btn-sm' target='_blank' href='/generator/solad/"+solicitud.idSolicitud+"'>imprimir para firmar</a>"+
                                            "</div>"+
                                        "</div>"+
                                        "<div class='row'>"+
                                            "<div class='col-xs-12 col-md-6' id='fSolicitudFormalFileComponent"+(index+1)+"'></div>"+
                                        "</div>"+
                                    "</div>"+
                                "</div>"+
                            "</div>"+

                            /**Doctirado condicional */
                            "<div class='col-xs-12 col-md-6'>"+
                                "<div class='bg-gray panel'>"+
                                    "<div class='container'>"+
                                        "<div class='row'>"+
                                            
                                        "</div>"+
                                        "<div class='row'>"+
                                            (solicitud.tipoCurso=="Doctorado"?"<div class='col-xs-12 col-md-6' id='fproInvest"+(index+1)+"'></div>":"")+
                                        "</div>"+
                                    "</div>"+
                                "</div>"+    
                            "</div>"+
                            //alinknotification(solicitud)+
                        "</div>"+   
					"</div>"+
					"<div class='modal-footer'>"+
						"<button type='button' class='btn btn-primary' data-dismiss='modal'>Cerrar</button>"+
					"</div>"+
				"</div>"+
			"</div>"+
		"</div>";
}

function alinknotification(solicitud){
	return ((!solicitud.completeFile)?"<div class='col-xs-12 col-md-6'><a href='#'><button class='btn btn-sm bg-light-blue disabled color-palette' data-dismiss='modal' data-toggle='collapse' data-parent='#accordion' href='#collapse9' data-target=''>"+solicitud.msgUploadFile+"</button></a></div>":"");
}

function row_diseño(index,solicitud){

	return "<div class=''>"+
		"<div class='row'>"+
			"<div class='col-xs-12 col-md-12'>"+
				"<div class='box box-success box-solid'>"+
                "<div class='box-header with-border'> Documentos para "+solicitud.numeracion+" "+solicitud.tipoCurso+" "+solicitud.nombreCurso+"</div>"+
					"<div class='box-body'>"+
						"<button type='button' class='btn btn-block btn-primary btn-xs' data-toggle='modal' data-target='#fmodalDocument"+(index+1)+"'>"+
							"ver documentos a subir "+
						"</button>"+
					"</div>"+
				"</div>"+
			"</div>"+
        "</div>"+
	"</div><br>";
}

function configuracionInputErrors()
{
    $('input.cleanerror').change(function (e) { 
        e.preventDefault();
        $(this).next().empty();
        $(this).parent().removeClass('has-error');
    });
    $('select.cleanerror').change(function (e) { 
        e.preventDefault();
        $(this).next().empty();
        $(this).parent().removeClass('has-error');
    });
}

function loadAllDiscountList()
{

    $.ajax({
        type: "GET",
        url: "/postulante/misdescuentos",
        data: {},
        dataType: "json",
        success: function (response) {
            if (response.status) {
                if(response.data.length>0) {
                    makeDiscountsHtmlList(response.data);
                }else{
                    
                }
            } else {

            }
        }
    });
}

function makeDiscountsHtmlList(discounts)
{
    let discountRow = '';
    discounts.forEach(discount => {
        discountRow +=`<div class='row'>
            <div class='col-xs-3 col-md-4'>${discount.numeracion} ${discount.tipo} ${discount.nombre}</div>
            <div class='col-xs-4 col-md-3'>${discount.name}</div>
            <div class='col-xs-5 col-md-5'>
                <div class='row'>
                    <div class='col-xs-6 col-md-2'><a class="btn btn-danger hide" onclick="" >Eliminar</a></div>
                    <div class='col-xs-12 col-md-5'>
                        <button type='button' class='btn btn-block btn-primary btn-xs' onclick="openModalDiscountInfo(${discount.solicitud_id})">
                            Ver mis requisitos
                        </button>
                    </div>
                </div>
            </div>
        </div>`;
    });
    
    document.getElementById('contentDiscount').innerHTML = discountRow;
}

function openModalDiscountInfo(discount_id)
{
    $.ajax({
        type: "GET",
        url: "postulante/misdescuentos/"+discount_id,
        data: {},
        dataType: "json",
        success: function (response) {
            if (response.status) {
                document.getElementById('discountsBodyAndRequirements').innerHTML = makeDiscountsHtml(response.data.programa);
                $("#discountModalInformation").modal("show");
            } else {
                document.getElementById('discountsBodyAndRequirements').innerHTML = '<span class="alert alert-danger"></span>';
            }
        }
    });
}

function makeDiscountsHtml(parametros) {
    let discountsRows = '';
    parametros.discount.forEach(discount => {
        discountsRows += `<div class="form-group">
            <label for="">${discount.name}</label>
            <ul class="list-group">
                ${makeRequirementsHtml(parametros.requirements,discount.id)}
            </ul>
        </div>`;
    });
    return discountsRows;
}
function makeRequirementsHtml(requirements,discount_id)
{
    let requiremenstRows = '';
    requirements.forEach(requirement => {
        if(requirement.discount_id == discount_id){
            requiremenstRows += `<li class="list-group-item"><a href="/administracion/requirements/document/${requirement.file}" target="_blank" class=""> ${requirement.name}  <i class="fa fa-file-pdf-o text-danger" aria-hidden="true"></i></a></li>`;
        }
    });

    return requiremenstRows;
}


function openModalAddNewDiscount(alumno_id){
    resetFormDiscount();
    $.ajax({
        type: "GET",
        url: "/administracion/solicitud/alumno/"+alumno_id,
        data: {},
        dataType: "json",
        success: function (response)
        {
            if(response.data != null)
            {
                makeSelectSolicitudes(response.data);   
            }
        },
        error: function (responseError)
        {
            alert("Error")
        },
        complete: function ()
        {
        }
    });
    $("#modalAddDiscount").modal("show");
}

function alertExistRelationForDelete()
{
    bootbox.alert({
        message: "<h4>No se puede eliminar ya que se encuentra en uso</h4>",
        backdrop: true
    });
}

function makeSelectSolicitudes(solicitudes)
{
    let options = '<option value="">Elejir una solicitud</option>';
    solicitudes.forEach(element => {
        options += `<option value="${element.idSolicitud}">${element.nombre}</option>`;
    });
    document.getElementById('solicitud_idd').innerHTML = options;
}


document.getElementById('solicitud_idd').onchange = changeSolicitudForDiscountEvent;

function changeSolicitudForDiscountEvent(evt)
{
    let solicitud_id = evt.target.value;
    if(solicitud_id!='')
    {
        $.ajax({
            type: "GET",
            url: "/administracion/discounts/solicitud/"+solicitud_id,
            data: {},
            dataType: "json",
            success: function (response) {
                if(response.data != null)
                {
                    makeListRequirenentsRadio(response.data);   
                }
            }
        });
    }
}
//@deprecated 
function makeSelectDiscounts(discounts)
{
    let options = '<option value="">Elejir un descuento</option>';
    discounts.forEach(element => {
        options += `<option description="${element.description}" value="${element.id}">${element.name}</option>`;
    });
    document.getElementById('tipodescuento_idd').innerHTML  = options;
}

function makeListRequirenentsRadio(discounts)
{
    
    let rows = '';
    if (discounts.length>0) {
        discounts.forEach(element => {
            rows += `<li class="list-group-item entradaRow" style="cursor: pointer;">
                        <input type="radio" description="${element.description}"  id="discountInput${element.id}" class="hide" name="discountInput" value="${element.id}">
                        ${element.name}
                        <span class="pull-right-container">
                            <small class="label pull-right bg-green">${element.percentage} %</small>
                        </span>
                    </li>`;
        });
    }else{
        rows = '<li class="list-group-item">No hay descuentos</li>';
    }
    document.getElementById('discountList').innerHTML  = rows;
    loadFreshRenderEventList();
}

function changeDiscountForRequirementsEvent(evt)
{
    let discount_id = evt.value;
    let descripcion = $(evt).attr('description');//$(evt.target.children[evt.target.selectedIndex]).attr('description');
    if (descripcion!='' && descripcion!=undefined) {
        document.getElementById('descripctionDescuentoSelected').textContent = descripcion;
    }else{
        document.getElementById('descripctionDescuentoSelected').textContent = '';
    }
    if (discount_id!='') {
        $.ajax({
            type: "GET",
            url: "administracion/requirements/discount/"+discount_id,
            data: {},
            dataType: "json",
            success: function (response) {
                if(response.data != null && response.data.length>0) {
                    makeInputFileRequisitosTemplate(response.data)
                } else {
                    document.getElementById('bodyRequirementUploadFiles').innerHTML =`<div class="alert alert-danger">El beneficio seleccionado no tiene ningun requisito</div>`;
                }
            }
        });
    }
}

function makeInputFileRequisitosTemplate(requisitos)
{
    let rows = '';
    global_requirement_id = [];
    requisitos.forEach((element,index) => {
        global_requirement_id.push(element.id);
        rows += `<div class="box box-solid">
                    <div class="box-body"> 
                    <div class="form-group">
                        <div class="box-header bg-success">
                            <label for="file_requirement_${element.id}">${index+1}.- ${element.name}</label>
                        </div>
                            <p>${element.description}</p>
                            <input type="file" id="file_requirement_${element.id}" name="file_requirement[${element.id}]" accept="application/pdf" class="form-control cleanerror">
                            <span class="help-block"></span>
                        </div>
                    </div>
                </div>`;
    });

    document.getElementById('bodyRequirementUploadFiles').innerHTML = rows;
    configuracionInputErrors()
}

$("#formDiscountCreate").submit(function (e) { 
    e.preventDefault();
    if (isValidFormDiscount()) {
        $.ajax({
            type: "POST",
            url: "/postulante/solicitud/discount/store",
            data: new FormData(this),
            processData: false,
            contentType: false,
            dataType: "json",
            success: function (response) {
                if (response.status == 'OK') {
                    $("#modalAddDiscount").modal("hide");
                    realoadAllSolicitudes();
                    loadAllDiscountList();
                } else {
                    alert("No se puedo guardar");
                }
            },
            error: function(error) {
                if (error.status == 500) {
                    document.getElementById('errorGenericoDiscount').innerText = error.responseJSON.data.message;
                    document.getElementById('errorGenericoDiscount').style.display = "block";
                } else if (error.status == 401) {
                    alert(error.responseJSON.data.message);
                    document.getElementById('errorGenericoDiscount').innerText = error.responseJSON.data.message;
                    document.getElementById('errorGenericoDiscount').style.display = "block";
                } else {
                    alert("Ocurrio un error interno");
                }
            }
        });
    }
});

function resetFormDiscount()
{
    $("#formDiscountCreate")[0].reset();
    document.getElementById('bodyRequirementUploadFiles').innerHTML = '<div class="alert alert-success">Seleccionar un descuento</div>';
    tempDiscountId=-1;
    document.getElementById('discountList').innerHTML = `<li class="list-group-item">No hay descuentos</li>`;
}

function isValidFormDiscount()
{
    let status = true;
    let solicitud_id = document.getElementById('solicitud_idd').value;
    let tipodescuento = $("input[name=discountInput]:checked").val();
    if(solicitud_id==''){
        showErrorForAll(document.getElementById('solicitud_idd'));
        status = false;
    }

    if(tipodescuento=='' || tipodescuento== undefined){
        showErrorForDiscount();
        status = false;
    }

    if(!isValidFilesRequirement()){
        status = false;
    }

    return status;
}

function isValidFilesRequirement()
{
    let status = true;
    global_requirement_id.forEach(idd => {
        let tempFile = document.getElementById('file_requirement_'+idd).value;
        if(tempFile==''){
            status = false;
            showErrorForAll(document.getElementById('file_requirement_'+idd));
        }
    });
    return status;
}

function showErrorForAll(element)
{
    element.nextElementSibling.textContent = "Por favor completar campo.";
    element.parentElement.classList.add("has-error");
}

function showErrorForDiscount(){
    document.getElementById('discountList').nextElementSibling.textContent = "Por favor elejir una opcion.";
    document.getElementById('discountList').parentElement.classList.add("has-error");
}

function removeMessageErrorIfExist(){
    document.getElementById('discountList').nextElementSibling.textContent = "";
    document.getElementById('discountList').parentElement.classList.remove('has-error');
}

function openModalNewDiscountBySolicitud(solicitud_id,nombre_programa)
{
    resetFormDiscount();
    document.getElementById('solicitud_idd').innerHTML = `<option value="${solicitud_id}">${nombre_programa}</option>`;
    dispararTriggerSelect();
    $("#modalAddDiscount").modal("show");
}


function loadFreshRenderEventList()
{
    document.querySelectorAll('.entradaRow').forEach(item => {
        item.addEventListener('click', event => {
            if(tempDiscountId != event.target.children[0].value){
                tempDiscountId = event.target.children[0].value;
                document.getElementById('tipodescuento_idd').value = event.target.children[0].value
                event.target.children[0].checked =true;
                cleanClass()
                event.target.classList.add('active');
                changeDiscountForRequirementsEvent(event.target.children[0])
                removeMessageErrorIfExist();
            }
        })
    })
}

function cleanClass()
{
    document.querySelectorAll('.entradaRow').forEach(item => {
        item.classList.remove('active');
    })
}

function dispararTriggerSelect()
{
    $("#solicitud_idd").trigger('change');
}
