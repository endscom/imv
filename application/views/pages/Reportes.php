<header class="demo-header mdl-layout__header ">
    <div class="centrado  ColorHeader">

        <span class=" title">reportes</span>
        
    </div>
</header>
<!--//////////////////////////////////////////////////////////
                CONTENIDO
///////////////////////////////////////////////////////////-->
<main class="mdl-layout__content mdl-color--grey-100">

    <div class="contenedor">

        <div  id="contenedor" class="container">

            <div class="row">
                <div class="col s3 m3 l2">
                    <a href="#cuentaXcliente" class=" IconBlue modal-action modal-close modal-trigger ">
                        <i class="medium material-icons iconoCenter">local_library</i>
                        <p class="TextIconos">CUENTA POR CLIENTE</p>
                    </a>
                </div>
                <div class="col s3 m3 l2 offset-l1">
                    <a href="#" onclick="FiltrarReporte('MASTER DE CLIENTES','masterClientes')" class=" IconBlue">
                        <i class="medium material-icons iconoCenter ">supervisor_account</i>
                        <p class="TextIconos">MASTER CLIENTES</p>
                    </a>
                </div>
                <div class="col s3 m3 l3 offset-l1">
                    <a href="#" onclick="FiltrarReporte('CLIENTES NUEVOS','clientes_nuevos')" class=" IconBlue ">
                        <i class="medium material-icons iconoCenter">person_add</i>
                        <p class="TextIconos">CLIENTES NUEVOS</p>
                    </a>
                </div>
                <div class="col s3 m3 l3">
                    <a href="#" class=" IconBlue">
                        <a href="#" onclick="FiltrarReporte('PUNTOS POR CLIENTE','puntosXcliente')" class=" IconBlue ">
                        <i class="medium material-icons iconoCenter">perm_identity</i>
                        <p class="TextIconos">PUNTOS POR CLIENTE</p>
                    </a>
                    
                </div>
            </div>

            <div class="row">
                <div class="col s3 m3 l2">
                    <a href="#" onclick="FiltrarReporte('CANJES','canjes')" class=" IconBlue ">
                        <i class="medium material-icons iconoCenter">timeline</i>
                        <p class="TextIconos">CANJES</p>
                    </a>
                </div>
                <div class="col s3 m3 l2 offset-l1">
                    <a href="#" onclick="FiltrarReporte('DETALLES DE CANJES','detalles_canje')" class=" IconBlue ">
                        <i class="medium material-icons iconoCenter">view_list</i>
                        <p class="TextIconos">DETALLES DE CANJE</p>
                    </a>                    
                </div>
                <div class="col s3 m3 l3 offset-l1">
                    <a href="#" onclick="FiltrarReporte('CANJE DE PREMIOS','canje_premios')" class=" IconBlue">
                        <i class="medium material-icons iconoCenter">add_shopping_cart</i>
                        <p class="TextIconos">CANJE DE PREMIOS</p>
                    </a>
                </div>
                <div class="col s3 m3 l3">
                    <a href="#" onclick="FiltrarReporte('MASTER DE FACTURAS','masterFacturas')" class=" IconBlue ">
                        <i class="medium material-icons iconoCenter">monetization_on</i>
                        <p class="TextIconos">MASTER DE FACTURAS</p>
                    </a>
                </div>
            </div>
            
            <div class="row">
                <div class="col s3 m3 l2">
                    <a href="#" onclick="FiltrarReporte('MASTER COMPRAS POR PRODUCTOS','masterCompras')" class=" IconBlue">
                        <i class="medium material-icons iconoCenter">shopping_cart</i>
                        <p class="TextIconos">MASTER COMPRAS POR PRODUCTOS</p>
                    </a>
                </div>
                <div class="col s3 m3 l2 offset-l1">
                    <a href="#" onclick="FiltrarReporte('MOVIMIENTO DE PRODUCTOS','movimientoProductos')" class=" IconBlue ">
                        <i class="medium material-icons iconoCenter">multiline_chart</i>
                        <p class="TextIconos">MOVIMIENTO DE PRODUCTOS</p>
                    </a>
                </div>
                <div class="col s3 m3 l3 offset-l1">
                    <a href="#" onclick="FiltrarReporte('REPORTE POR FECHA','reporteXfecha')" class=" IconBlue ">
                        <i class="medium material-icons iconoCenter">event_note</i>
                        <p class="TextIconos">REPORTE POR FECHA</p>
                    </a>
                </div>
                <div class="col s3 m3 l3">
                    <a href="#" class=" IconBlue">
                        <a href="#informeFactura" class=" IconBlue modal-action modal-close modal-trigger">
                        <i class="medium material-icons iconoCenter">receipt</i>
                        <p class="TextIconos">INFORME DE FACTURAS</p>
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col s3 m3 l2">
                    <a href="#" class=" IconBlue">
                        <a href="#" onclick="FiltrarReporte('10 MÁS VENDIDOS','mas_vendidos')" class=" IconBlue ">
                        <i class="medium material-icons iconoCenter">thumb_up</i>
                        <p class="TextIconos">TOP 10 MÁS VENDIDOS</p>
                    </a>
                </div>
                <div class="col s3 m3 l2 offset-l1">
                    <a href="#" class=" IconBlue">
                        <a href="#" onclick="FiltrarReporte('10 MENOS VENDIDOS','menos_vendidos')" class=" IconBlue ">
                        <i class="medium material-icons iconoCenter">thumb_down</i>
                        <p class="TextIconos">TOP 10 MENOS VENDIDOS</p>
                    </a>
                </div>
            </div>
    </div>
</main>

<!--///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                                            MODALES DE REPORTES
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

<!--///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                                            Modal Cuenta por Cliente
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
<!-- Modal Cuenta por Cliente -->
<div id="cuentaXcliente" class="modal">
    <div class="modal-content">
        <div class="right row">
                <a href="#!" class=" BtnClose modal-action modal-close ">
                    <i class="material-icons">highlight_off</i>
                </a>
        </div>

        <h6 class="center Mcolor AdUser">CUENTA POR CLIENTE</h6>

        <div class="row">
            <form class="col s12" action=""method="post" name="formnuevo">

                <div class="row">
                    <select name="cliente" id="ListCliente" class="chosen-select browser-default">
                    <option value="" disabled selected>CLIENTE</option>
                    <?php
                        if(!$data){}
                        else{
                                foreach($data as $cliente){
                                    echo '<option value="'.$cliente['CLIENTE'].'">'.$cliente['CLIENTE'].' | '.$cliente['NOMBRE'].'</option>';
                            }
                        }
                    ?>
                </select>
                </div>

                <div class="row">
                    <div class="input-field col s6">
                        <input name="fecha1" placeholder="Desde" id="CXCfecha1" type="text" class="datepicker1">
                    </div>
                    <div class="input-field col s6">
                        <input name="fecha2" placeholder="Hasta" id="CXCfecha2" type="text" class="datepicker1">

                    </div>
                </div>
            </form>
        </div>
        <div class="row center">
                <a id="generarCtaXcte" href="#" class="Btnadd btn">GENERAR</a>
        </div>
    </div><!-- fin del contenido modal -->
</div>
<!-- FIN DE MODAL CUENTA POR CLIENTE -->

<!-- Modal Cuenta por Cliente -->
<div id="informeFactura" class="modal">
    <div class="modal-content">
        <div class="right row">
                <a href="#!" class=" BtnClose modal-action modal-close ">
                    <i class="material-icons">highlight_off</i>
                </a>
        </div>

        <h6 class="center Mcolor AdUser">INFORME DE FACTURA</h6>

        <div class="row">
            <form class="col s12" action=""method="post" name="formnuevo">

                <div class="row">
                    <select name="cliente" id="ListFact" class="chosen-select browser-default">
                    <option value="" disabled selected>SELECCIONE FACTURA</option>
                    <?php
                        if(!$query){}
                        else{
                                for ($i=0; $i < count($query); $i++) { 
                                    echo '<option value="'.$query[$i]['FACTURA'].'">'.$query[$i]['FACTURA'].'</option>';
                            }
                        }
                    ?>
                </select>
                </div>
            </form>
        </div>
        <div class="row center">
                <a id="geninformeFactura"  href="#" class="Btnadd btn">GENERAR</a>
        </div>
    </div><!-- fin del contenido modal -->
</div>
<!-- FIN DE MODAL CUENTA POR CLIENTE -->

<!-- MODAL DETALLES CUENTA POR CLIENTE -->
<div id="CtaXcte" class="modal">
    <div class="modal-content">
        <div class="right row">
                <a href="#!" class=" BtnClose modal-action modal-close ">
                    <i class="material-icons">highlight_off</i>
                </a>
        </div>
        <!-- LOGO SISTEMA DE VISYS -->
        <center><img src="<?PHP echo base_url(); ?>assets/img/logo_sp.png" width="30%"></center>

        <h6 class="center Mcolor AdUser">CUENTA POR CLIENTE</h6>

      <p class="frpT pts">DATOS DEL CLIENTE</p>

        <div class="row">
        <form name="CXCexcel" id="CXCexcel" action="<?php echo base_url('index.php/excelCTAxCLIENTE')?>" target="_blank" method="post">
            <div class="col s5 m3 l6">
                <input name="CXCcodigo" id="CXCdetalleCodigo" readonly class="Mcolor cod left" type="text" value="asdfdsfs">
                <!--<p id="CXCdetalleCodigo" class="Mcolor cod"></p><-->
                <br>
                <p id="CXCdetalleRUC" class="detalles linea"></p><br>
                <p id="CXCdetalleDIR" class="detalles linea"></p>
            </div>
            <div class="col s3 m4 l3">
                <!--<p id="CXCdetallefecha1" class="fecha"></p>-->
                <input name="CXCf1" readonly class="fecha" id="CXCdetallefecha1" type="text">
                <p class="rango">Desde</p>
            </div>
            <div class="col s3 m4 l3">
                <!--<p id="CXCdetallefecha2" class="fecha"></p>-->
                <input name="CXCf2" readonly class="fecha" id="CXCdetallefecha2" type="text">
                <p class="rango">Hasta</p>
            </div>
        </form>
        </div>
        <!-- TOTAL DE PUNTOS DEL CLIENTE -->
        <div id="Total" class="right row text">
            <div class="col s8 m8 l12">
                <p class="Dato">TOTAL DE PUNTOS: <span id="CXCdetalleTotal" class="dato"></span></p>
            </div>
        </div>
        <!-- TABLA DE DETALLES -->
            <table id="tblcuentaXcliente" class=" TblDatos">
                <thead>
                <tr>
                    <th>FACTURA</th>
                    <th>FECHA</th>
                    <th>PUNTOS X FACTURA</th>
                    <th>PUNTOS APLICADOS</th>
                    <th>PUNTOS DISPONIBLES</th>
                </tr>
                </thead>
                <tbody class="center">
                </tbody>
            </table>

        <div id="Iconos" class="row center">
            <div class="col l1 offset-s4 offset-m4 offset-l4">
                <a href="#" onclick="generarExcel('CXCexcel')" ><img src="<?PHP echo base_url();?>assets/img/icono_excel.png" width="38px" ></a>
            </div>
            <div class="col l1">
                <a class="noHover" href="#" onclick="PrintPDF('CXCprint')"><img src="<?PHP echo base_url();?>assets/img/ico_imprimir.png " width="45px" ></a>
            </div>
            <div class="col l1">
                <a href="#" onclick="PrintPDF(cuentaXcliente)"><img src="<?PHP echo base_url();?>assets/img/icono-pdf.png" width="38px" ></a>
            </div>
        </div>

    </div>
</div>
<!--///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                                        FIN MODAL DETALLE DE CUENTA POR CLIENTE
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
<!--///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                                        MODAL FILTRADO DE FECHAS OTROS REPORTES
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
<div id="modalFiltrado" class="modal">
    <div class="modal-content">
        <div class="right row">
                <a href="#!" class=" BtnClose modal-action modal-close ">
                    <i class="material-icons">highlight_off</i>
                </a>
        </div>

        <h6 id="tituloFiltrado" class="center Mcolor AdUser"></h6>

        <div class="row">
            <form class="col s12" action=""method="post" name="formSP">

                <div class="row">
                    <div class="input-field col s6">
                        <input name="fecha1" placeholder="Desde" id="fecha1" type="text" class="datepicker1">
                    </div>
                    <div class="input-field col s6">
                        <input name="fecha2" placeholder="Hasta" id="fecha2" type="text" class="datepicker1">

                    </div>
                </div>
            </form>
        </div>
        <div class="row center">
                <a href="#" id="generarDetalleReporte" class="Btnadd btn">GENERAR</a>
        </div>
    </div><!-- FIN CONTENIDO MODAL -->
</div>
<!--///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                                            MODAL DE DETALLES DE REPORTE
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
<!-- Detalles del Master de Clientes SP -->

<div id="SPdet" class="modal">
    <div class="modal-content">
        <div class="right row">
                <a href="#!" class=" BtnClose modal-action modal-close ">
                    <i class="material-icons">highlight_off</i>
                </a>
        </div>
        <center><img src="<?PHP echo base_url(); ?>assets/img/logo_sp.png" width="20%"></center>
        <h6 id="tituloFiltrado2" class="center Mcolor AdUser">MASTER CLIENTES SP</h6>

        <div class="row noMargen">
            <div class="col s5 m4 l3 offset-l3 offset-m3 offset-s1">
                <p id="f1Detail" class="fecha"></p>
                <p class="rango">Desde</p>
            </div>
            <div class="col s5 m4 l3">
                <p id="f2Detail" class="fecha"></p>
                <p class="rango">Hasta</p>
            </div>
        </div>
        <div class="noMargen Buscar row column">
            <div class="col s1 m1 l1 offset-l3 offset-s1 offset-m2">
                <i class="material-icons ColorS">search</i>
            </div>

            <div class="input-field col s9 m7 l4">
                <input  id="searchReporte" type="text" placeholder="Buscar" class="validate">
                <label for="searchReporte"></label>
            </div>
        </div>
        <div id="Total2" class="right row text noMargen" style="display:none;">
            <div class="col s8 m8 l12">
                <p class="Dato">TOTAL DE PUNTOS: <span id="spanTotal" class="dato"></span></p>
            </div>
        </div>
        <div id="loadIMG" style="display:none" class="progress">
            <div class="indeterminate"></div>
        </div>
        <div class="row" id="miTablaReportes">
            
            <table id="tblDetalleReportes" class="TblDatos">
               <thead><tr></tr></thead>
            </table>
        </div>
    </div><!-- Fin Contenido Modal -->
</div>

<!--///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                                        Fin Modal Master Cuenta SP
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

<div id="informeDetalle" class="modal">
    <div class="modal-content">
        <div class="right row">
                <a href="#!" class=" BtnClose modal-action modal-close ">
                    <i class="material-icons">highlight_off</i>
                </a>
        </div>
        <!-- LOGO SISTEMA DE VISYS -->
        <center><img src="<?PHP echo base_url(); ?>assets/img/logo_sp.png" width="30%"></center>

        <h6 class="center Mcolor AdUser">INFORME DE FACTURA</h6>
        <!-- TABLA DE DETALLES -->
            <table id="tblInformeFactura" class=" TblDatos">
                <thead>
                <tr>
                    <th>FACTURA</th>
                    <th>COD. CLIENTE</th>
                    <th>FECHA FRP</th>
                    <th>CODIGO FRP</th>
                    <th>ACUMULADO X FACTURA</th>
                    <th>PUNTOS APLICADOS</th>
                    <th>FRP</th>
                </tr>
                </thead>
                <tbody class="center">
                </tbody>
            </table>
    </div>
</div>