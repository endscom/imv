<header class="demo-header mdl-layout__header ">
    <div class="centrado  ColorHeader"><span class=" title">MASTER DE FACTURAS</span></div>
</header>

<main class="mdl-layout__content mdl-color--grey-100">
    <div class="mdl-grid demo-content">       
        <div class="row TextColor center">facturas</div>

        <div class="row" style="width:100%">
          <div class="container">
            <div class="Buscar row column">               
              <div class="col s1 m1 l1 offset-l3 offset-m2"><i class="material-icons ColorS">search</i></div>
                <div class="input-field col s11 m6 l5">
                    <input  id="searchFactura" type="text" placeholder="Buscar" class="validate mayuscula">
                </div>
            </div>
          </div>

        <div class="row center">
          <div class="col l12 s12 m12 scrollHorizontal">
            <table id="TbCatalogo" class="TblDatos center">
                <thead>
                    <tr>
                        <th>FECHA</th>
                        <th>FACTURA</th>
                        <th>CÓDIGO</th>
                        <th>CLIENTE</th>
                        <th>PUNTOS</th>
                        <th>VER</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        if(!($query)){
                            echo "error al cargar los datos";
                        }
                        else{
                            $i=0;
                            foreach($query AS $factura)
                            {
                                echo "<tr>
                                           <td>".$query[$i]['FECHA']."</td>
                                           <td>".$query[$i]['FACTURA']."</td>
                                           <td>".$query[$i]['CLIENTE']."</td>
                                           <td>".$query[$i]['NOMBRE_CLIENTE']."</td>
                                           <td>".$query[$i]['PUNTOS']."</td>
                                           <td>".$query[$i]['VER']."</td>
                                      </tr>";
                                $i++;
                            }
                        }
                    ?>
                
                </tbody>
            </table>
          </div>
        </div>
  </div>
</div>
</main>
</div>

<!--///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                                            Modales Detalles Facturas
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
<div id="modalDetalleFact" class="modal">
    <div class="modal-content">
        <div class=" row">
            <div class="right col s1 m1 l1">
                <a href="#!" class=" BtnClose modal-action modal-close noHover"><i class="material-icons">highlight_off</i></a>
            </div>
        </div>

        <h6  class="center Mcolor">FACTURA: <span id="codFactura">0.00</span></h6>
        <div class="row">
            <div class="col s12">
                <div id="loadIMG" style="display:none" class="preloader-wrapper big active">
                    <div class="spinner-layer spinner-blue-only">
                        <div class="circle-clipper left"><div class="circle"></div></div>
                            <div class="gap-patch"><div class="circle"></div></div>
                        <div class="circle-clipper right"><div class="circle"></div></div>
                    </div>
                </div>
                <table id="TbDetalleFactura" class="TblDatos center">
                    <thead>
                        <tr>
                            <th>ARTICULO.</th>
                            <th>DESCRIPCIÓN</th>
                            <th>CANTIDAD.</th>
                            <th>PUNTOS</th>
                            <th>TOTAL</th>
                        </tr>
                    </thead>

                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>