<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Login</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
	<?=$cabecera?>
	<link rel="stylesheet" href="/assets/css/login.css">
</head>
<body class="hold-transition login-page bg-caen">
<div style="position: absolute; top: 0; left: 0; z-index: 99999;font-weight: bold; width: 100%; height: 48px; background-color: #e5e53a; display:grid; place-items: center">
		  Esta versión Pronto se dejará de usar, te recomendamos el nuevo sistema de Inscripciones
		  <a href="https://alumnos.caen.edu.pe" target="_blank">enlace aquí</a>
	  </div>
<div class="login-box">
  <div class="login-logo">
  <!-- <img src="assets/img/logo-caen.png" alt=""> -->
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg"><h1><?=(isset($title)?$title:"")?></h1><strong>Inicia sesión para empezar</strong></p>
    
    <form action=<?=$action ?> method="post">
      <div class="form-group has-feedback">
        <input type="text" name="usuario" class="form-control" placeholder="Numero de documento o Usuario" value="<?=isset($user_default)?$user_default:'';?>" required>
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-6">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Ingresar</button>
        </div>
        <?php
          if((!isset($activeRegist))||($activeRegist!=false)):
        ?>
        <div class="col-xs-6">
          <a href="registro" class="btn btn-primary btn-block btn-flat">Registrarse</a>
        </div>
        <div style="margin-top: 40px;">
          <div class="col-xs-6">
            <a href="http://caen.edu.pe/publicfiles/GUIA.pdf" class="text-center" target="_blank">Guia del participante</a>
          </div>
          <div class="col-xs-6 text-right">
            <a href="<?php echo base_url().'login/recoverpassword';?>">Olvide mi contraseña</a>
          </div>
        </div>
        <?php
          endif;
        ?>
        <!-- /.col -->
      </div>
    </form>
    <?php
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
