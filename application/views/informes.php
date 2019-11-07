<!DOCTYPE html>
<html lang="es">
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!--<link rel="stylesheet" href="./css/reset.css"> --> 
	<link href="https://fonts.googleapis.com/css?family=Lato:400,900" rel="stylesheet">
	<link rel="stylesheet" href="/informs_assets/css/main.css">
	<title>Formulario de Informes</title>
</head>
<body>
	<div class="container">
		 <div class="container form-group">
					<div class="row bg-granate">
							<div class="col-sm-6">
									<img src="/informs_assets/image/logocaen.png" alt=""> 
							</div>
						
					</div>
			</div>
		 
	<div class="form__top">
			<h2><span>Solicitud de Información</span></h2>
		</div>		
		<form class="form__reg" action="" method="post" name="frm1" id="frm1">
			<input id="nombres_ap" class="input" type="text" name="nombres_ap" placeholder="&#128100;  Nombres y Apellidos" required autofocus>
            <input id="email" class="input" type="email" name="email" placeholder="&#9993;  Email" required>
            <input id="celular" class="input" type="text" name="celular" placeholder="&#128241;  Celular" required>
            <input id="centro_laboral" class="input" type="text" name="centro_laboral" placeholder="&#8962;  Centro Laboral" required>
            <select id="programa" name="programa" class="form-control"  onchange="cambia()">
            	<option value="0">Elegir Programa
            	<option value="1">Doctorado
            	<option value="2">Maestría
            	<option value="3">Diplomados
            	<option value="4">Cursos
            </select>
            <select id="opt" class="form-control" name="opt">
            	<option value="-">---</option>
            </select>
          
            <textarea id="consulta" class="input" type="textarea" name="consulta" placeholder=" &#128221; Realizar su Consulta" rows="4"></textarea>

            <div class="btn__form">
            	<button id="btnsubmit" class="btn__submit" value="ENVIAR">ENVIAR</button>
            	<button class="btn__reset" type="reset" value="LIMPIAR" id="btnlimpiar">LIMPIAR</button>
            </div>
		</form>		
	</div>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="/informs_assets/js/bootbox.min.js"></script>
	<script src="/informs_assets/js/selected.js"></script>
    <script src="/informs_assets/js/informes.js"></script>
    
</body>
</html>
