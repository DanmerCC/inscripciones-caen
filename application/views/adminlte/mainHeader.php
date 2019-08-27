<header class="main-header"><meta http-equiv="Content-Type" content="text/html; charset=euc-jp">
    <!-- Logo -->
    <a href="/" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>C</b>AEN</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>CAEN</b> EPG</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Opciones</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          
          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu" id="notification-component">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning" id="not-tot">0</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header" id="not-tot-text"></li>
              <li>
                
                <ul class="menu" id="not-menu">
								<!--
                  <li>
                    <a href="#">
                      <i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the
                      page and may cause design problems
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-users text-red"></i> 5 new members joined
                    </a>
									</li>
								-->	
                </ul>
							</li>
							<!--
							<li class="footer"><a href="#">Ver todos</a></li>
							-->
            </ul>
          </li>
          
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src=<?=$identity["rutaimagen"]?> class="user-image" alt="User Image">
              <span class="hidden-xs"><?=$identity["nombres"]?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src=<?=$identity["rutaimagen"]?> class="img-circle" alt="User Image">
                <p>
                  <?=$identity["nombres"]?>
                </p>
              </li>
              <!-- Menu Body -->

              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Perfil</a>
                  <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-change-pwd">Cambiar Contraseña</button>
                </div>
                <div class="pull-right">
                  <a id="btn-salir" href="/postulante/salir" class="btn btn-default btn-flat">Salir</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <!-- <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a> -->
          </li>
        </ul>
      </div>
    </nav>
  </header>
<script>

function getPromiseNotifications(){
	return new Promise(function(resolve, reject) {
		var xhr = new XMLHttpRequest();
		xhr.open('get', '/admin/notifications', true);
		xhr.responseType = 'json';
		xhr.onload = function() {
			var status = xhr.status;
			if (status == 200) {
				resolve(xhr.response);
			} else {
				reject(status);
			}
		};
		xhr.send();
	});
}

getPromiseNotifications().then(function(response){
	if(response!=null){
		var total_notification=response.length;
		var div_not_tot=document.getElementById('not-tot');
		var div_not_tot_text=document.getElementById('not-tot-text');
		var ul_container=document.getElementById('not-menu');

		div_not_tot.innerHTML=total_notification;
		div_not_tot_text.innerHTML=`Usted tiene ${total_notification} notificaciones`;
		var list_notification="";
		for (let index = 0; index < response.length; index++) {

			list_notification = list_notification+construct_notification_li(response[index].mensaje);
		}
		ul_container.innerHTML=list_notification;

	}

}).catch();


function construct_notification_li(mensaje){	

	return `<li>
		<a href="#">
			<i class="fa fa-warning text-yellow" style="word-wrap: break-word;"></i> ${mensaje}
		</a>
	</li>`;
}


</script>
