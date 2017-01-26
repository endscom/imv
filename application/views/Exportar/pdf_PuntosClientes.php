<!doctype html>
<html lang="en">
<head>
    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/img/faviconazul.png" />
    <meta charset="UTF-8">
        <style>
        tbody td, thead th{ padding: 8px 10px;}
        #ClienteAdd{border-collapse: separate;border-spacing: 1px;color: white; font-family: 'robotoblack';}
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
        }
    </style>
</head>
<body>
    

    <div class="row" style="margin-bottom:0">

        <div class="col l2" style="margin-left:35%;" >
            <img id="logo" src="<?PHP echo base_url();?>assets/img/Logo-Visys-color.png" width="30%" style="opacity: 0.5; ">
        </div>

    </div>
    <br>
    <div class="row center">
        <h3 style="font-family: 'robotoblack';font-size: 18px; color: #1F0A71; font-weight:bold;" >PUNTOS POR CLIENTES</h3>
    </div>

        <table id="ClienteAdd">

        <thead>
        <tr>
            <th>CLIENTE</th>
            <th>RUC</th>
            <th>DIRECCIÓN</th>
            <th>PUNTOS</th>
        </tr>
        </thead>

        <tbody>
        <?PHP
        if(!($query)){
            echo "fallo";
        }
        else{
            $i=0;
             foreach($query AS $cliente)
                    {
                        echo "<tr>
                                   <td class='center'>".$query[$i]['CLIENTE']."</td>
                                   <td id='NomCliente'>".$query[$i]['NOMBRE']."</td>
                                   <td class='center'>".$query[$i]['DIRECCION']."</td>
                                   <td class='center'>".number_format($query[$i]['PUNTOS'],2)."</td>
                              </tr>";
                        $i++;
                    }
        }
        ?>
        </tbody>
    </table>


</body>
</html>
</body>