<header class="demo-header mdl-layout__header ">
    <div class="centrado  ColorHeader">

        <span class=" title">fre</span>

    </div>
</header>
<!--//////////////////////////////////////////////////////////
                CONTENIDO
///////////////////////////////////////////////////////////-->

<main class="mdl-layout__content mdl-color--grey-100">

    <div class="contenedor">
        <div class="row center TextColor">
               canje por efectivo
        </div>

        <div class="container">
            <div class=" Buscar row column">
                <div class="col s1 m1 l1 offset-l3 offset-s1 offset-m2">
                    <i class="material-icons ColorS">search</i>
                </div>

                <div class="input-field col s5 m4 l4">
                    <input  id="searchFRE" type="text" placeholder="Buscar" class="validate">
                    <label for="searchFRE"></label>
                </div>
            </div>
        </div>        

        <div class="right row">
            <a href="#modalEfec" class="BtnBlue waves-effect  btn modal-trigger">efectivo</a>
        </div>

        <table id="tblFRE" class=" TblDatos">

            <thead>
            <tr>
                <th>FECHA</th>
                <th>FRE #</th>
                <th>COD. CLIENTE</th>
                <th>NOMBRE</th>
                <th>PUNTOS</th>
                <th>EFECTIVO</th>
                <th>ELIMINAR</th>
            </tr>
            </thead>
            <tbody class="center">
                <?php 
                    if (!($fre)) {}
                    else{
                        foreach ($fre as $key ) {
                            if ($key['Anulado'] == "S"){
                                $clase="tachado";
                                $delete="";
                            } else {
                                $clase="";
                                $delete = "<a  onclick='dellFrp(".$key['IdFRE'].")' href='#' class='Icono noHover'><i class='material-icons'>highlight_off</i></a>";
                            }
                            echo "<tr>
                                    <td class='".$clase."'>".date('d-m-Y', strtotime($key['Fecha']))."</td>
                                    <td class='negra ".$clase."'>".$key['IdFRE']."</td>
                                    <td class='".$clase."'>".$key['IdCliente']."</td>
                                    <td class='negra ".$clase."'>".$key['Nombre']."</td>
                                    <td class='".$clase."'>".$key['Puntos']."</td>
                                    <td class='".$clase."'>".$key['Efectivo']."</td>
                                    <td class='center'>
                                    <a  onclick='getview(".'"'.$key['IdFRE'].'"'.")' href='#' class='noHover'><i class='material-icons'>&#xE417;</i></a>
                                    ".$delete."
                                </td>
                            </tr>";
                        }
                    }
                ?>
            </tbody>

        </table>
    </div>
</main>


<!--////////////////////////////////////////////////////////////////////////////////////////////////////////
                                    MODAL PRINCIPAL
/////////////////////////////////////////////////////////////////////////////////////////////////////////-->
<!-- Modal #1
                Modal Structure -->
<div id="modalEfec" class="modal">
    <div class="modal-content">
        <div class="right row">
                <a href="#!" class=" BtnClose modal-action modal-close ">
                    <i class="material-icons">highlight_off</i>
                </a>
        </div>

        <h6 class="center Mcolor">FORMATO DE REMISIÓN DE EFECTIVO</h6>

        <div class="row noMargen valign-wrapper">
            <div class="DatoFrp input-field line col s3 m3 l3">
                 N° FRE:<input id="frp" class="frp" type="text" readonly class="validate">
            </div>

            <div class="DatoFrp line col s3 m3 l3 offset-l7 offset-s4 offset-m4">
                FECHA:<input type="text" id="date1" class="datepicker1"><br>
            </div>
        </div>

        <div class="row ">
            <div class=" DatoFrp line input-field col s3 m3 l3">
                COD. CLIENTE:<input id="txtCodCliente" type="text" class="validate frp">
            </div>

            <div class="input-field col s7 m7 l7"  >
                <select class="center chosen-select browser-default" name="cliente" id="ListCliente">
                    <option value="" disabled selected>CLIENTE</option>
                    <?php
                        if(!$data){}
                        else{
                                foreach($data as $cliente){
                                    echo '<option value="'.$cliente['CLIENTE'].'">'.$cliente['NOMBRE'].'| '.$cliente['CLIENTE'].'</option>';
                                //echo '<option value="'.$cliente['CLIENTE'].'">'.$cliente['NOMBRE'].'</option>';
                            }
                        }
                    ?>
                </select>
            </div>

            <div class="input-field col s12 m2 l2 DatoFrp valign-wrapper">
                PUNTOS:
                <input  id="PtosDisponibles" type="text" class="validate frp">
            </div>
        </div>        
    <div id= "moroso" class="row">
        <table id="tblFacturaFRE" class=" TblDatos">
            <thead>
            <tr>
                <th>FECHA</th>
                <th># FATURA</th>
                <th>PUNTOS</th>
                <th>PUNTOS A EFECTIVO</th>
                <th><i class="material-icons">check</i></th>
            </tr>
            </thead>

            <tbody class="center mayuscula">            
            </tbody>
        </table>
    </div>
        <div id="Total" class="right row text">
            <div class="col s11 m12 l12">
                <p class="Dato">TOTAL EFECTIVO: <span class="dato">C$ </span><span id="totalEfectivo" class="dato">0</span></p>
            </div>

        </div>
        <div class="row">
            <form class="col s12">
                <div class="row">
                    <div class="input-field col s12">
                        <p class="Datos">OBSERVACIONES</p>
                        <textarea id="observaciones" class="materialize-textarea observaciones"></textarea>
                    </div>
                </div>
            </form>
        </div>
        <div class="center row">
            <a href="#btnProcesar" onclick="procesar()" class="Procesar waves-effect btn">procesar</a>
        </div>
    </div>

</div>
<!-- FIN MODAL -->
<!--/////////////////////////////////////////////////////////////////////////////////////////////////////////////
                                        MODAL DETALLE FRE
//////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

<!-- Modal #4
                Modal Structure -->
<div id="Dfre" class="modal">
    <div class="modal-content">

        <div class="right row">
                <a href="#!" class=" BtnClose modal-action modal-close ">
                    <i class="material-icons">highlight_off</i>
                </a>
        </div>
         <div class="row center " id="frpProgress">
            <div class="preloader-wrapper big active">
                <div class="spinner-layer spinner-blue-only">
                    <div class="circle-clipper left"><div class="circle"></div></div>
                        <div class="gap-patch"><div class="circle"></div></div>
                    <div class="circle-clipper right"><div class="circle"></div></div>
                </div>
            </div>
        </div>
        <div id="cargando">
            <div class="col s12 center">
                <span class="datos1 lineas" id="cargandoLT">CARGANDO</span>
            </div>
        </div>

        <div id="vfrpTop" class="row center">
            <div class="center col s12 m12 l12">
                <h6 class="Mcolor noMargen">DETALLE FRE</h6>
            </div>
            <div class="col s12 center">
                <span class="center datos1 frpT"> N° FRP <span id="spnFRP"> </span></span><br>
                <span class="center datos1 lineas"> <span id="spnFecha"></span></span>
            </div>
            <div class="col s12 center">
                <span id="Nfarmacia" class="center Mcolor">COD# <span id="spnCodCls"></span> NOMBRE: <span id="spnNombreCliente"></span></span><br>
            </div>
        </div>
        
    <div class="row">
        <div class="col s4 m4 l3 center">
            <p class="canjePts RobotoB">CANJE: <span id="totalCanje">100,000</span> PTS.</p>
        </div>
        <div class="col s4 m4 l3 offset-l6 offset-s4 offset-m4 center">
            <p class="canjePts RobotoB">EFECTIVO: C$<span id="totalEfectivo2"> 100,000</span></p>
        </div>
    </div>
    <div class="row">
        <table id="tblModal1" class=" TblDatos">
            <thead>
                <tr>
                    <th>FECHA</th>
                    <th>FACTURA #</th>
                    <th>PUNTOS</th>
                    <th>PUNTOS A EFECTIVO</th>
                    <th>ESTADO</th>
                </tr>
            </thead>
            <tbody class="center">            
            </tbody>
        </table>
    </div>
        <div class="row">
                <div class="row">
                    <div class="input-field col s12">
                        <p class="Datos">OBSERVACIONES</p>
                        <textarea id="obser" class="materialize-textarea observaciones"></textarea>
                    </div>
            </form>
        </div>

        <div class="row center" id="iconoPrint">
            <!--<div class="col s2 m2 l2 offset-l5 offset-s4 offset-m4">-->
                <a class="noHover" href="#" onclick="callUrlPrint('DetalleFRE','spnFRP')"><img src="<?PHP echo base_url();?>assets/img/ico_imprimir.png " width="45px" ></a>
            <!--</div>-->
            <!--<div class="col s2 m2 l1">
                <a href="#"><img src="<?PHP echo base_url();?>assets/img/icono-pdf.png " width="35px" ></a>
            </div>-->
        </div>
    </div><!-- fin del contenido del modal -->

</div>
<!-- Fin de Modal#4-->

</div>
<!--///////////////////////////////////////////////////////////////////////////////////////////////
                                     MODALES ELIMINACION DE FRE
////////////////////////////////////////////////////////////////////////////////////////////////-->


 <div id="Dell" class="modal">
    <div class="modal-content">
        <div class="right row">
            <a href="#!" class=" BtnClose modal-action modal-close ">
                <i class="material-icons">highlight_off</i>
            </a>
        </div>
        <h6 class="center Mcolor1">DESEA ELIMINAR EL FRE #<span id="spnDellFRP" class="redT1">#indefinido</span></h6>
        <div class="row center">
                <a id="ProceDell" href="#" class="Procesar modal-action btn ">Procesar</a>
        </div>
    </div>
  </div>

  <div id="DellRes" class="modal">
    <div class="modal-content">
        <div class="right row">
                <a href="#!" class=" BtnClose modal-action modal-close ">
                    <i class="material-icons">highlight_off</i>
                </a>
        </div>
        <h6 class="center Mcolor1">FRE <span id="dellCorrectoFRE" class="redT1">#fc02258</span> ELIMINADO CORRECTAMENTE</h6>
        <h6 class="center Mcolor1">Espere...</h6>
    </div>
</div>