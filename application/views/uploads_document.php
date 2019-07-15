<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Subir documentos</title>
</head>
<body>
    <? if($exist): ?>
    <div id="uploads"></div>
    <div class="dropzone" id="dropzone1">
        Arrastrar Documento
    </div>
    <? endif; ?>
    <div id="returnlink"></div>
</body>
<style>
body {
    font-family:"Arial",sans-serif;
}
.dropzone {
    width:300px;
    height:300px;
    border:2px dashed #ccc;
    line-height:300px;
    text-align:center
}
.dropzone.dragover {
    width:300px;
    height:300px;
    border:2px dashed #ccc;
    line-height:300px;
    text-align:center;
    border-color:#000;
    color:#000;
}

</style>
<script>
(function(){
    var dropzones=document.querySelectorAll('.dropzone');
    dropzones.forEach((x)=>{
        x.ondrop=function(e){
            e.preventDefault();
            this.className='dropzone';
            upload(e.dataTransfer.files);
        };

        x.ondragover=function(){
            this.className='dropzone dragover';
            return false;
        }

        x.ondragleave =function(){
            this.className='dropzone';
            return false; 
        }

    });
    var upload=function(files){
        var formData=new FormData(),
        xhr=new XMLHttpRequest(),x;
        if(files.length!=1){
            alert("Solo se permite un archivo a la vez");
            formData.append('file',files[0]);
            return;
        }
        formData.append('hola','asdas');
        xhr.onload=function(){
            var data =this.responseText;
        }
        xhr.onerror=function(){
            console.log("Ocurrio un error");
        }
        xhr.open('post','/admin/uploading');
        xhr.send(formData);

    }
}());
</script>
</html>