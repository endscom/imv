<header class="demo-header mdl-layout__header ">
    <div class="centrado  ColorHeader"><span class=" title">VISTA PREVIA</span></div>
</header>
<!--  CONTENIDO PRINCIPAL -->
<main class="mdl-layout__content mdl-color--grey-100">
<div class="contenedor">        
    <div class="noMargen row TextColor center"><div class="col s12 m8 l12 offset-m2">CONFIRME LOS DATOS Y PRESIONE ACEPTAR</div></div>
    		<div class="row column">
                <div class="input-field col s3 m3 l2 offset-l4 offset-m3 offset-s1">
                    <a href="datos" id="ACEP" class="BtnBlue btn waves-effect waves-light">ACEPTAR
                        <i class="material-icons left">done_all</i>
                    </a>
				</div>
                <div class="input-field col s3 m3 l3 offset-m1 offset-s2">
                    <a href="#modalEliminar" id="btnCargarBajas" class="modal-trigger BtnEliminar waves-effect btn">CANCELAR
                        <i class="material-icons left">delete_forever</i>
                    </a>
                </div>
            </div>
    <div class="row">
        <div class="noMargen row TextColor center"><h6>TABLA DE METAS</h6></div>
        <table id="tblmetas" class=" TblDatos">
            <thead>
                <tr>
                    <th>COD. VENDEDOR</th>
                    <th>VENDEDOR</th>
                    <th>COD. CLIENTE</th>
                    <th>CLIENTE</th>
                    <th>META VENTA</th>
                    <th>META ITEM FACTURA</th>
                    <th>META MONTO FACTURA</th>
                    <th>META PROM X FACTURA</th>
                </tr>
            </thead>
            <tbody class="center">
                <?php 
                    if (!($metas)) {}
                    else{
                        foreach ($metas as $key ) {
                            echo "<tr>
                                    <td>".$key['CodVendedor']."</td>
                                    <td class='negra'>".$key['NombreVendedor']."</td>
                                    <td>".$key['CodCliente']."</td>
                                    <td class='negra'>".$key['NombreCliente']."</td>
                                    <td>".number_format($key['MontoVenta'],0)."</td>
                                    <td>".$key['NumItemFac']."</td>
                                    <td>".number_format($key['MontoXFac'],0)."</td>
                                    <td>".$key['PromItemXFac']."</td>
                            </tr>";
                        }
                    }
                ?>
            </tbody>
        </table>
    </div>
    <div class="row">
        <div class="noMargen row TextColor center"><h6>TABLA DE CUOTAS</h6></div>
        <table id="tblcuotas" class=" TblDatos">
            <thead>
                <tr>
                    <th>COD. VENDEDOR</th>
                    <th>VENDEDOR</th>
                    <th>COD. PRODUCTO</th>
                    <th>DESCRIPCIÓN</th>
                    <th>META</th>
                </tr>
            </thead>
            <tbody class="center">
                <?php 
                    if (!($cuotas)) {}
                    else{
                        foreach ($cuotas as $key ) {
                            echo "<tr>
                                    <td>".$key['CodVendedor']."</td>
                                    <td class='negra'>".$key['NombreVendedor']."</td>
                                    <td>".$key['CodProducto']."</td>
                                    <td class='negra'>".$key['NombreProducto']."</td>
                                    <td class='negra'>".$key['Meta']."</td>
                            </tr>";
                        }
                    }
                ?>         
            </tbody>
        </table>
    </div>
</div>
</main>  
<!-- FIN CONTENIDO PRINCIPAL -->


<!-- Modal #1 Modal Structure -->
<div id="modalEliminar" class="modal">
    <div class="modal-content">
            <div class="right row noMargen">
                <a href="#!" class=" BtnClose modal-action modal-close noHover">
                    <i class="material-icons">highlight_off</i>
                </a>
            </div>
            <div class="row center">
                <span id="titulM" class="Mcolor red-text">¿ESTA SEGURO DE DESCARTAR LOS DATOS?</span>
            </div>
        <form id="formExcel" name="formExcel" enctype="multipart/form-data" class="col s6 m6 l6" action="<?PHP echo base_url('index.php/descartarDatos');?>" method="post">
        <input name="cuota" value="<?php echo $cuotas[0]['IdPeriodo']; ?>" type="hidden">
        <input name="meta" value="<?php echo $metas[0]['IdPeriodo']; ?>" type="hidden">
        <div class="row center">
            <button id="descartar" href="#" class="BtnBlue btn waves-effect waves-light" type="submit" name="action">ACEPTAR
                <i class="material-icons left">done_all</i>
            </button>
        </div>
		</form>
    </div>
</div>