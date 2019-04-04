<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Recuperar Contraseña</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
	<?=$cabecera?>
	<link rel="stylesheet" href="/assets/css/login.css">
</head>
<body class="hold-transition login-page bg-caen">
<div class="login-box">
  <div class="login-logo">
  <!-- <img src="assets/img/logo-caen.png" alt=""> -->
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg"><strong>Ingrese los datos solicitados</strong></p>
    
    <form action="/login/enviarCorreo" method="post">
      <div class="form-group has-feedback">
        <input class="form-control" type="email" name="email" placeholder="Ingrese el correo con el que se registro" value="<?php echo set_value('email'); ?>"/>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Enviar correo</button>
        </div>
        <div class="col-xs-12">
        <a href="<?php echo base_url().'login';?>" class="text-center">Regresar</a>
        </div>
        <!-- /.col -->
      </div>
    </form>
    <?php 
        echo validation_errors('<p class="error">');
        if(isset($error)) {
            echo '<p class="text-danger">'.$error.'</p>';
        }
        if(isset($success)) {
          echo '<p class="text-success">'.$success.'</p>';
        } 
    ?>
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<?=$footer?>
</body>
</html>
