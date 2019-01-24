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
<div class="login-box">
  <div class="login-logo">
  <!-- <img src="assets/img/logo-caen.png" alt=""> -->
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg"><strong>Inicia sesión para comenzar</strong></p>

    <form action=<?=$action ?> method="post">
      <div class="form-group has-feedback">
        <input type="text" name="usuario" class="form-control" placeholder="NUMERO DE USUARIO">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="password" class="form-control" placeholder="Contraseña">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-6">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Ingresar</button>
        </div>
        <div class="col-xs-6">
          <a href="registro" class="btn btn-primary btn-block btn-flat">Registrarse</a>
        </div>
        <!-- /.col -->
      </div>
    </form>
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<?=$footer?>
</body>
</html>
