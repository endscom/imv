<!doctype html>
<html lang="en">
<head>
    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/img/faviconazul.png" />
    <meta charset="UTF-8">
    <style>
        #ClienteAdd{border-collapse: separate;border-spacing: 1px;color: white; font-family: 'robotoblack';}
        #tbla tbody td{color: #831f82;font-size: 14px;}
        #tbla tr:nth-child(even){background: #ffffff;}
        #tbla tr:nth-child(odd){ background: #e7e2f7; }
        #tbla th{ background: #ffffff;color: #831f82; font-size: 14px;}
        .Blank td {
            background: #ffffff;
        }
        .alert{
            color: #e74c3c ;
        }
        #view-source {
            position: fixed;
            display: block;
            right: 0;
            bottom: 0;
            margin-right: 40px;
            margin-bottom: 40px;
            z-index: 900;
        }
    </style>
    <link rel="stylesheet"href="<?PHP echo base_url();?>assets/css/materialize.css">
    <link rel="stylesheet" href="<?PHP echo base_url();?>assets/css/material.cyan-light_blue.min.css">
    <link rel="stylesheet" href="<?PHP echo base_url();?>assets/media/icon.css">

    <link rel="stylesheet" href="<?PHP echo base_url();?>assets/css/styles.css">
    <link rel="stylesheet" href="<?PHP echo base_url();?>assets/css/jquery.dataTables.css">
    <link rel="stylesheet" href="<?PHP echo base_url();?>assets/css/bootstrap.css">
<script>
   // window.print();
</script>
</head>
<body>
<div id="tbla">
<div class="content">
    <div class="container center">
        <div class="col s1"><br>
            <div class="row">
                <div class="col offset-s1 s2">
                    <img src="<?PHP echo base_url();?>assets/img/Logo-Visys-color.png" width="110">
                </div>
                <div class="col s2 offset-s2">
                    <span id="titulM" class="Mcolor"> DETALLE FRP</span>
                </div>
                
            </div
        </div>
        <?PHP
        if(!$top){
        } else {
            foreach($top as $tops){
                echo '
                <div class="col s1">
                    <span class="center datos1 frpT"> N° FRP '.$tops['IdFRP'].'</span><br>
                    <span class="center datos1 lineas">FECHA: '.date_format(date_create($tops['Fecha']), 'd-m-Y').'</span>
                </div>
                <div class="col s1">
                    <span id="Nfarmacia" class="Mcolor" >COD# '.$tops['IdCliente'].' NOMBRE: '.$tops['Nombre'].'</span>
                </div>
                ';
            }
        }
        ?>


    </div>


    <table id="tblModal1" class="Blank">
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

        <tbody>

        <?PHP
            if(!$DFactura){
            } else {
                foreach($DFactura as $des){
                    echo ' <tr>

                                <td>'.date_format(date_create($des['Fecha']), 'd-m-Y').'</td>
                                <td id="black">'.$des['Factura'].'</td>
                                <td id="black">'.$des['Faplicado'].' Pts.</td>
                                <td>'.$des['Puntos'].' Pts.</td>
                                <td>'.$des['SALDO'].' Pts.</td>
                                <td>'.(($des['SALDO'] == 0) ? APLICADO : PARCIAL).'</td>
                            </tr>
                    ';
                }
            }


        ?>
        </tbody>
    </table>

    <div class="row">
        <div class="Mcolor center col s12 ">PREMIO A CANJEAR</div>
    </div>
    <table id="tblModal1" class="Blank">
        <thead>
        <tr>
            <th>CANT.</th>
            <th>COD. PREMIO</th>
            <th>DESCRIPCIÓN</th>
            <th>PUNTOS</th>
            <th>TOTAL Pts.</th>
        </tr>
        </thead>

        <tbody>

        <?PHP
        if(!$DArticulo){
        } else {
            foreach($DArticulo as $dp){
                echo ' <tr>
                                <td>'.number_format($dp['CANTIDAD'],0).'</td>
                                <td id="black">'.$dp['IdArticulo'].'</td>
                                <td id="black">'.$dp['Descripcion'].'</td>
                                <td>'.number_format($dp['PUNTO'],0).' Pts.</td>
                                <td>'.number_format($dp['CANTIDAD']*$dp['PUNTO'],0).' Pts.</td>
                            </tr>
                    ';
                $count += $dp['CANTIDAD']*$dp['PUNTO'];
            }
        }


        ?>

        </tbody>
    </table>

    <div class="row center">
        <h6 class="center Mcolor dat"><span class="alert">PUNTOS APLICADOS POR EL CANJE: <?php echo number_format($count,0) ?> Pts.</span> </h6>

    </div>
        <h6 class="center RegImp  RobotoB">GENERADO EL: <?php echo date('d-m-Y H:i:s'); ?></h6>

</div>
</div>
</div>
</body>
</html>