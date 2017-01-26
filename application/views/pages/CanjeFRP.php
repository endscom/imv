<header class="demo-header mdl-layout__header ">
    <div class="centrado  ColorHeader">

        <span class=" title">frp</span>

    </div>
</header>
<!--//////////////////////////////////////////////////////////
                CONTENIDO
///////////////////////////////////////////////////////////-->

<main class="mdl-layout__content mdl-color--grey-100">

    <div class="contenedor">
    <div class="row center TextColor">canje de puntos</div>
    
         <div class="container">
            <div class="noMargen Buscar row column">
                <div class="col s1 m1 l1 offset-l3 offset-s1 offset-m2">
                    <i class="material-icons ColorS">search</i>
                </div>

                <div class="input-field col s5 m4 l5">
                    <input  id="searchFRP" type="text" placeholder="Buscar" class="validate">
                    <label for="searchFRP"></label>
                </div>
            </div>
        </div>        

        <div class="right row">           
                <a href="#MFrp" class="BtnBlue waves-effect  btn modal-trigger">canje</a>
        </div>

        <table id="tblFRP" class=" TblDatos">

            <thead>
                <tr>
                    <th>FECHA</th>
                    <th>#FRP</th>
                    <th>COD. CLIENTE</th>
                    <th>NOMBRE</th>
                    <th>ELIMINAR</th>
                </tr>
            </thead>

            <tbody class="center">
            <?php 
                if(!$Lista){
            } else {
                foreach($Lista as $frp){

                    if ($frp['Anulado'] == "S"){
                        $clase="tachado";
                        $delete="";
                    } else {
                        $clase="";
                        $delete = " <a  onclick='dellFrp(".'"'.$frp['IdFRP'].'"'.")' href='#' class='Icono noHover'><i class='material-icons'>highlight_off</i></a>";
                    }
                    echo "<tr>
                                <td class='".$clase."'>".date('d-m-Y',strtotime($frp['Fecha']))."</td>
                                <td class='".$clase."'>".$frp['IdFRP']."</td>
                                <td class='".$clase."'>".$frp['IdCliente']."</td>
                                <td class='".$clase."' id='NomCliente'>".$frp['Nombre']."</td>
                                <td class='center'>
                                    <a  onclick='getview(".'"'.$frp['IdFRP'].'"'.")' href='#' class='noHover'><i class='material-icons'>&#xE417;</i></a>
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
<!--//////////////////////////////////////////////////////////////////////////////////////////////
                                      MODALES
///////////////////////////////////////////////////////////////////////////////////////////////-->
<!-- Modal #1
                Modal Structure -->
<div id="MFrp" class="modal">
    <div class="modal-content">

        <div class="right row">
                <a href="#!" class=" BtnClose modal-action modal-close ">
                    <i class="material-icons">highlight_off</i>
                </a>
        </div>

        <h6 id="Format" class="center Mcolor">FORMATO DE REMISIÓN DE PUNTOS</h6>
        <h6 id="Format" class="center Mcolor noMargen">CLIENTE</h6>

        <div class="row noMargen valign-wrapper">
            <div class="DatoFrp input-field line col s3 m3 l2">
                 N° FRP:<input maxlength="5" id="frp" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" class="frp" type="text" class="validate">
            </div>

            <div class="DatoFrp line col s3 m3 l3 offset-l7 offset-s4 offset-m4">
                FECHA:<input type="text" id="date1" class="datepicker1"><br>
            </div>
        </div>

        

        <div class="row">
            <div class=" DatoFrp line input-field col s12 m3 l3">
               COD. CLIENTE:<input id="txtCodCliente" readonly="readonly" style="color:#1F0A71!important;" class="frp" type="text" class="validate">
            </div>

            <div class="input-field col s12 m6 l6"  >
                <select class="chosen-select browser-default" name="cliente" id="ListCliente">
                    <option value="" disabled selected>CLIENTE</option>
                    <?php
                        if(!$data){}
                        else{
                                foreach($data as $asd){
                                    echo '<option value="'.$asd['CLIENTE'].'">'.$asd['NOMBRE'].'| '.$asd['CLIENTE'].'</option>';                                
                            }
                        }
                    ?>
                </select>
            </div>

            <div class="input-field col s12 m3 l3 DatoFrp valign-wrapper">
                PUNTOS:
                <input  id="PtosDisponibles" class="frp" type="text" readonly class="validate">
            </div>
        </div>
                <h6 class="center Mcolor">PREMIO A CANJEAR</h6>

        <!-- datos de los premios a canjear  -->
        <div class="row ">
                <div class=" DatoFrp line input-field col s12 m3 l2">
                    COD. PREMIO:<input id="CodPremioFRP" class="frp" readonly="readonly" style="color:#1F0A71!important;" type="text" class="validate">
                </div>
                <div class="DatoFrp line input-field col s12 m3 l2">
                    VALOR PREMIO:<input id="ValorPtsPremioFRP" readonly="readonly" style="color:#1F0A71!important;" class="frp" type="text" class="validate">
                </div>
                <div class="input-field col s12 m6 l4">
                    <select class="chosen-select browser-default" name="PREMIO" id="ListCatalogo">
                        <option value="" disabled selected>SELECCIONE PREMIO</option>
                        <?php
                            if(!$premios){
                            } else {
                                foreach($premios as $premio){
                                    echo '<option value="'.$premio['IdIMG'].'">'.$premio['Nombre']." | ".$premio['IdIMG'].'</option>';
                                }
                            }
                         ?>
                    </select>
                </div>
                <div class="DatoFrp line input-field col s6 m4 l2 valign-wrapper">
                    CANTIDAD:<input onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" id="CantPremioFRP" class="frp" type="text" class="validate">
                </div>
                <div id="Btnadd"class="center col s2 m2 l2 offset-s1">
                    <div class="row noMargen center"><div id="loadIMG" style="display:none" class="preloader-wrapper big active">
                        <div class="spinner-layer spinner-blue-only">
                            <div class="circle-clipper left">
                                    <div class="circle"></div>
                            </div>
                            <div class="gap-patch">
                                    <div class="circle"></div>
                                </div>

                                <div class="circle-clipper right">
                                    <div class="circle"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="#" id="AddPremioTbl" class="BtnBlue waves-effect  btn ">agregar</a>
                </div>
        </div>
        <div class="row">
            <table id="tblpRODUCTOS" class=" TblDatos">
                <thead>
                <tr>
                    <th>CANT.</th>
                    <th>COD. PREMIO</th>
                    <th>DESCRIPCIÓN</th>
                    <th>Pts. </th>
                    <th>TOTAL Pts.</th>
                    <th>CANCELAR</th>
                </tr>
                </thead>
                <tbody class="center">
                </tbody>
            </table>
        </div>
        <div id="Total" class="right row text">
            <div class="col s2 offset-s8">
                <input type="checkbox" id="checkAll" checked/>
                <label for="checkAll">AUTO APLICADO</label>
            </div>
            <div class="col s2">
                <p class="Dato">A APLICAR: <span class="dato" id="idttPtsFRP">0</span> Pts.</p>
            </div>
        </div>
        <div id= "moroso" class="row">
            <table id="tblFacturaFRP" class=" TblDatos">
                <thead>
                <tr>
                    <th>FECHA</th>
                    <th>FACTURA</th>
                    <th>PUNTOS</th>
                    <th>Pts. APLI.</th>
                    <th>Pts. DISP.</th>
                    <th> <i class="material-icons">done</i> </th>
                    <th>ESTADO</th>
                </tr>
                </thead>
                <tbody class="center"></tbody>
            </table>
        </div>
    <div id="Total" class="right row">
        <p class="Dato">PENDIENTES A APLICAR: <span class="dato" id="idttPtsCLsFRP">0</span> Pts.</p>
    </div>    
    <div class="center row">
        <a href="#" id="btnProcesar" class="Procesar waves-effect btn">procesar</a>
    </div>

</div>
</div>
<!-- Fin de Modal#1-->


<!--///////////////////////////////////////////////////////////////////////////////////////////////
                                     MODALES ELIMINACION DE FRP
////////////////////////////////////////////////////////////////////////////////////////////////-->
<!-- Modal #2 -->
<!-- Modal Structure -->
<div id="Dell" class="modal">
    <div class="modal-content">
        <div class="right row noMargen">
            <a href="#!" class=" BtnClose modal-action modal-close noHover">
                <i class="material-icons">highlight_off</i>
            </a>
        </div>
        <div class="row center ">
        <h6 class="Mcolor1">DESEA ELIMINAR EL FRP #<span class="redT1" id="spnDellFRP">#</span></h6>
        </div>
        <div class="row center">
                <a href="#" id="idProcederDell" class="Procesar btn">Procesar</a>
        </div>
    </div>
</div>
<!-- Modal #3 -->
<!-- Modal Structure -->

<div id="DellRes" class="modal">
    <div class="modal-content">
        <div class="right row">
            <a href="#!" class=" BtnClose modal-action modal-close ">
                <i class="material-icons">highlight_off</i>
            </a>
        </div>
        <h6 class="center Mcolor1">ELIMINADO CORRECTAMENTE FRP <span class="redT1">#00351</span></h6>
    </div>
</div>

<!--/////////////////////////////////////////////////////////////////////////////////////////////////////////////
                                        MODAL DETALLE FRP
//////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

<!-- Modal #4 Modal Structure -->
<div id="Dfrp" class="modal">
    <div class="modal-content">
            <div class="right row noMargen">
                <a href="#!" class=" BtnClose modal-action modal-close noHover">
                    <i class="material-icons">highlight_off</i>
                </a>
            </div>
            <div class="row center">
                <span id="titulM" class="Mcolor"> DETALLE FRP</span>
            </div>
            <div class="container center">
                <div class="row center " id="frpProgress">
                    <div class="preloader-wrapper big active">
                        <div class="spinner-layer spinner-blue-only">
                            <div class="circle-clipper left"><div class="circle"></div></div>
                            <div class="gap-patch"><div class="circle"></div></div>
                            <div class="circle-clipper right"><div class="circle"></div></div>
                        </div>
                    </div>
                </div>
                
                <div id="divTop">
                    <div class="col s5">
                        <span class="center datos1 frpT"> N° FRP <span id="spnFRP"> </span></span><br>
                        <span class="center datos1 lineas"> <span id="spnFecha"></span></span>
                    </div>

                    <div class="col s1">
                        <span id="Nfarmacia" class="center Mcolor">COD# <span id="spnCodCls"></span> NOMBRE: <span id="spnNombreCliente"></span></span><br>
                    </div>
                </div>
            </div>

           <div id="divTbl">
               <table id="tblModal1" class="TblDatos">
                   <thead>
                    <tr>
                        <th>FECHA</th>
                        <th>FACTURA</th>
                        <th>Pts.</th>
                        <th>Pts. APLI.</th>
                        <th>Pts. DISP.</th>
                        <th>ESTADO</th>
                    </tr>
                   </thead>

                   <tbody></tbody>
               </table>
               <h6 class="center Mcolor">PREMIOS A CANJEAR</h6>

               <table id="tblModal2" class="TblDatos">
                   <thead>
                    <tr>
                        <th>CANT.</th>
                        <th>COD. PREMIO</th>
                        <th>DESCRIPCIÓN</th>
                        <th>Pts. </th>
                        <th>TOTAL Pts.</th>
                    </tr>
                   </thead>

                   <tbody class="center"></tbody>
               </table>
               <h6 class="center Mcolor dat">TOTAL FRP <span class="dato"><span id="spnTotalFRP"></span></span> Pts.</h6>
               <div class="row center" style="">
                   <a class="noHover" href="#" onclick="callUrlPrint('ExpFRP','spnFRP')"  target=""><img src="<?PHP echo base_url();?>assets/img/ico_imprimir.png " width="45px" ></a>
               </div>
           </div>


    </div>
</div>


<!--******************* -->
<div id="idviewFRP" class="modal">
    <div class="modal-content">
                <div class="row right">
                        <a href="#!" class=" BtnClose modal-action modal-close noHover">
                            <i class="material-icons">highlight_off</i>
                        </a>                    
                </div>
                

                <div class="row center " id="vfrpProgress">
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

                <div id="vfrpTop">
                    <div class="center col s12 m12 l12">
                        <h6 class="Mcolor noMargen">DETALLE FRP</h6>
                    </div>
                    <div class="col s12 center">
                        <span class="center datos1 frpT"> N° FRP <span id="spnviewFRP"> </span></span><br>
                        <span class="center datos1 lineas"> <span id="spnviewFecha"></span></span>
                    </div>

                    <div class="col s12 center">
                        <span id="Nfarmacia" class="center Mcolor">COD# <span id="spnviewCodCls"></span> NOMBRE: <span id="spnviewNombreCliente"></span></span><br>
                    </div>
                </div>
            

           <div id="vfrpTop">
               <table id="tblviewDFacturaFRP" class="TblDatos">
                   <thead>
                        <tr>
                            <th>FECHA</th>
                            <th>FACTURA</th>
                            <th>Pts.</th>
                            <th>Pts. APLI.</th>
                            <th>Pts. DISP.</th>
                            <th>ESTADO</th>
                        </tr>
                   </thead>
                   
                   <tbody class="center"></tbody>
               </table>
               <h6 class="center Mcolor">PREMIO A CANJEAR</h6>

               <table id="tblviewDPremioFRP" class="TblDatos">
                   <thead>
                        <tr>
                            <th>CANT.</th>
                            <th>COD. PREMIO</th>
                            <th>DESCRIPCIÓN</th>
                            <th>Pts. </th>
                            <th>TOTAL Pts.</th>
                        </tr>
                   </thead>
                   
                   <tbody class="center"></tbody>
               </table>
               <h6 class="center Mcolor dat">TOTAL FRP <span class="dato"><span id="spnttFRP"></span> Pts.</span> </h6>
               <div style = "display:none;" id = "iconoPrint" class="row center">
                   <a class="noHover" href="#" onclick="callUrlPrint('ExpFRP','spnviewFRP')"><img src="<?PHP echo base_url();?>assets/img/ico_imprimir.png " width="45px" ></a>
               </div>
           </div>
    </div>
</div>