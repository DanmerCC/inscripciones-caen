<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Restaurar contraseña</title>
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
    
    <form action="/login/updatePassword" method="post">
      <div class="form-group has-feedback">
        <?php if(isset($email_hash, $email_code,$email)) { ?>
          <input type="hidden" value="<?php echo $email ?>" name="email"/>
          <input type="hidden" value="<?php echo $email_hash ?>" name="email_hash"/>
          <input type="hidden" value="<?php echo $email_code ?>" name="email_code"/>
        <?php } ?>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="password" class="form-control" placeholder="Ingrese su nueva contraseña" required>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="password_conf" class="form-control" placeholder="Confirme su nueva contraseña" required>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Restaurar contraseña</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
    <?php 
        // echo validation_errors('<p class="error">');
        if(isset($success)) {
          echo '<p class="text-success">'.$success.'</p>';
				}
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
