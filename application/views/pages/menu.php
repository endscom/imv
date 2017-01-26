<div class="demo-layout mdl-layout mdl-js-layout mdl-layout--fixed-drawer mdl-layout--fixed-header">

    <div class="demo-drawer mdl-layout__drawer mdl-color--blue-grey-900 mdl-color-text--blue-grey-50">

        <header id="MenuFondo" class="demo-drawer-header">
            <img id="imgUser" src="<?PHP echo base_url();?>assets/img/IMV.png" width="65%" >
            <div id="user" class="row">
                <div class="col l2 center carita">
                  <i class=" material-icons">face</i>
                </div>
                <div class="col l10 center">
                  <span class="Loggen"><?php echo $this->session->userdata('UserN');?></span>
                </div>
            </div>
        </header>
       <div id="menu">
           <ul class="nav menu demo-navigation mdl-navigation__link" >
            <?php 

              switch ($this->session->userdata('RolUser')) {
                case '0':
                  $menu = '<a href="Main"><li href="Main"><i class="material-icons">home</i> inicio</li></a>
                           <a href="datos"><li href="datos"><i class="material-icons">backup</i> carga</li></a>
                           <a href="usuarios"><li href="usuarios"><i class="material-icons">supervisor_account</i> usuarios</li></a>
                           <a href="Reportes"><li href="Reportes"><i class="material-icons">description</i> reportes</li></a>
                           <a href="#modalOpciones" class="modal-trigger"><li href="#"><i class="material-icons">settings</i> opciones</li></a>
                           <a href="salir"> <li href="salir"><i class="material-icons">exit_to_app</i> cerrar sesión</li></a>';
                break;
                case '1':
                  $menu = '<a href="Main"><li href="Main"><i class="material-icons">home</i> inicio</li></a>
                           <a href="datos"><li href="datos"><i class="material-icons">backup</i> carga de datos</li></a>
                           <a href="monitoreo"><li href="monitoreo"><i class="material-icons">equalizer</i> monitoreo</li></a>
                           <a href="usuarios"><li href="usuarios"><i class="material-icons">supervisor_account</i> usuarios</li></a>
                           <a href="Reportes"><li href="Reportes"><i class="material-icons">description</i> reportes</li></a>
                           <a href="#modalOpciones" class="modal-trigger"><li href="#"><i class="material-icons">settings</i> opciones</li></a>
                           <a href="salir"> <li href="salir"><i class="material-icons">exit_to_app</i> cerrar sesión</li></a>';
                break;
                default:
                  $menu = '<a href="salir"> <li href="salir"><i class="material-icons">exit_to_app</i> cerrar sesión</li></a>';
                  break;
              }
              echo $menu;
            ?>               
          </ul>
       </div>
    </div>



                    <!--***************MODAL CAMBIO DE CONTRASEÑA***********-->
<div id="modalOpciones" class="modal">
    <div class="btnCerrar right"><i style='color:red;' class="material-icons modal-action modal-close">highlight_off</i></div>  
    <div class="modal-content">
        <div class="row TextColor center">
          <div class="col s8 m6 l6 offset-s2 offset-m3 offset-l3">CAMBIO DE CONTRASEÑA</div>
          <div class="col s1 m1 l1 "><i class="material-icons">lock_open</i></div>
        </div>
   
        <form id="formNuevaPass" action="<?PHP echo base_url('index.php/cambiarPass');?>" method="post" name="formNuevaPass">
            <div class="row TextColor center">
                <div class="input-field offset-l1 col s12 m6 l5 ">
                    <input name="pass" id="pass1" type="password" class="validate mayuscula">
                    <label for="pass1">CONTRASEÑA:</label><label id="labelPass1" class="labelValidacion">DIGITE LA DESCRIPCIÓN</label>
                </div>
                <div class="input-field offset-l1 col s12 m6 l5 ">
                    <input name="pass2" id="pass2" type="password" class="validate mayuscula">
                    <label for="pass2">CONFIRMAR CONTRASEÑA:</label><label id="labelPass2" class="labelValidacion">DIGITE LA DESCRIPCIÓN</label>
                </div>
            </div>
        </form>
        
        <div class="row center">
            <a id="cambiarPass" class="redondo waves-effect waves-light btn">GUARDAR</a>
            <div id="loadCambiarPass" style="display:none" class="preloader-wrapper big active">
                <div class="spinner-layer spinner-blue-only">
                    <div class="circle-clipper left"><div class="circle"></div></div>
                    <div class="gap-patch"><div class="circle"></div></div>
                    <div class="circle-clipper right"><div class="circle"></div></div>
                </div>
            </div>
        </div>
    </div>
</div>

