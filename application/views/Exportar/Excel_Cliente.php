
<?PHP /* CABECERA DEL ARCHIVO EXCELL*/
    header("Content-type:application/charset='UTF-8'");
    header("Content-Disposition: attachment; filename = Clientes.xls");
    header("Pragma: no-cache");
    header("Expires: 0");
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <style>
        tbody td, thead th{ padding: 8px 10px;}
        #ClienteAdd{border-collapse: separate;border-spacing: 1px;color: white;}
        #ClienteAdd tbody td{color:#1F0A71;font-size: 11px;}
        #ClienteAdd tr:nth-child(even){background: #e7e2f7;}
        #ClienteAdd tr:nth-child(odd){ background: #ffffff; }
        #ClienteAdd th{ background: #1F0A71;color: #fff; font-size: 14px;}
        #logo{margin: 10px 15px 10px;}
    </style>
</head>
<body>

<h5 style="text-align: center;color: #1F0A71; font-family: 'robotoblack'; font-size: 18px;">CLIENTES QUE APLICAN AL SISTEMA DE PUNTOS</h5>

<table width="100px;"id="ClienteAdd" >
   <thead>
       <tr >
           <th >CLIENTE</th>
           <th >RUC</th>
           <th >DIRECCI&Oacute;N</th>
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
                                   <td >".$query[$i]['NOMBRE']."</td>
                                   <td >".$query[$i]['RUC']."</td>
                                   <td >".$query[$i]['DIRECCION']."</td>
                  </tr>";
            $i++;
        }
    }
    ?>
    </tbody>
</table>
