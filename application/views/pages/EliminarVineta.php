<header class="demo-header mdl-layout__header ">
    <div class="centrado  ColorHeader">

        <span class=" title">ELIMINAR VIÑETA</span>

    </div>
</header>

<!--//////////////////////////////////////////////////////////
                CONTENIDO
///////////////////////////////////////////////////////////-->
<main class="mdl-layout__content mdl-color--grey-100">
    <div class="contenedor ">

       <div class="container">
           <div id="buscar" class=" row column">
               <div class="col s1 m1 l1 offset-s3  offset-l2">
                   <i class="material-icons ColorS">search</i>
               </div>
               <div id="InputSearch" class="input-field col s6 m16 l5">
                   <input  id="search" type="text" placeholder="Buscar Facturas o Viñetas" class="validate">
                   <label for="search"></label>
               </div>
           </div>
       </div>


        <div class="datos">
            <div class="row text">
                <div class="col s4 m4 l4">
                    <p>CÓDIGO: <span class="Datos">55555</span></p>
                </div>
                <div class="col s4 m4 l4">
                    <p>FACTURA: <span class="Datos">55555</span></p>
                </div>
                <div class="col s4 m4 l4">
                    <p>FECHA: <span class="Datos">55555</span></p>
                </div>
            </div>

            <div class="row text">
                <div class="col s8 m8 l8">
                    <p>CLIENTE: <span class="Datos">55555 55555 555555 55555555555555</span></p>
                </div>
                <div class="col s4 m4 l4">
                    <p>RUC: <span class="Datos">55555</span></p>
                </div>
            </div>

            <div class="right row">
                    <a href="#modal1" class="BtnEliminar waves-effect  btn modal-trigger">ELIMINAR</a>
            </div>
<!--//////////////////////////////////////////////////////////////////////////////////
                                TABLA
///////////////////////////////////////////////////////////////////////////////////-->
                    <table id="tblEliminar" class="TblDatos">
                        <thead>
                        <tr>
                            <th>CANT.</th>
                            <th>DESCRIPCIÓN</th>
                            <th>LABORATORIO</th>
                            <th>PUNTOS</th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr>
                            <td>xxxx</td>
                            <td>xxx xxxx xxxx</td>
                            <td>xxx</td>
                            <td>100000 pts</td>
                        </tr>

                        <tr>
                            <td>xxxx</td>
                            <td>xxx xxxx xxxx</td>
                            <td>xxx</td>
                            <td>100000 pts</td>
                        </tr>

                        <tr>
                            <td>xxxx</td>
                            <td>xxx xxxx xxxx</td>
                            <td>xxx</td>
                            <td>100000 pts</td>
                        </tr>
                        <tr>
                            <td>xxxx</td>
                            <td>xxx xxxx xxxx</td>
                            <td>xxx</td>
                            <td>100000 pts</td>
                        </tr>
                        <tr>
                            <td>xxxx</td>
                            <td>xxx xxxx xxxx</td>
                            <td>xxx</td>
                            <td>100000 pts</td>
                        </tr>
                        <tr>
                            <td>xxxx</td>
                            <td>xxx xxxx xxxx</td>
                            <td>xxx</td>
                            <td>100000 pts</td>
                        </tr>
                        </tbody>
                    </table>


        </div><!-- div Datos-->
        <div class="right row">
            <div class="col s12 m12 l12">
                <p class="TextTotal">Total Pts.Cliente: <span>325,766 Pts.</span> </p>
            </div>
        </div>

        </div><!-- fin de Contenedor-->


    </div>
</main>


<!-- MODALES-->

<!-- Modal#1 Structure  muestra los datos a eliminar-->
<div id="modal1" class="modal">
    <div class="modal-content">

        <div class=" row">
            <div class="right col s1 m1 l1">
                <a href="#!" class=" BtnClose modal-action modal-close ">
                    <i class="material-icons">highlight_off</i>
                </a>
            </div>
        </div>

        <h6  class="center Mcolor">DESEA ELIMINAR LAS VIÑETAS:</h6>

<!--///////////////////////////////////////////////////////////
                        TABLA MODAL
////////////////////////////////////////////////////////////-->

        <div class="row">
            <div class="col s12">

                <table id="tblModal1" class="TheadColor">

                    <thead>
                    <tr>
                        <th>CANT.</th>
                        <th>DESCRIPCIÓN</th>
                        <th>LAB.</th>
                        <th>PUNTOS</th>
                        <th>ELIMINAR</th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr>
                        <td>7</td>
                        <td>xxxxxxxxxxxxxxxxxxxxxxx</td>
                        <td>LUNAN</td>
                        <td>70 pts</td>
                        <td>
                            <i class=" BtnClose material-icons">highlight_off</i>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>


    </div>

    <div class="row">
        <div class="col s6">
            <a href="#modal2" class="Btndell modal-action modal-close btn modal-trigger">ELIMINAR</a>
        </div>
    </div>

</div>
<!-- Fin de Modal#1-->

<!--///////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////-->

<!-- Modal #2-->
<!-- Modal Structure -->
<div id="modal2" class="modal">
    <div class="modal-content">

            <div class="right row">
                <div class="col s1 m1 l1">
                    <a href="#!" class=" BtnClose modal-action modal-close ">
                        <i class="material-icons">highlight_off</i>
                    </a>
                </div>
            </div>

            <h6 class="center Mcolor1">LAS VIÑETAS FUERON ELIMINADAS</h6>

        </div>
</div>