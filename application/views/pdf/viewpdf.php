<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="/adminlte/bower_components/font-awesome/css/font-awesome.min.css">
  <title>Document</title>
</head>
<body>
<div id="wrap">
<iframe id="frame" src="data:application/pdf;base64,<?= $data; ?> " width="100%" height="900"></iframe>
</div>
<input id="type" type="hidden" value="<?=$typeFile;?>" />
<input id="id" type="hidden" value="<?=$id;?>"/>
<div class="contenedor">
<button class="botonF1">
  <span><i class="fa fa-pencil-square-o" aria-hidden="true"></i></span>
</button>
<button id="checkButton" class="btn botonF2">
<i class="fa fa-check" aria-hidden="true"></i>
</button>
 </div>

<div class="modal" tabindex="-1" role="dialog" id="myModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Modal body text goes here.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary">Save changes</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
    
		<script src="/adminlte/bower_components/jquery/dist/jquery.min.js"></script>
		<script src="/adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<style>
.contenedor{
  width:90px;
  height:240px;
  position:absolute;
  right:30px;
  bottom:70%;
}
.botonF1{
  width:60px;
  height:60px;
  border-radius:100%;
  background:#F44336;
  right:0;
  bottom:0;
  position:absolute;
  margin-right:16px;
  margin-bottom:16px;
  border:none;
  outline:none;
  color:#FFF;
  font-size:36px;
  box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);
  transition:.3s;  
}
span{
  transition:.5s;  
}
.botonF1:hover span{
  transform:rotate(360deg);
}
.botonF1:active{
  transform:scale(1.1);
}
.btn{
  width:40px;
  height:40px;
  border-radius:100%;
  border:none;
  color:#FFF;
  box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);
  font-size:28px;
  outline:none;
  position:absolute;
  right:0;
  bottom:0;
  margin-right:26px;
  transform:scale(0);
}

.botonF2{
  background:#009d00;
  margin-bottom:85px;
  transition:0.5s;
}
.animacionVer{
  transform:scale(1);
}

</style>
<script>
$('#myModal').modal('hide');
$('.botonF1').hover(function(){
  $('.btn').addClass('animacionVer');
})
$('.contenedor').mouseleave(function(){
  $('.btn').removeClass('animacionVer');
});
$("#checkButton").click(function(){
	$.ajax({
		type: "post",
		url: "/postulante/checkingfile",
		data:{
			"type":$("#type").val(),
			"id":$("#id").val()
		},
		dataType: "json",
		success: function (response) {
			//console.log(response);
			if(response.status=="OK"){
				alert("Verificado con exito");
			}
		}
	});
});
</script>
</body>
