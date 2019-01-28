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

<div class="contenedor">
 </div>
		<script src="/adminlte/bower_components/jquery/dist/jquery.min.js"></script>
		<script src="/adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
