<header class="demo-header mdl-layout__header ">
    <div class="centrado  ColorHeader">
        <span class=" title">BAJA CLIENTES</span>
    </div>
</header>

<main class="mdl-layout__content mdl-color--grey-100">
    <div class="contenedor">

        <div class=" row TextColor center">
                DAR BAJA A LOS CLIENTES
        </div>
        <div class="container">
            <div class=" Buscar row column">
                <div class="col s1 m1 l1 offset-l3 offset-m3">
                    <i class="material-icons ColorS">search</i>
                </div>
                <div class="input-field col s11 m5 l5">
                    <input  id="search" type="text" placeholder="Buscar" class="validate">
                    <label for="search"></label>
                </div>
            </div>
        </div>

        <div class="right row">
                <a href="#" id="btnCargarBajas" class="BtnEliminar waves-effect  btn">DAR DE BAJA</a>
        </div>
                
        <table id="ClienteAdd" class="TblDatos">
            <thead>
            <tr>
                <th>CÓDIGO</th>
                <th>CLIENTE</th>
                <th>RUC</th>
            </tr>
            </thead>
            <tbody>
                <?php
                if(!($query)){
                    echo "fallo la carga de los datos";
                }
                else{
                    $i=0;
                    foreach($query AS $cliente)
                    {
                        echo "<tr>
                                   <td class='center'>".$query[$i]['CLIENTE']."</td>
                                   <td id='NomCliente'>".$query[$i]['NOMBRE']."</td>
                                   <td class='center'>".$query[$i]['RUC']."</td>
                              </tr>";
                        $i++;
                    }
                }
                ?>
            </tbody>

        </table>

    </div><!-- Fin Contenedor -->
</main>
<!--///////////////////////////////////////////////////////////////////////
                        MODALES
/////////////////////////////////////////////////////////////////////////-->
<!-- Modal Structure -->
<div id="modal1" class="modal">
    <div class="modal-content">

        <div class=" row">

            <div class="right col s3 m3 l3">
                <a href="#!" class=" BtnClose modal-action modal-close ">
                    <i class="material-icons">highlight_off</i>
                </a>
            </div>
        </div>
        <div class=" row valign-wrapper">
            <div class="col s12 m4 l4">
                <h6 class="center Mcolor">DESEA DAR DE BAJA:</h6>
            </div>
            <div class="col offset-l6 s3 m3 l3">
                <a href="#" id="btneliminarBajas"  class="BtnBlue waves-effect  btn">ELIMINAR</a>
            </div>
        </div>
        
        <div class="row center">
            <div id="loadIMG" style="display:none" class="preloader-wrapper big active">
                    <div class="spinner-layer spinner-blue-only">
                        <div class="circle-clipper left"><div class="circle"></div></div>
                            <div class="gap-patch"><div class="circle"></div></div>
                        <div class="circle-clipper right"><div class="circle"></div></div>
                    </div>
                </div>
            <div class="col s12">
                <table id="tblModal1" class="">
                    <thead>
                    <tr>
                        <th>COD. UNIMARK.</th>
                        <th>CLIENTE</th>
                        <th>USUARIO VISYS</th>
                    </tr>
                    </thead>

                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row center">
            <a href="#" id="btnDarBaja" class="Btnadd btn ">DAR BAJA</a>
    </div>

</div>
<!--///////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////-->
