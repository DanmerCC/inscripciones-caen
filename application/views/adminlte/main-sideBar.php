  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src= <?=$rutaimagen?> class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p></p>
          <a href="#"><i class="fa fa-circle text-success"></i>En línea</a>
        </div>
      </div>
      <!-- search form -->
<!--       <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Buscar...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form> -->
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MENÚ PRINCIPAL</li>
        <?php for ($i=0;$i<count($menu);$i++) { ?>
            <li class='<?=(($menu[$i]['active'])?"treeview active":"") ?>'>
              <a href="<?php echo isset($menu[$i]['href'])?$menu[$i]['href']:'#'; ?>">
                <i class="<?php echo isset($menu[$i]['icon'])?$menu[$i]['icon']:'fa fa-shared'; ?>"></i> <span><?=$menu[$i]["text"]; ?></span>
                <span class="pull-right-container">
									<?php if($menu[$i]['hasSubModule']){ ?>
                  <i class="fa fa-angle-left pull-right"></i>
									<?php } ?>
                </span>
              </a>
              <ul class="treeview-menu">
              <?php if(isset($menu[$i]["submenu"])){
                for ($e=0; $e <count($menu[$i]["submenu"]) ; $e++){?>
                  
                    <li class="<?php echo isset($menu[$i]["submenu"][$e]["default"])?'active':''; ?>">
                      <a <?=$menu[$i]["submenu"][$e]["atributos"]; ?> <?php echo (isset($menu[$i]["submenu"][$e]["href"])?" href=".$menu[$i]["submenu"][$e]["href"]:""); ?>>
                        <i class='fa fa-circle-o'></i> <?=$menu[$i]["submenu"][$e]["text"]; ?>
                      </a>
                    </li>
                  
                <?php
                }

              }?>
            </ul>
            </li>
        <?php } ?>

       <!--  <li class="treeview" >
          <a href="#" class="default-click">
            <i class="fa fa-share"></i> <span>Mi informacion</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="active">
              <a id="aInfPersonal" data-toggle="collapse" data-parent="#accordion" href="#collapse1" class="default-click"><i class="fa fa-circle-o"></i> Informacion Personal</a>
            </li>
            <li>
              <a id='aInfAcademica' data-toggle='collapse' data-parent='#accordion' href='#collapse2'><i class='fa fa-circle-o'></i>Laboral</a>
            </li>
            <li>
              <a id="aInfLaboral" data-toggle="collapse" data-parent="#accordion" href="#collapse3"><i class="fa fa-circle-o"></i>Academica</a>
            </li>
            <li>
              <a id="aInfSalud" data-toggle="collapse" data-parent="#accordion" href="#collapse7"><i class="fa fa-circle-o"></i>Salud</a>
            </li>
            <li>
              <a id="aInfReferencias" data-toggle="collapse" data-parent="#accordion" href="#collapse6"><i class="fa fa-circle-o"></i>Referencias</a>
            </li>
          </ul>
        </li> -->
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

      <div id="modal-container">
        <div class="modal fade" id="modal-change-pwd">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Cambiar contraseña</h4>
              </div>
              <div class="modal-body">
              <form role="form" id="formChangePwd" action="/postulante/password/cambiar">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="pwdActual">Contraseña Actual</label>
                      <input type="password" class="form-control" id="pwdActual" name="pwdActual" placeholder="Password">
                    </div>
                    <div class="form-group">
                      <label for="formChangePwd">Contraseña Nueva</label>
                      <input type="password" class="form-control" id="pwdNew" name="pwdNew" placeholder="Password">
                    </div>
                    <div class="form-group">
                      <label for="formChangePwd"> Repita la contraseña Nueva</label>
                      <input type="password" class="form-control" id="pwdRenew" name="pwdRenew" placeholder="Password">
                    </div>
                  </div>
              </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary" id="btnChangePwd" form="formChangePwd">Guardar cambios</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
    </div>
