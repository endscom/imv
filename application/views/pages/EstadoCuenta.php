<header class="demo-header mdl-layout__header ">
    <div class="centrado  ColorHeader"><span class=" title">ESTADO DE CUENTA</span></div>
</header>

<main class="mdl-layout__content mdl-color--grey-100">
    <div class="mdl-grid demo-content">       
        <div class="row TextColor center">facturas</div>
    <div class="row">
        <form action="<?php echo base_url('index.php/ExpPDFEstadoCuenta');?>" id="frmEstadoCuenta" name="frmEstadoCuenta" target="_blank" method="post">
        <div class="offset-m2 offset-l3 col s12 m3 l3 input-field">
            <input name="fecha1" placeholder="Desde" id="CXCfecha1" type="text" class="datepicker1">
        </div>
        <div class="col s12 m3 l3 input-field">
            <input name="fecha2" placeholder="Hasta" id="CXCfecha2" type="text" class="datepicker1">
        </div> 
        <div class="col s1 input-field">
            <a href="#" id="estadoCuenta"><i class="material-icons">search</i></a>
        </div>
        <div class="col s1 input-field">
            <a href="#" onclick="generar_reporte_pdf();"><img src="<?PHP echo base_url();?>assets/img/icono-pdf.png " width="30px" ></a>
        </div>
        </form>
    </div>
    <div class="row" id="loadCuenta" style="display:none;">
        <div class="progress">
            <div class="indeterminate"></div>
        </div>
    </div>
    <div class="row noMargen">
        <div class="row center">
          <div class="col l12 s12 m12 scrollHorizontal">
            <table id="TbCatalogo" class="TblDatos center">
                <thead>
                    <tr>
                        <th>FACTURA</th>
                        <th>FECHA</th>
                        <th>PUNTOS X FACTURA</th>
                        <th>PUNTOS APLICADOS</th>
                        <th>PUNTOS DISPONIBLES</th>
                    </tr>
                </thead>                    
                <tbody>
                    <?PHP
                        $TOTAL = 0;
                        if(!($data)){
                            echo "NO HAY DATOS";
                        }
                        else{
                            $i=0;
                             foreach($data AS $cliente)
                                    {
                                        echo "<tr>
                                                   <td class='center'>".$data[$i]['FACTURA']."</td>
                                                   <td id='NomCliente'>".$data[$i]['FECHA']."</td>
                                                   <td class='center'>".$data[$i]['PUNTOS']."</td>
                                                   <td class='center'>".$data[$i]['APLICADOS']."</td>
                                                   <td class='center'>".@number_format($data[$i]['DISPONIBLE'],0)."</td>
                                              </tr>";
                                        $TOTAL = $TOTAL+$data[$i]['DISPONIBLE'];
                                        $i++;
                                    }
                        }
                        ?>
                </tbody>
            </table>
          </div>
        </div>
    </div>
    <div class="row valign-wrapper noMargen">
        <div class="col s1 offset-s9 Mcolor ">
            <h5 class="negra">TOTAL:</h5>
        </div>
        <div class="col s2 Mcolor">
            <h5 id="TotalEstado" class="negra"><?php echo $TOTAL; ?> Pts.</h5>
        </div>
    </div>
</div>
</main>
</div>

