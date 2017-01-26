<link rel="shortcut icon" href="<?php echo base_url(); ?>assets/img/faviconazul.png" />
<body onload="window.print();"><!-- Impresion de la Página al cargar... -->
<main class="mdl-layout__contents">
    <div class="">

        <div class=" row TextColor">
            <div class="col s5 m5 l12">

            </div>
        </div>

        <div class="container">
            <div class="right row">
                <div class="col s12 m12 l12">
                    <span id="detalleFrp">detalle fre</span>
                </div>
            </div>

            <div class="row">
                <div class="col s3 m3 l3">
                    <img src="<?PHP echo base_url();?>assets/img/Logo-Visys-color.png" width="50%" style="opacity: 0.5;">
                </div>
                <div class="col s6 m6 l6">
                    <p id="numFrp" class="RobotoB Color"> N° FRE <?php echo $fre[0]['IdFRE']; ?></p>
                    <p id="fechafrp" class="RobotoB Color">FECHA: <?php echo date('d-m-Y',strtotime($fre[0]['Fecha'])); ?></p>
                    <p id="Farmafre" class="RobotoB Color"> <?php echo $fre[0]['IdCliente']; ?> <?php echo $fre[0]['Nombre']; ?></p>
                    
                </div>
            </div>

            <div class="row">
                <div class="col s4 m4 l3">
                    <?php $puntos=0; foreach ($detalles as $key) {$puntos = $puntos +$key['Puntos'];} ?>
                    <p class="canjePts RobotoB">CANJE:  <?php echo number_format($puntos,0); ?> PTS.</p>
                </div>
                <div class="col s4 m4 l3 offset-l6 offset-s4 offset-m4 right">
                    <?php $efectivo=0; foreach ($detalles as $key) {$efectivo = $efectivo +$key['Efectivo'];} ?>
                    <p class="canjePts RobotoB">EFECTIVO: C$  <?php echo number_format($efectivo,0); ?></p>
                </div>
            </div>

            <table  id="tblFREimpre" class=" TblDatos">
                <thead style="background: #1F0A71; color: #fff; font-size: 14px; font-family: 'robotobold';">
                <tr>
                    <th>FECHA</th>
                    <th>#FACTURA</th>
                    <th>PUNTOS</th>
                    <th>PUNTOS A EFECT.</th>
                    <th>ESTADO</th>
                </tr>

                </thead>

                <tbody class="center">
                <?php 
                    if (!($detalles)) {}
                        else{
                            foreach ($detalles as $key) {
                                echo "<tr>
                                        <td>".$key['Fecha']."</td>
                                        <td>".$key['Factura']."</td>
                                        <td>".$key['Puntos']."</td>
                                        <td>".$key['Efectivo']."</td>
                                        <td>PAGADO</td>
                                </tr>";
                            }
                        }
                 ?>
                </tbody>
            </table>

            <div class="row noMargen">
                <div class="input-field col s12 m12 l12">
                        <p id="TxtObser" class="RobotoB Ccolor">OBSERVACIONES</p>
                        <textarea id="obser" class="materialize-textarea observaciones"><?php echo $fre[0]['Comentario']; ?></textarea>
                </div>
            </div>
            <h6 class="center RegImp  RobotoB">GENERADO EL: <?php echo date('d-m-Y H:i:s'); ?></h6>
        </div>
    </div>
</main>