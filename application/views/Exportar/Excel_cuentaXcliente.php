<?PHP /* CABECERA DEL ARCHIVO EXCELL*/
    header("Content-type:application/charset='UTF-8'");
    header("Content-Disposition: attachment; filename = EstadoDeCuenta.xls");
    header("Pragma: no-cache");
    header("Expires: 0");
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
        <style>
        tbody td, thead th{ padding: 8px 10px;}
        #ClienteAdd{border-collapse: separate;border-spacing: 2px;color: white; font-family: 'robotoblack';}
        #ClienteAdd tbody td{color:#1F0A71;font-size: 11px;}
        #ClienteAdd tr:nth-child(even){background: #e7e2f7;}
        #ClienteAdd tr:nth-child(odd){ background: #ffffff; }
        #ClienteAdd th{ background: #1F0A71;color: #fff; font-size: 14px;}
        #logo{margin: 10px 15px 10px;}
        @font-face {
            font-family: 'robotoblack';
            src: url('roboto-black-webfont.eot');
            src: url('roboto-black-webfont.eot?#iefix') format('embedded-opentype'),
            url('roboto-black-webfont.woff2') format('woff2'),
            url('roboto-black-webfont.woff') format('woff'),
            url('roboto-black-webfont.ttf') format('truetype'),
            url('roboto-black-webfont.svg#robotoblack') format('svg');
            font-weight: normal;
            font-style: normal;
        }
        @font-face {
            font-family: 'robotobold';
            src: url('roboto-bold-webfont.eot');
            src: url('roboto-bold-webfont.eot?#iefix') format('embedded-opentype'),
            url('roboto-bold-webfont.woff2') format('woff2'),
            url('roboto-bold-webfont.woff') format('woff'),
            url('roboto-bold-webfont.ttf') format('truetype'),
            url('roboto-bold-webfont.svg#robotobold') format('svg');
            font-weight: normal;
            font-style: normal;
        }
        @font-face {
            font-family: 'robotomedium';
            src: url('roboto-medium-webfont.eot');
            src: url('roboto-medium-webfont.eot?#iefix') format('embedded-opentype'),
            url('roboto-medium-webfont.woff2') format('woff2'),
            url('roboto-medium-webfont.woff') format('woff'),
            url('roboto-medium-webfont.ttf') format('truetype'),
            url('roboto-medium-webfont.svg#robotomedium') format('svg');
            font-weight: normal;
            font-style: normal;
        }
        @font-face {
            font-family: 'robotoregular';
            src: url('roboto-regular-webfont.eot');
            src: url('roboto-regular-webfont.eot?#iefix') format('embedded-opentype'),
            url('roboto-regular-webfont.woff2') format('woff2'),
            url('roboto-regular-webfont.woff') format('woff'),
            url('roboto-regular-webfont.ttf') format('truetype'),
            url('roboto-regular-webfont.svg#robotoregular') format('svg');
            font-weight: normal;
            font-style: normal;
        }
        .center{
            text-align: center!important;
            float: center;
        }.row{width: 100%;}
        .Mcolor{
            color: #6a4ad5;
            font-size: 19px;
            font-family: 'robotoblack';

        }.cod{font-size: 14px;}
        .ruc{font-size: 12px;}
        .detalles{
            color: #6a4ad5;
            font-family: 'robotoregular';
            font-size: 14px;
        }.linea{ margin-top: -20px;}
    </style>
</head>
<body>
    <div class="row" style="margin-bottom:0">
        <div class="col l2" style="margin-left:35%;" >
            <img id="logo" src="<?PHP echo base_url();?>assets/img/Logo-Visys-color.png" width="8%" style="opacity: 0.5; ">
        </div>
    </div>
    <br><br><br>
    <div class="row center" style="margin-top:20%;">
        <h3 style="font-family: 'robotoblack';font-size: 18px; color: #1F0A71; font-weight:bold;" >ESTADO DE CUENTA</h3>
    </div>
    <div class="row" >
        <h3 style="font-family: 'robotoblack';font-size: 15px; color: #1F0A71; font-weight:bold;" >DATOS DEL CLIENTE</h3>
            <p id="CXCdetalleCodigo" class="Mcolor cod"><?php echo $data['data2'][0]['CODIGO']; ?> | <?php echo $data['data2'][0]['NOMBRE']; ?></p>
            <p style="margin-top:3px" id="CXCdetalleRUC" class="Mcolor detalles linea"><?php echo $data['data2'][0]['RUC']; ?></p>
            <p style="margin-top:3px" id="CXCdetalleDIR" class="Mcolor detalles linea"><?php echo $data['data2'][0]['DIRECCION']; ?></p>
    </div><br>
        <table id="ClienteAdd">

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
        $TOTAL=0;
        if(!($data)){
            echo "Error al cargar los datos";
        }
        else{            
            $i=0;
            for ($i=0; $i < count($data2['data']); $i++) { 
                $TOTAL += $data2['data'][$i]['DISPONIBLE'];
                    echo "<tr>
                            <td class='center'>".$data2['data'][$i]['FACTURA']."</td>
                            <td id='NomCliente'>".$data2['data'][$i]['FECHA']."</td>
                            <td class='center'>".$data2['data'][$i]['PUNTOS']."</td>
                            <td class='center'>".$data2['data'][$i]['APLICADOS']."</td>
                            <td class='center'>".$data2['data'][$i]['DISPONIBLE']."</td>
                        </tr>";
            }
        }
        ?>
        </tbody>
    </table>
    <br>
    <div >
        <h3 style="font-family: 'ROBOTOMEDIUM';font-size: 15px; color: #1F0A71; font-weight:bold;" >TOTAL DE PUNTOS==> <?php echo $TOTAL; ?></h3>
    </div>
</body>
</html>
</body>