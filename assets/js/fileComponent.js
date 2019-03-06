var fileComponentTemplate={
    "templante":getFileComponentTemplate
};

var optionsDefault={
    "state":false,
    "target":null,
    "urlUpload":"/postulante/upload/cv",
    "urlVerify":"/postulante/stateFiles",
    "tittle":"Example",
	"identifier":"example",
	"urlview":"/",
	"pathInfo":"/file/default/info",
	"pathDelete":"/file/default/delete",
	"id":undefined
};

var cc={
    fileComponent:initComponent,
    uploadFile:actionUploadFile
}



function initComponent(target,options=optionsDefault){

	var minimalistTemplateGenerator=function (options){
		var stringTemplate=''+
		'<div class="">'+
			'<div class="form-group">'+
				'<div class="row">'+
					'<div id="hasFile" '+((options.state)?'':'hidden')+'>'+
						'<div class="container">'+
							'<div class="col-sm-8 col-md-8">'+
								'<a id="alinktarget" class="btn btn-success btn-sm"  target="_blank">'+
									'<i class="fa fa-eye"></i><font style="vertical-align: inherit;"> '+options.tittle+' </font>'+
								'</a>'+
								'<div id="deleteFileOption" class="btn btn-danger btn-xsm" ><a id="" href="#"><i class="fa fa-trash" aria-hidden="true"></i></a></div>'+
							'</div>'+
						'</div>'+
					'</div>'+
					'<div id="hasNotFile"'+((options.state)?'hidden':'')+' >'+
						'<form id="frmUploadCv">'+
							'<div class="col-sm-12 col-md-12">'+
								'<label class="btn btn-danger btn-sm" for="'+options.target+'_file">'+options.tittle+'<i class="fa fa-fw fa-upload" for="file_cv"></i></label>'+
								'<input  class="form-control" type="file" class="form-control" id="'+options.target+'_file" name="file_cv" value="" accept="pdf" style="visibility:hidden">'+
							'</div>'+
						'</form>'+
					'</div>'+
					'<div id="magicContainer"></div>'+
				'</div>'
			'</div>'
		'</div>';


		return stringTemplate;
	}

    var objectResult={
        "target":target,
        "changeState":function(newState){
            this.state=newState;
            changeState(newState,this.target,options.urlview);
        },
        "state":options.state,
    };

	options.target=target;
	var template;
	if(options.sizeTemplate=='min'){
		fileComponentTemplate.templante=minimalistTemplateGenerator;
	}

	template=fileComponentTemplate.templante(options);
    
    verificarEstadoFiles(function(response){
        changeState(response.content[options.identifier],options.target,options.urlview,"/"+options.identifier+"/"+response.content.nameFiles)
    },options.urlVerify,options.pathInfo);

	getInfo(options,function(response){
		changeStateDeleteOption(response.removable,options.target,options.identifier,response.urlDeleting);
	});

    $(options.target).html(template);
    var targetInput=options.target+ "  input[name='file_cv']";
    $(targetInput).change(function(){
        if($(targetInput)[0].checkValidity()){
            cc.uploadFile(targetInput,options.urlUpload,function(response){
                //changeState(response.status=="OK",options.target)
                if(response.status=="OK"){
                    alert("Documento Correctamente Subido");
                }else{
                    alert("Error al subir el archivo")
                    console.log(response.status);
                }
                verificarEstadoFiles(function(response){
                    if(response.content==[]){
                        console.log("error al pedir confirmacion")
                    }else{
                        //response.content["cv"];
                        changeState(response.content[options.identifier],options.target,options.urlview,"/"+options.identifier+"/"+response.content.nameFiles)
                    }
                },options.urlVerify);
                //verificar();
            });
        }else{
            alert("Solo se puede agregar pdfs");
        }
        
    });
    //$(options.target+' #hasFile').click(options.goodState);
    return objectResult;
}


function getFileComponentTemplate(options,modificator=undefined){
	if(modificator==undefined){
		var template=''+
		'<div class="box box-primary">'+
			'<div class="box-header with-border">'+
				'<h3 class="box-title"><font style="vertical-align: inherit;">'+options.tittle+'</font></h3>'+
			'</div>'+
			'<div class="form-group">'+
				'<div class="row">'+
					'<div id="hasFile" '+((options.state)?'':'hidden')+'>'+
						'<div class="col-sm-4">'+
							'<a id="alinktarget" class="btn btn-app"  target="_blank">'+
								'<i class="fa fa-eye"></i><font style="vertical-align: inherit;"> Ver </font>'+
							'</a>'+
						'</div>'+
						'<div class="col-sm-4">'+
							'<button class="btn btn-success btn-lg">'+
								'<i class="fa fa-fw fa-check"></i>'+
							'</button>'+
						'</div>'+
						'<div class="col-sm-4">'+
							'<div id="deleteFileOption">'+
								'<button class="btn btn-danger btn-lg">'+
									'<a href="#">'+
									'<i class="fa fa-fw fa-trash"></i>'+
									'</a>'+
								'</button>'+
							'</div>'+
						'</div>'+
					'</div>'+
					'<div id="hasNotFile" '+((!(options.state))?'':'hidden')+' >'+
						'<form id="frmUploadCv">'+
							'<div class="col-sm-4">'+
								'<label for="file_cv">'+options.tittle+'<span style="color: red">(*)</span></label>'+
								'<input  class="form-control" type="file" class="form-control" id="file_cv" name="file_cv" value="" accept="pdf">'+
							'</div>'+
							'<div class="col-sm-4">'+
								'<button class="btn btn-lg btn-danger">'+
									'<i class="fa fa-fw fa-exclamation"></i>'+
								'</button>'+
							'</div>'+
						'</form>'+
					'</div>'+
					'<div id="magicContainer"></div>'+
				'</div>'+
			'</div>'+
		'</div>';
		return template;
	}else{
		return modificator(options);
	}
    
}

function changeState(state,target,urlView="/",partUrl=""){
    if(state){
        $(target+"  #hasFile").removeAttr("hidden");
        $(target+"  #hasNotFile").prop("hidden","hidden");
        $(target+"  #alinktarget").prop("href",urlView+partUrl);
    }else{
        $(target+"  #hasFile").prop("hidden","hidden");
        $(target+"  #hasNotFile").removeAttr("hidden");
    }
    
}


function actionUploadFile(target,urlTarget,sucessUpload){
	var fileSelect = document.querySelector(target);
	var formData= new FormData();
	formData.append('cv',fileSelect.files[0],fileSelect.files[0].name);
	$.ajax({
		type: "POST",
		url: urlTarget,
		data: formData,
		processData:false,
		contentType:false,
        success: sucessUpload,
        datatype:"json",
		error: function (xhr, ajaxOptions, thrownError) {
            console.log(xhr.status);
            console.log(thrownError);
		}
	});
}

function verificarEstadoFiles(action,urlverification=null){
	if(urlverification==null){
		urlverification="postulante/stateProfileFiles"
	}
    $.ajax({
        type: "GET",
        url: urlverification,
        data: "",
        dataType: "json",
        success: action
    });
}


function getInfo(options,callback){
	$.ajax({
		type: "POST",
		url: options.pathInfo+'/'+options.identifier,
		data: {"id":options.id},
		dataType: "json",
		success:callback
	});
}

function changeStateDeleteOption(state,target,identify,urlDelete=null){
	if(state){
		$(target+"  #deleteFileOption a").click(function(){
			deleteFileAjax(urlDelete);
		});
		
		$(target+"  #deleteFileOption").removeAttr("hidden");
    }else{
		$(target+"  #deleteFileOption a").prop("href","#");
		$(target+"  #deleteFileOption").prop("hidden","hidden");
	}
}

function deleteFileAjax(urlInput){
	if(confirm("Esta seguro de borrar el archivo?")){
		$.ajax({
			type: "GET",
			url: urlInput,
			data: "",
			dataType: "json",
			success: function (response) {
				alert(response.message)
			}
		});
	}
}
