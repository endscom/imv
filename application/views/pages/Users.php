<header class="demo-header mdl-layout__header ">
    <div class="centrado  ColorHeader">
        <span class=" title">usuarios</span>
    </div>
</header>

<!--//////////////////////////////////////////////////////////
                CONTENIDO
///////////////////////////////////////////////////////////-->
<main class="mdl-layout__content mdl-color--grey-100">
    <div class="contenedor">
        <div class="center row TextColor">
               usuarios sistema de puntos
        </div>
        <div class="container">
            <div class="Buscar row column">
                <div class="col s1 m1 l1 offset-s3 offset-l3">
                    <i class="material-icons ColorS">search</i>
                </div>
                <div class="input-field col s6 m6 l4">
                    <input  id="searchUsuarios" type="text" placeholder="Buscar" class="validate">
                    <label for="searchUsuarios"></label>
                </div>
            </div>
        </div>
        <div class="right row">
                <a href="#AUsuario" class="BtnBlue waves-effect  btn modal-trigger ">AGREGAR</a>
        </div>
        <table id="TbCatalogo" class="TblDatos center">
            <thead>
            <tr>
                <th>FECHA CREACIÓN</th>
                <th>CÓDIGO</th>
                <th>USUARIO</th>
                <th>ESTADO</th>
                <th>ACCIÓN</th>
            </tr>
            </thead>
            <tbody>
                <?PHP
                    if(!($Luser)){}
                    else{
                        foreach($Luser as $user )
                        {
                            $Mmensaje = "CAMBIAR A INACTIVO";
                            $Micono="highlight_off";
                            $MColor="#6a4ad5";
                            $mIcono = "#ff0000";
                            $activo='Activo';
                            if($user['Estado']==1)
                            {
                                $activo='Inactivo';
                                $MColor="#ff0000";
                                $Micono="done_all";
                                $Mmensaje = "CAMBIAR A ACTIVO";
                                $mIcono = "#4caf50";
                            }

                            echo "
                                 <tr>
                                    <td>".date('d/m/Y',strtotime(substr($user['FechaCreacion'], 0,10)))."</td>
                                    <td>".$user['IdUsuario']."</td>
                                    <td class='negra'><a href='#' class=''>".$user['Nombre']."</td></a>
                                    <td id='activo' style='color:".$MColor."'>".$activo."</td>
                                    <td><a data-tooltip='$Mmensaje' class='btn-flat tooltipped' onclick='DellUsers(".'"'.$user['IdUsuario'].'",'.'"'.$user['Estado'].'"'.")'><i style='color:".$mIcono."' class=' material-icons'>$Micono</i></td></a>
                                 </tr>
                            ";
                        }
                    }
                ?>
            </tbody>
        </table>
    </div>
   </main>
<!--/////////////////////////////////////////////////////////////////////////////////////////
                                        MODALES
//////////////////////////////////////////////////////////////////////////////////////////-->
<!-- AGREGAR USUARIO -->
<div id="AUsuario" class="modal">
    <div class="modal-content">
        <div class="btnCerrar right"><i style='color:red;' class="material-icons modal-action modal-close">highlight_off</i></div>

        <div class="row TextColor center">
            AGREGAR USUARIO VISYS
        </div>
        <div class="row">
            <form class="col s12"  method="post" name="formAddUser">
                <div class="row">
                    <div class="input-field col s6">
                        <input name="user" placeholder="Nombre de Usuario" id="NombreUser" type="text" class="required">
                        <label id="labelNombre" class="labelValidacion">DIGITE EL NOMBRE</label>
                    </div>

                    <div class="input-field col s6">
                        <input name="pass" placeholder="Contraseña" id="Contra" type="password" class="validate">
                        <label id="labelPass" class="labelValidacion">DIGITE LA CONTRASEÑA</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s6">
                        <select name="rol" id="rol" class="chosen-select browser-default">
                            <option value="" disabled selected>SELECCIONE PERMISOS</option>
                            <?PHP
                                if(!($Lrol)){
                                } else {
                                     foreach($Lrol as $rol) {
                                          echo '<option class="mayuscula" value="'.$rol['Descripcion'].'">'.$rol['Descripcion'].'</option>';
                                     }
                                 }
                            ?>
                        </select><label id="labelRol" class="labelValidacion">SELECCIONE UN ROL</label>
                    </div>
                    <div class="input-field col s6">
                        <select name="vendedor" id="vendedorid" class="chosen-select browser-default">
                            <option value="" disabled selected>SELECCIONE VENDEDOR</option>
                            <?PHP
                                if(!($Lven)){
                                } else {
                                     foreach($Lven as $rol){
                                          echo '<option value="'.$rol['IdVendedor'].'">'.$rol['Nombre'].'</option>';
                                     }
                                 }
                            ?>
                        </select>
                        <label id="labelVendedor" class="labelValidacion">SELECCIONE UN VENDEDOR</label>
                    </div>
                </div>
                <div class="row" id="divOculto" style="display:none;">
                    <div class="input-field col s12 m6 l6">
                        <select id="ListCliente" name="ListCliente" class="chosen-select browser-default">
                        <option value="" disabled selected>SELECCIONE CLIENTE</option>
                        <?php
                            if(!$data){
                            } else {
                                foreach($data as $premio){
                                    echo '<option value="'.$premio['CLIENTE'].'">'.$premio['NOMBRE'].'</option>';
                                }
                            }
                         ?>
                    </select>
                    <label id="labelCliente" class="labelValidacion">SELECCIONE EL CLIENTE</label>
                    </div>
                </div>
                <div class="row center">
                    <div class="progress" style="display:none">
                          <div class="indeterminate violet"></div>
                    </div>
                        <a  class="Btnadd btn" id="Adduser"  onclick="EnviodeDatos()">GENERAR</a>
                </div>
            </form>
        </div>
    </div><!-- FIN DEL CONTENIDO DEL MODAL -->
</div>
<!-- MODAL cambio de estado de usuario -->
<!-- Modal Structure -->
<div id="CsUser" class="modal">
    <div class="modal-content">

        <div class=" row">
            <div class="col s12 m12 l12">
                <p id="TxtObser" class="center Mcolor"></p>
            </div>
        </div>
        <div class="row">
            <div class="col s1 m1 l1 offset-s1 offset-m4 offset-l4">
                <a href="#" id="DellUsers" class=" modal-action modal-close ">
                    <i class="material-icons">done_all</i>
                </a>
            </div>

            <div class="col s1 m1 l1 offset-s1 offset-m1 offset-l4">
                <a href="#!" class=" BtnClose modal-action modal-close ">
                    <i class="material-icons">highlight_off</i>
                </a>
            </div>
        </div>
    </div>
</div>
<!-- MODAL DETALLES USUARIO -->
<!-- Modal Structure -->
<div id="Duser" class="modal">
    <div class="modal-content">
        <div class="btnCerrar right"><i style='color:red;' class="material-icons modal-action modal-close">highlight_off</i></div>
        <h6 class="center Mcolor AdUser">INFORMACIÓN DEL CLIENTE</h6>
        <p class="center datos1 cod "> COD. CLIENTE: 00449</p>
        <h6  class="center datos1 user linea">00449 FARMACIA CASTELLÓN</h6>
        <p class="center datos1 ruc linea"> RUC 4412000183001H</p>
        <p id="acumulado" class="center Datos">ACUMULADO: <span id="AcuT">250,000</span>  Pts.</p>
        <div class="row">
            <div class="col s3 m2 l3 offset-l2">
                <p id="ModalFeet"  class="datos1 "> VENDEDOR: <br> Esperanza Castillo</p>
            </div>
            <div class="col s3 m2 l3 offset-l3">
                <p id="ModalFeet"  class="datos1"> ZONA: <br>F14</p>
            </div>
        </div>
    </div><!-- fin del contenido del modal -->
</div>
