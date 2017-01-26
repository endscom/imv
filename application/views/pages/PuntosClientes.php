<header class="demo-header mdl-layout__header ">
    <div class="centrado  ColorHeader">

        <span class=" title">PUNTOS</span>

    </div>
</header>
<!--//////////////////////////////////////////////////////////
                CONTENIDO
///////////////////////////////////////////////////////////-->

<main class="mdl-layout__content mdl-color--grey-100">

    <div class="contenedor">

        <div class=" row TextColor center">
                 puntos clientes
        </div>

        <div class="container">
            <div class=" Buscar row column">

                <div class="col s1 m1 l1 offset-l3 offset-m2 ">
                    <i class="material-icons ColorS">search</i>
                </div>

                <div class="input-field col s11 m5 l5">
                    <input  id="searchPtsClientes" type="text" placeholder="Buscar" class="validate">
                    <label for="searchPtsClientes"></label>
                </div>
                <div class="col s2 m1 l1">
                    <a href="ExpEXCEL_PuntosClientes" onclick="generar_reporte_excel(FrmPuntosClientes);"> <img src="<?PHP echo base_url();?>assets/img/icono_excel.png " width="30px"></a>
                </div>
                <div class="col s1 m1 l1 ">
                    <a href="ExpPDF_PuntosClientes" target="_blank" onclick="generar_reporte_pdf(FrmPuntosClientes);"><img src="<?PHP echo base_url();?>assets/img/icono-pdf.png " width="30px" ></a>
                </div>
            </div>
        </div>
    <form action="" name="FrmPuntosClientes" id="FrmPuntosClientes" method="post"> <!--Exportar datos a EXCEL -->
        <table id="PtosCliente" class=" TblDatos">
            <thead>
            <tr>
                <th>DETALLES</th>
                <th>CÓDIGO</th>
                <th>CLIENTE</th>
                <th>RUC</th>
                <th>PTS ORIGINALES</th>
                <th>PTS DISPONIBLES</th>
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
                        $clase="";
                        if ($query[$i]['MOROSO'] == "S"){
                            $clase="red-text";
                        }
                        echo "<tr>
                                    <td class='center green-text detallesFactura'><i id='detail".$query[$i]['CLIENTE']."' class='material-icons'>details</i>
                                        <div id='loader".$query[$i]['CLIENTE']."' style='display:none;' class='preloader-wrapper small active' >
                                            <div class='spinner-layer spinner-blue-only'>
                                            <div style='overflow: visible!important;' class='circle-clipper left'>
                                                <div class='circle'></div>
                                            </div><div class='gap-patch'>
                                                <div class='circle'></div>
                                            </div><div style='overflow: visible!important;' class='circle-clipper right'>
                                                <div class='circle'></div>
                                            </div>
                                            </div>
                                        </div>
                                    </td>
                                   <td class='".$clase." center'>".$query[$i]['CLIENTE']."</td>
                                   <td class='".$clase." id='NomCliente'>".$query[$i]['NOMBRE']."</td>
                                   <td class='".$clase." center'>".$query[$i]['RUC']."</td>
                                   <td class='".$clase." center'>".number_format($query[$i]['ORIGINALES'],2)."</td>
                                   <td class='".$clase." center'>".number_format($query[$i]['PUNTOS'],2)."</td>
                              </tr>";
                        $i++;
                    }
                }
                ?>
            </tbody>
        </table>
    </form>
    </div>
</main>