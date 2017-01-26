<?PHP
    header("Content-type:application/charset='UTF-8'");
    header("Content-Disposition: attachment; filename = Reporte Puntos Clientes ".date('d-m-Y').".xls");
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

<div class="row center">
        <h3 style="font-family: 'robotoblack';font-size: 18px; color: #1F0A71; font-weight:bold;" >PUNTOS POR CLIENTES</h3>
</div>

<table width="100px;"id="ClienteAdd" >
   <thead>
       <tr >
           <th>COD</th>
            <th>CLIENTE</th>
            <th>RUC</th>
            <th>PUNTOS</th>
       </tr>
   </thead>
    <tbody>
    <?PHP
    if(!($query)){
        echo "fallo al cargar los datos...";
    }
    else{
        $i=0;

        foreach($query AS $cliente){
        echo "<tr>
        		<td class='center'>".$query[$i]['CLIENTE']."</td>
                <td id='NomCliente'>".$query[$i]['NOMBRE']."</td>
                <td class='center'>".$query[$i]['RUC']."</td>
                <td class='center'>".number_format($query[$i]['PUNTOS'],2)."</td>
            </tr>";
        	$i++;
        }
    }
    ?>
    </tbody>
</table>
