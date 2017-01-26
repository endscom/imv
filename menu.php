<div class="demo-layout mdl-layout mdl-js-layout mdl-layout--fixed-drawer mdl-layout--fixed-header">

    <div class="demo-drawer mdl-layout__drawer mdl-color--blue-grey-900 mdl-color-text--blue-grey-50">

        <header id="MenuFondo" class="demo-drawer-header">
            <img id="imgUser" src="<?PHP echo base_url();?>assets/img/Logo-Visys-blanco.png" width="65%" >
            <div id="user">
                <i class=" material-icons" >face</i>
                <span class="Loggen"><?php echo $this->session->userdata('UserN');?></span>
            </div>
        </header>
       <div id="menu">
           <ul class="nav menu demo-navigation mdl-navigation__link" >
               <li><i class="material-icons">home</i><a href="Main">inicio</a></li>
               <li><i class="material-icons">remove_circle</i> <a href="EliminarVineta" >eliminar viñeta</a> </li>
               <li><i class="material-icons">supervisor_account</i><a href="Clientes" > clientes</a> </li>
               <li><img src="<?PHP echo base_url()?>assets/img/bajacliente.png" width="30px"><a href="BajaClientes" > baja clientes</a> </li>
               <li><i class="material-icons">content_copy</i><a href="PuntosClientes" > puntos clientes</a> </li>
               <li><i class="material-icons">payment</i><a href="Frp" > canje puntos (frp)</a> </li>
               <li><i class="material-icons">payment</i><a href="FRE" > canje efectivo (fre)</a> </li>
               <li><i class="material-icons">dashboard</i> <a href="Catalogo" >catálogo</a> </li>
               <li><i class="material-icons">account_box</i><a href="Usuarios" > usuarios</a> </li>
               <li><i class="material-icons">description</i><a href="Reportes" > reportes</a> </li>
               <li><i class="material-icons">exit_to_app</i><a href="salir"> cerrar sesión</a> </li>
          </ul>
       </div>

    </div>

