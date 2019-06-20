<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=euc-jp">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Login</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
	<?=$cabecera?>
	<link rel="stylesheet" href="assets/css/login.css">
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
    <img src="assets/img/logo-caen.png" alt="">
  </div>
  <div class="sin-bordes register-box-body ">
    <p class="login-box-msg">Registrate aqui</p>

    <form id="frmRegistro" action="registro/enviar" method="post">
      <div class="form-group has-feedback">
        <input type="text" name="id" class="form-control" placeholder="DNI/PASAPORTE/C.E" minlength="8" maxlength="12" required>
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="text" name="nombre" class="form-control" placeholder="NOMBRES">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="text" name="apellido_paterno" class="form-control" placeholder="APELLIDOS PATERNO" required>
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="text" name="apellido_materno" class="form-control" placeholder="APELLIDOS MATERNO" required>
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
			<div class="form-group has-feedback">
        <input type="tel" name="celphone" class="form-control" placeholder="Numero de contacto" pattern="[0-9]*" required>
        <span class="glyphicon glyphicon-earphone form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="email" name="email" class="form-control" placeholder="Correo" required>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input id="password" type="password" name="password" class="form-control" placeholder="Contraseña" maxlength="10" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input id="password_repeat" type="password" class="form-control" placeholder="Repite la contraseña" required>
        <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <div data-iddefaultType="<?=(isset($defaultIdProgramType)?$defaultIdProgramType:'')?>" id="default-type"></div>
        <div data-iddefault="<?=(isset($defaultIdProgram)?$defaultIdProgram:'')?>" id="default-course"></div>
        <select class="form-control" name="tipo_programa_id" id="slctTipoPrograma" required>
          
        </select>
        <span class="glyphicon glyphicon-education form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <select class="form-control" name="programa_id" id="slctPrograma" required>
          <option value="" >No seleccionaste el tipo</option>
        </select>
        <span class="glyphicon glyphicon-education form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <select name="tipoFinan" id="tipoFinan" class="form-control">
            <option value="Contado">Contado</option>
            <option value="Cuotas">Cuotas</option>
        </select>
      </div>
      <div class="form-group">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input id="tac" type="checkbox"> Aceptos los <a href="#">terminos</a>
            </label>
          </div>
        </div>
        <!-- /.col -->
        
        <!-- /.col -->
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-primary btn-block btn-flat">Registrarse</button>
      </div>
      <div class="form-group">
        <a class="btn btn-secundary btn-sm btn-block btn-flat" href="<?=base_url();?>">Ya tengo una cuenta</a>
      </div>
      
      
    </form>

    <!-- <div class="social-auth-links text-center">
      <p>- OR -</p>
      <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign up using
        Facebook</a>
      <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign up using
        Google+</a>
    </div> -->

    <!--<a href="http://caen.edu.pe/publicfiles/GUIA.pdf" class="text-center">Guia del participante</a>-->
  </div>
  <!-- /.form-box -->
</div>
<!-- /.register-box -->

<?=$footer?>

<script src="/assets/js/registro.js"></script>
</body>
</html>
