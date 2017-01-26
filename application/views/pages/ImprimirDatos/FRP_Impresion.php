<link rel="shortcut icon" href="<?php echo base_url(); ?>assets/img/faviconazul.png" />
<body onload="window.print();"><!-- Impresion de la Página al cargar... -->
<main class="mdl-layout__contents" >

    <div class="">

        <div class=" row TextColor">
            <div class="col s5 m5 l12">

            </div>
        </div>

          <div class="container">
              <div class="right row">
                  <div class="col s12 m12 l12">
                      <span id="detalleFrp">detalle frp</span>
                  </div>
              </div>

              <div class="row">
                  <div class="col s3 m3 l3">
                      <img src="<?PHP echo base_url();?>assets/img/Logo-Visys-color.png" width="70%" style="opacity: 0.5;">
                  </div>
                  <div class="col s6 m6 l6">
                      <p id="numFrp" class="RobotoB Color"> N° FRP 38389</p>
                      <p id="fechafrp" class="RobotoB Color">24/12/2016</p>
                      <p id="NomFaramacia" class="RobotoB">00449 farmacia castellón</p>
                      <p id="ruc" class="RobotoB">ruc 441200018300123h</p>
                  </div>
              </div>

              <table class="detallesFrp Color">
                  <thead>
                  <tr>
                      <th>FECHA</th>
                      <th>BOUCHER</th>
                      <th>Pts.</th>
                      <th>Pts. APLI.</th>
                      <th>Pts. DISP.</th>
                      <th>ESTADO</th>
                  </tr>

                  </thead>

                  <tbody>
                  <tr>
                      <td>24/01/2016</td>
                      <td  class="RobotoB">067792</td>
                      <td  class="RobotoB">300,000 Pts.</td>
                      <td>300,000 Pts.</td>
                      <td>0</td>
                      <td class="RobotoR">APLICADO</td>
                  </tr>
                  <tr>
                      <td>24/01/2016</td>
                      <td  class="RobotoB">067792</td>
                      <td  class="RobotoB">300,000 Pts.</td>
                      <td>300,000 Pts.</td>
                      <td>0</td>
                      <td class="RobotoR Ccolor">PARCIAL</td>
                  </tr>
                  </tbody>
              </table>

              <div class=" row">
                  <div class="col s4 m8 l4 offset-l8 offset-m4 offset-s8">
                      <p class="PtAplicado RobotoB">PUNTOS APLICADOS: 363,522 Pts.</p>
                  </div>
              </div>

              <h6 id="NomFaramacia" class="center RobotoB ">
                  premio a canjear
              </h6>

              <table class="detallesFrp Color">
                  <thead>
                  <tr>
                      <th>CANT.</th>
                      <th>COD. PREMIO</th>
                      <th>DESCRIPCIÓN</th>
                      <th>Pts.</th>
                      <th>TOTAL Pts.</th>
                  </tr>
                  </thead>

                  <tbody>
                  <tr>
                      <td>20</td>
                      <td  class="RobotoB">146790</td>
                      <td class="RobotoB">centro entre famesa munich</td>
                      <td>17,998 Pts.</td>
                      <td>359,960 Pts.</td>
                  </tr>
                  </tbody>
              </table>

              <div class=" row">
                  <div class="col s6 m4 l5 offset-l7 offset-m8 offset-s6">
                      <p class="PtAplicado RobotoB"> PUNTOS APLICADOS POR EL CANJE: 363,522 Pts.</p>
                  </div>
              </div>


              <h6 class="center RegImp  RobotoB">imp0001/frp</h6>
              <h6 class="center RegImp  RobotoB">GENERADO EL: <?php echo date('d-m-Y H:i:s'); ?></h6>
          </div>

        </div>
</main>