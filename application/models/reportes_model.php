<?php
class Reportes_model extends CI_Model
{
    public function __construct(){
        parent::__construct();
        $this->load->database();
        $this->load->model('canje_efectivo_model');
        $this->load->model('canje_model');
    }
    public $CONDICION = '2016-10-01';
    public function formatDecimal($valor,$bandera=null)
    {
        $arr = array(".00000000" => "", ".000000" => "", ".0000000" => "", ".0000" => "");
        if ($valor == ".000000") {
            return 0;
        }else{
            return strtr($valor,$arr);
        }
        /*if ($bandera!=null) {
            return $valor = str_replace(".00000000","",$valor);
        }else{return $valor = str_replace(".000000","",$valor);}*/
    }
    public function cuentaXcliente($codigo,$f1,$f2,$bandera=null)
    {
        $query = "SELECT FACTURA,FECHA,SUM(TT_PUNTOS) AS PUNTOS FROM vtVS2_Facturas_CL WHERE CLIENTE='".$codigo."'
                    AND FECHA BETWEEN '".date('d-m-Y',strtotime($f1))."' AND '".$f2."'";
        $q_rows = $this->db->query("call pc_Clientes_Facturas ('".$codigo."')");
        if ($q_rows->num_rows() > 0) {
            $query .= "AND FACTURA NOT IN(".$q_rows->result_array()[0]['Facturas'].")";
        }
        $q_rows->next_result();
        $q_rows->free_result();

        $q_rows = $this->db->query("call pc_Clientes_Facturas_Fre ('".$codigo."')");
        if ($q_rows->num_rows() > 0) {
                $query .= " AND FACTURA NOT IN (".$q_rows->result_array()[0]['Facturas'].")";
        }        
        $query .= " GROUP BY FACTURA, FECHA";
        $q_rows->next_result();
        $q_rows->free_result();
        //echo $query."<br>";
        $i=0;
        $json = array();
        $query = $this->sqlsrv->fetchArray($query,SQLSRV_FETCH_ASSOC);
            $json['data'][$i]['FACTURA'] = "-";
            $json['data'][$i]['FECHA'] = "-";
            $json['data'][$i]['PUNTOS'] = "NO HAY DATOS";
            $json['data'][$i]['APLICADOS'] = "-";
            $json['data'][$i]['DISPONIBLE'] = "-";

        foreach($query as $key){

            $json['data'][$i]['FACTURA'] = "<p class='negra noMargen'>".$key['FACTURA']."</p>";
            $json['data'][$i]['FECHA'] = $key['FECHA']->format('d-m-Y');
            $json['data'][$i]['PUNTOS'] = number_format($key['PUNTOS'],0);
            $json['data'][$i]['APLICADOS'] = $this->getAplicado($key['FACTURA']);
            $json['data'][$i]['DISPONIBLE'] = $this->formatDecimal($this->canje_model->getSaldoParcial($key['FACTURA'],$key['PUNTOS']));
            $i++;
        }

        if ($bandera!=null) {
            return $json;
        }else{
            echo json_encode($json);    
        }
    }

    public function getAplicado($FACTURA)
    {
        $this->db->where('Factura',$FACTURA);
        $query = $this->db->get('rfactura');
        if ($query->num_rows()>0) {
            if ($query->result_array()[0]['Puntos']>0) {
                return $query->result_array()[0]['ttPuntos']-$query->result_array()[0]['Puntos'];
            }
            return $query->result_array()[0]['ttPuntos'];
        }
        return 0;
    }
    public function datosCliente($codigo,$bandera=null){
        $query ="SELECT DIRECCION,RUC,CLIENTE,NOMBRE FROM vtVS2_Clientes WHERE CLIENTE = '".$codigo."' ";
        $i=0;
        $json = array();
        $query = $this->sqlsrv->fetchArray($query,SQLSRV_FETCH_ASSOC);

        foreach($query as $key){
            $json['data2'][0]['DIRECCION'] = $key['DIRECCION'];
            $json['data2'][0]['RUC'] = $key['RUC'];
            $json['data2'][0]['CODIGO'] = $key['CLIENTE'];
            $json['data2'][0]['NOMBRE'] = $key['NOMBRE'];
            $i++;
        }
        if ($bandera==null) {
            echo json_encode($json);
        }        
        return $json;
        $this->sqlsrv->close();
    }
    public function masterClientes($fecha1,$fecha2)
    {
        $i=0;
        $json = array();
        $query = $this->sqlsrv->fetchArray("SELECT CLIENTE,NOMBRE_CLIENTE,SUM(TT_PUNTOS) AS PUNTOS FROM vtVS2_Facturas_CL
                                            WHERE FECHA BETWEEN '".$fecha1."' AND '".$fecha2."'
                                            GROUP BY CLIENTE,NOMBRE_CLIENTE",SQLSRV_FETCH_ASSOC);
                                            
        foreach($query as $key){
            $json['data'][$i]['NUMERO'] = $i+1;
            $json['data'][$i]['CODIGO'] = $key['CLIENTE'];
            $json['data'][$i]['CLIENTE'] = $key['NOMBRE_CLIENTE'];
            $json['data'][$i]['PUNTOS'] = $this->formatDecimal($key['PUNTOS']);
            $i++;
        }
            $json['columns'][0]['data'] = "NUMERO";
            $json['columns'][0]['name'] = "NUMERO";
            $json['columns'][1]['data'] = "CODIGO";
            $json['columns'][1]['name'] = "CODIGO";
            $json['columns'][2]['data'] = "CLIENTE";
            $json['columns'][2]['name'] = "CLIENTE";
            $json['columns'][3]['data'] = "PUNTOS";
            $json['columns'][3]['name'] = "PUNTOS";

        echo json_encode($json);
        $this->sqlsrv->close();
    }
    public function canjePremios($fecha1,$fecha2)
    {
        
    }
    public function masterFacturas($fecha1,$fecha2)
    {
        $i=0;
        $json = array();
        $query = $this->sqlsrv->fetchArray("SELECT FECHA,FACTURA,CLIENTE,NOMBRE_CLIENTE,SUM(TT_PUNTOS) AS PUNTOS  FROM vtVS2_Facturas_CL
                                            WHERE FECHA BETWEEN '".$fecha1."' AND '".$fecha2."'
                                            GROUP BY FACTURA,FECHA,CLIENTE,NOMBRE_CLIENTE",SQLSRV_FETCH_ASSOC);
                                            
        foreach($query as $key){
            $json['data'][$i]['FACTURA'] = "<p class='negra noMargen'>".$key['FACTURA']."</p>";
            $json['data'][$i]['CODIGO'] = $key['CLIENTE'];
            $json['data'][$i]['CLIENTE'] = "<p class='mediana noMargen'>".$key['NOMBRE_CLIENTE']."</p>";
            $json['data'][$i]['PUNTOS'] = number_format($this->formatDecimal($this->canje_model->getSaldoParcial($key['FACTURA'],$key['PUNTOS'])),0);
            $json['data'][$i]['ESTADO'] = ($json['data'][$i]['PUNTOS']==0) ? "APLICADO" : "ACTIVO";
            $i++;
        }
            $json['columns'][0]['data'] = "FACTURA";
            $json['columns'][0]['name'] = "FACTURA";
            $json['columns'][1]['data'] = "CODIGO";
            $json['columns'][1]['name'] = "CODIGO";
            $json['columns'][2]['data'] = "CLIENTE";
            $json['columns'][2]['name'] = "CLIENTE";
            $json['columns'][3]['data'] = "PUNTOS";
            $json['columns'][3]['name'] = "PUNTOS";
            $json['columns'][4]['data'] = "ESTADO";
            $json['columns'][4]['name'] = "ESTADO";

        echo json_encode($json);
        $this->sqlsrv->close();
    }
    public function masterCompras($fecha1,$fecha2)
    {
        $i=0;
        $json = array();
        $query = $this->sqlsrv->fetchArray("SELECT DESCRIPCION,CANTIDAD,CLIENTE,NOMBRE_CLIENTE,RUTA,FACTURA,FECHA FROM vtVS2_MASTER_COMPRAS 
                                            WHERE FECHA BETWEEN '".$fecha1."' AND '".$fecha2."'",SQLSRV_FETCH_ASSOC);
                                            
        foreach($query as $key){
            $json['data'][$i]['NUMERO'] = $i+1;
            $json['data'][$i]['DESCRIPCION'] = "<p class='negra noMargen'>".$key['DESCRIPCION']."</p>";
            $json['data'][$i]['CANTIDAD'] = $this->formatDecimal($key['CANTIDAD'],1);
            $json['data'][$i]['CLIENTE'] = $key['CLIENTE'];
            $json['data'][$i]['NOMBRE'] = "<p class='negra noMargen'>".$key['NOMBRE_CLIENTE']."</p>";
            $json['data'][$i]['RUTA'] = $key['RUTA'];
            $json['data'][$i]['FACTURA'] = $key['FACTURA'];
            $json['data'][$i]['FECHA'] = $key['FECHA']->format('d-m-Y');
            $i++;
        }
            $json['columns'][0]['data'] = "NUMERO";
            $json['columns'][0]['name'] = "NUMERO";
            $json['columns'][1]['data'] = "DESCRIPCION";
            $json['columns'][1]['name'] = "DESCRIPCION";
            $json['columns'][2]['data'] = "CANTIDAD";
            $json['columns'][2]['name'] = "CANTIDAD";
            $json['columns'][3]['data'] = "CLIENTE";
            $json['columns'][3]['name'] = "CODIGO";
            $json['columns'][4]['data'] = "NOMBRE";
            $json['columns'][4]['name'] = "NOMBRE";
            $json['columns'][5]['data'] = "RUTA";
            $json['columns'][5]['name'] = "RUTA";
            $json['columns'][6]['data'] = "FACTURA";
            $json['columns'][6]['name'] = "FACTURA";
            $json['columns'][7]['data'] = "FECHA";
            $json['columns'][7]['name'] = "FECHA";

        echo json_encode($json);
        $this->sqlsrv->close();
    }
    public function reporteXfecha($fecha1,$fecha2)
    {
        $i=0;
        $json = array();
        $query = $this->sqlsrv->fetchArray("SELECT FECHA,RUTA,SUM(TT_PUNTOS) AS PUNTOS, FACTURA,CLIENTE, NOMBRE_CLIENTE from vtVS2_Facturas_CL
                                            WHERE FECHA BETWEEN '".$fecha1."' AND '".$fecha2."'
                                            GROUP BY FACTURA,FECHA,RUTA,CLIENTE,NOMBRE_CLIENTE",SQLSRV_FETCH_ASSOC);
                                            
        foreach($query as $key){
            $json['data'][$i]['FECHA'] = "<p class='negra noMargen'>".$key['FECHA']->format('d-m-Y')."</p>";
            $json['data'][$i]['RUTA'] = $key['RUTA'];
            $json['data'][$i]['PUNTOS'] = $this->formatDecimal($key['PUNTOS']);
            $json['data'][$i]['FACTURA'] = "<p class='negra noMargen'>".$key['FACTURA']."</p>";
            $json['data'][$i]['CLIENTE'] = $key['CLIENTE'];
            $json['data'][$i]['NOMBRE'] = $key['NOMBRE_CLIENTE'];
            $i++;
        }
            $json['columns'][0]['data'] = "FECHA";
            $json['columns'][0]['name'] = "FECHA";
            $json['columns'][1]['data'] = "RUTA";
            $json['columns'][1]['name'] = "RUTA";
            $json['columns'][2]['data'] = "PUNTOS";
            $json['columns'][2]['name'] = "PUNTOS";
            $json['columns'][3]['data'] = "FACTURA";
            $json['columns'][3]['name'] = "FACTURA";
            $json['columns'][4]['data'] = "CLIENTE";
            $json['columns'][4]['name'] = "CLIENTE";
            $json['columns'][5]['data'] = "NOMBRE";
            $json['columns'][5]['name'] = "NOMBRE";

        echo json_encode($json);
        $this->sqlsrv->close();
    }
    public function movimientoProductos($fecha1,$fecha2)
    {
        $i=0;
        $json = array();
        $query = $this->sqlsrv->fetchArray("SELECT TOP 10 ARTICULO,DESCRIPCION,SUM(CANTIDAD) AS CANTIDAD,SUM(TT_PUNTOS) AS PUNTOS FROM vtVS2_Facturas_CL
                                            WHERE FECHA BETWEEN '".$fecha1."' AND '".$fecha2."'
                                            GROUP BY ARTICULO,DESCRIPCION ORDER BY PUNTOS DESC",SQLSRV_FETCH_ASSOC);

        foreach($query as $key){
            $json['data'][$i]['NUMERO'] = $i+1;
            $json['data'][$i]['ARTICULO'] = $key['ARTICULO'];
            $json['data'][$i]['DESCRIPCION'] = "<p class='negra noMargen'>".$key['DESCRIPCION']."</p>";
            $json['data'][$i]['CANTIDAD'] = number_format($key['CANTIDAD'],0);
            $json['data'][$i]['PUNTOS'] = "<p class='mediana'>".number_format($key['PUNTOS'],0)."</p>";
            $i++;
        }
            $json['columns'][0]['data'] = "NUMERO";
            $json['columns'][0]['name'] = "NUMERO";
            $json['columns'][1]['data'] = "ARTICULO";
            $json['columns'][1]['name'] = "ARTICULO";
            $json['columns'][2]['data'] = "DESCRIPCION";
            $json['columns'][2]['name'] = "DESCRIPCION";
            $json['columns'][3]['data'] = "CANTIDAD";
            $json['columns'][3]['name'] = "CANTIDAD";
            $json['columns'][4]['data'] = "PUNTOS";
            $json['columns'][4]['name'] = "PUNTOS";

        echo json_encode($json);
        $this->sqlsrv->close();
    }
    public function clientes_nuevos($fecha1,$fecha2)
    {
        $i=0;
        $json = array();
        $query = $this->sqlsrv->fetchArray("SELECT 
                                            COUNT(CASE WHEN MONTH(FECHA_INGRESO)=1 THEN FECHA_INGRESO END) AS ENE,
                                            COUNT(CASE WHEN MONTH(FECHA_INGRESO)=2 THEN FECHA_INGRESO END) AS FEB,
                                            COUNT(CASE WHEN MONTH(FECHA_INGRESO)=3 THEN FECHA_INGRESO END) AS MAR,
                                            COUNT(CASE WHEN MONTH(FECHA_INGRESO)=4 THEN FECHA_INGRESO END) AS ABR,
                                            COUNT(CASE WHEN MONTH(FECHA_INGRESO)=5 THEN FECHA_INGRESO END) AS MAY,
                                            COUNT(CASE WHEN MONTH(FECHA_INGRESO)=6 THEN FECHA_INGRESO END) AS JUN,
                                            COUNT(CASE WHEN MONTH(FECHA_INGRESO)=7 THEN FECHA_INGRESO END) AS JUL,
                                            COUNT(CASE WHEN MONTH(FECHA_INGRESO)=8 THEN FECHA_INGRESO END) AS AGO,
                                            COUNT(CASE WHEN MONTH(FECHA_INGRESO)=9 THEN FECHA_INGRESO END) AS SEP,
                                            COUNT(CASE WHEN MONTH(FECHA_INGRESO)=10 THEN FECHA_INGRESO END) AS OCT,
                                            COUNT(CASE WHEN MONTH(FECHA_INGRESO)=11 THEN FECHA_INGRESO END) AS NOV,
                                            COUNT(CASE WHEN MONTH(FECHA_INGRESO)=12 THEN FECHA_INGRESO END) AS DIC
                                            FROM Softland.umk.CLIENTE
                                            WHERE FECHA_INGRESO BETWEEN '".$fecha1."' AND '".$fecha2."'",SQLSRV_FETCH_ASSOC);

        foreach($query as $key){
            $json['data'][$i]['ENE'] =$key['ENE'];
            $json['data'][$i]['FEB'] = $key['FEB'];
            $json['data'][$i]['MAR'] = $key['MAR'];
            $json['data'][$i]['ABR'] = $key['ABR'];
            $json['data'][$i]['MAY'] = $key['MAY'];
            $json['data'][$i]['JUN'] = $key['JUN'];
            $json['data'][$i]['JUL'] = $key['JUL'];
            $json['data'][$i]['AGO'] = $key['AGO'];
            $json['data'][$i]['SEP'] = $key['SEP'];
            $json['data'][$i]['OCT'] = $key['OCT'];
            $json['data'][$i]['NOV'] = $key['NOV'];
            $json['data'][$i]['DIC'] = $key['DIC'];            
            $i++;
        }
            $json['columns'][0]['data'] = "ENE";
            $json['columns'][0]['name'] = "ENE";
            $json['columns'][1]['data'] = "FEB";
            $json['columns'][1]['name'] = "FEB";
            $json['columns'][2]['data'] = "MAR";
            $json['columns'][2]['name'] = "MAR";
            $json['columns'][3]['data'] = "ABR";
            $json['columns'][3]['name'] = "ABR";
            $json['columns'][4]['data'] = "MAY";
            $json['columns'][4]['name'] = "MAY";
            $json['columns'][5]['data'] = "JUN";
            $json['columns'][5]['name'] = "JUN";
            $json['columns'][6]['data'] = "JUL";
            $json['columns'][6]['name'] = "JUL";
            $json['columns'][7]['data'] = "AGO";
            $json['columns'][7]['name'] = "AGO";
            $json['columns'][8]['data'] = "SEP";
            $json['columns'][8]['name'] = "SEP";
            $json['columns'][9]['data'] = "OCT";
            $json['columns'][9]['name'] = "OCT";
            $json['columns'][10]['data'] = "NOV";
            $json['columns'][10]['name'] = "NOV";
            $json['columns'][11]['data'] = "DIC";
            $json['columns'][11]['name'] = "DIC";
        echo json_encode($json);
        $this->sqlsrv->close();
    }
    public function mas_vendidos($fecha1,$fecha2)
    {
        $i=0;
        $json = array();
        $query = $this->sqlsrv->fetchArray("SELECT TOP 10 DESCRIPCION, SUM(CANTIDAD) AS TOTAL,
                                            ISNULL(SUM(CASE WHEN MONTH(FECHA)=1 THEN TT_PUNTOS END),0) AS ENE,
                                            ISNULL(SUM(CASE WHEN MONTH(FECHA)=2 THEN TT_PUNTOS END),0) AS FEB,
                                            ISNULL(SUM(CASE WHEN MONTH(FECHA)=3 THEN TT_PUNTOS END),0) AS MAR,
                                            ISNULL(SUM(CASE WHEN MONTH(FECHA)=4 THEN TT_PUNTOS END),0) AS ABR,
                                            ISNULL(SUM(CASE WHEN MONTH(FECHA)=5 THEN TT_PUNTOS END),0) AS MAY,
                                            ISNULL(SUM(CASE WHEN MONTH(FECHA)=6 THEN TT_PUNTOS END),0) AS JUN,
                                            ISNULL(SUM(CASE WHEN MONTH(FECHA)=7 THEN TT_PUNTOS END),0) AS JUL,
                                            ISNULL(SUM(CASE WHEN MONTH(FECHA)=8 THEN TT_PUNTOS END),0) AS AGO,
                                            ISNULL(SUM(CASE WHEN MONTH(FECHA)=9 THEN TT_PUNTOS END),0) AS SEP,
                                            ISNULL(SUM(CASE WHEN MONTH(FECHA)=10 THEN TT_PUNTOS END),0) AS OCT,
                                            ISNULL(SUM(CASE WHEN MONTH(FECHA)=11 THEN TT_PUNTOS END),0) AS NOV,
                                            ISNULL(SUM(CASE WHEN MONTH(FECHA)=12 THEN TT_PUNTOS END),0) AS DIC
                                            FROM vtVS2_Facturas_CL 
                                            WHERE FECHA BETWEEN '".$fecha1."' AND '".$fecha2."'
                                            GROUP BY DESCRIPCION
                                            ORDER BY TOTAL DESC;",SQLSRV_FETCH_ASSOC);
        
        foreach($query as $key){
            $json['data'][$i]['DESCRIPCION'] = '<p class="negra noMargen">'.$key['DESCRIPCION']."</p>";
            $json['data'][$i]['TOTAL'] = '<p class="bold noMargen">'.$this->formatDecimal($key['TOTAL'])."</p>";
            $json['data'][$i]['ENE'] = $this->formatDecimal($key['ENE']);
            $json['data'][$i]['FEB'] = $this->formatDecimal($key['FEB']);
            $json['data'][$i]['MAR'] = $this->formatDecimal($key['MAR']);
            $json['data'][$i]['ABR'] = $this->formatDecimal($key['ABR']);
            $json['data'][$i]['MAY'] = $this->formatDecimal($key['MAY']);
            $json['data'][$i]['JUN'] = $this->formatDecimal($key['JUN']);
            $json['data'][$i]['JUL'] = $this->formatDecimal($key['JUL']);
            $json['data'][$i]['AGO'] = $this->formatDecimal($key['AGO']);
            $json['data'][$i]['SEP'] = $this->formatDecimal($key['SEP']);
            $json['data'][$i]['OCT'] = $this->formatDecimal($key['OCT']);
            $json['data'][$i]['NOV'] = $this->formatDecimal($key['NOV']);
            $json['data'][$i]['DIC'] = $this->formatDecimal($key['DIC']);            
            $i++;
        }
            $json['columns'][0]['data'] = "DESCRIPCION";
            $json['columns'][0]['name'] = "DESCRIPCION";
            $json['columns'][1]['data'] = "TOTAL";
            $json['columns'][1]['name'] = "TOTAL";
            $json['columns'][2]['data'] = "ENE";
            $json['columns'][2]['name'] = "ENE";
            $json['columns'][3]['data'] = "FEB";
            $json['columns'][3]['name'] = "FEB";
            $json['columns'][4]['data'] = "MAR";
            $json['columns'][4]['name'] = "MAR";
            $json['columns'][5]['data'] = "ABR";
            $json['columns'][5]['name'] = "ABR";
            $json['columns'][6]['data'] = "MAY";
            $json['columns'][6]['name'] = "MAY";
            $json['columns'][7]['data'] = "JUN";
            $json['columns'][7]['name'] = "JUN";
            $json['columns'][8]['data'] = "JUL";
            $json['columns'][8]['name'] = "JUL";
            $json['columns'][9]['data'] = "AGO";
            $json['columns'][9]['name'] = "AGO";
            $json['columns'][10]['data'] = "SEP";
            $json['columns'][10]['name'] = "SEP";
            $json['columns'][11]['data'] = "OCT";
            $json['columns'][11]['name'] = "OCT";
            $json['columns'][12]['data'] = "NOV";
            $json['columns'][12]['name'] = "NOV";
            $json['columns'][13]['data'] = "DIC";
            $json['columns'][13]['name'] = "DIC";
        echo json_encode($json);
        $this->sqlsrv->close();
    }
    public function menos_vendidos($fecha1,$fecha2)
    {
        $i=0;
        $json = array();
        $query = $this->sqlsrv->fetchArray("SELECT TOP 10 DESCRIPCION, SUM(CANTIDAD) AS TOTAL,
                                            ISNULL(SUM(CASE WHEN MONTH(FECHA)=1 THEN TT_PUNTOS END),0) AS ENE,
                                            ISNULL(SUM(CASE WHEN MONTH(FECHA)=2 THEN TT_PUNTOS END),0) AS FEB,
                                            ISNULL(SUM(CASE WHEN MONTH(FECHA)=3 THEN TT_PUNTOS END),0) AS MAR,
                                            ISNULL(SUM(CASE WHEN MONTH(FECHA)=4 THEN TT_PUNTOS END),0) AS ABR,
                                            ISNULL(SUM(CASE WHEN MONTH(FECHA)=5 THEN TT_PUNTOS END),0) AS MAY,
                                            ISNULL(SUM(CASE WHEN MONTH(FECHA)=6 THEN TT_PUNTOS END),0) AS JUN,
                                            ISNULL(SUM(CASE WHEN MONTH(FECHA)=7 THEN TT_PUNTOS END),0) AS JUL,
                                            ISNULL(SUM(CASE WHEN MONTH(FECHA)=8 THEN TT_PUNTOS END),0) AS AGO,
                                            ISNULL(SUM(CASE WHEN MONTH(FECHA)=9 THEN TT_PUNTOS END),0) AS SEP,
                                            ISNULL(SUM(CASE WHEN MONTH(FECHA)=10 THEN TT_PUNTOS END),0) AS OCT,
                                            ISNULL(SUM(CASE WHEN MONTH(FECHA)=11 THEN TT_PUNTOS END),0) AS NOV,
                                            ISNULL(SUM(CASE WHEN MONTH(FECHA)=12 THEN TT_PUNTOS END),0) AS DIC
                                            FROM vtVS2_Facturas_CL 
                                            WHERE FECHA BETWEEN '".$fecha1."' AND '".$fecha2."'
                                            GROUP BY DESCRIPCION
                                            ORDER BY TOTAL",SQLSRV_FETCH_ASSOC);
        
        foreach($query as $key){
            $json['data'][$i]['DESCRIPCION'] = '<p class="negra noMargen">'.$key['DESCRIPCION']."</p>";
            $json['data'][$i]['TOTAL'] = '<p class="bold noMargen">'.$this->formatDecimal($key['TOTAL'])."</p>";
            $json['data'][$i]['ENE'] = $this->formatDecimal($key['ENE']);
            $json['data'][$i]['FEB'] = $this->formatDecimal($key['FEB']);
            $json['data'][$i]['MAR'] = $this->formatDecimal($key['MAR']);
            $json['data'][$i]['ABR'] = $this->formatDecimal($key['ABR']);
            $json['data'][$i]['MAY'] = $this->formatDecimal($key['MAY']);
            $json['data'][$i]['JUN'] = $this->formatDecimal($key['JUN']);
            $json['data'][$i]['JUL'] = $this->formatDecimal($key['JUL']);
            $json['data'][$i]['AGO'] = $this->formatDecimal($key['AGO']);
            $json['data'][$i]['SEP'] = $this->formatDecimal($key['SEP']);
            $json['data'][$i]['OCT'] = $this->formatDecimal($key['OCT']);
            $json['data'][$i]['NOV'] = $this->formatDecimal($key['NOV']);
            $json['data'][$i]['DIC'] = $this->formatDecimal($key['DIC']);            
            $i++;
        }
            $json['columns'][0]['data'] = "DESCRIPCION";
            $json['columns'][0]['name'] = "DESCRIPCION";
            $json['columns'][1]['data'] = "TOTAL";
            $json['columns'][1]['name'] = "TOTAL";
            $json['columns'][2]['data'] = "ENE";
            $json['columns'][2]['name'] = "ENE";
            $json['columns'][3]['data'] = "FEB";
            $json['columns'][3]['name'] = "FEB";
            $json['columns'][4]['data'] = "MAR";
            $json['columns'][4]['name'] = "MAR";
            $json['columns'][5]['data'] = "ABR";
            $json['columns'][5]['name'] = "ABR";
            $json['columns'][6]['data'] = "MAY";
            $json['columns'][6]['name'] = "MAY";
            $json['columns'][7]['data'] = "JUN";
            $json['columns'][7]['name'] = "JUN";
            $json['columns'][8]['data'] = "JUL";
            $json['columns'][8]['name'] = "JUL";
            $json['columns'][9]['data'] = "AGO";
            $json['columns'][9]['name'] = "AGO";
            $json['columns'][10]['data'] = "SEP";
            $json['columns'][10]['name'] = "SEP";
            $json['columns'][11]['data'] = "OCT";
            $json['columns'][11]['name'] = "OCT";
            $json['columns'][12]['data'] = "NOV";
            $json['columns'][12]['name'] = "NOV";
            $json['columns'][13]['data'] = "DIC";
            $json['columns'][13]['name'] = "DIC";
        echo json_encode($json);
        $this->sqlsrv->close();
    }
    public function puntosXcliente($fecha1,$fecha2)
    {
        $i=0;
        $json = array();
        $query = $this->sqlsrv->fetchArray("SELECT CLIENTE,NOMBRE_CLIENTE,RUTA,
                                            ISNULL(SUM(CASE WHEN MONTH(FECHA)=1 THEN TT_PUNTOS END),0) AS ENE,
                                            ISNULL(SUM(CASE WHEN MONTH(FECHA)=2 THEN TT_PUNTOS END),0) AS FEB,
                                            ISNULL(SUM(CASE WHEN MONTH(FECHA)=3 THEN TT_PUNTOS END),0) AS MAR,
                                            ISNULL(SUM(CASE WHEN MONTH(FECHA)=4 THEN TT_PUNTOS END),0) AS ABR,
                                            ISNULL(SUM(CASE WHEN MONTH(FECHA)=5 THEN TT_PUNTOS END),0) AS MAY,
                                            ISNULL(SUM(CASE WHEN MONTH(FECHA)=6 THEN TT_PUNTOS END),0) AS JUN,
                                            ISNULL(SUM(CASE WHEN MONTH(FECHA)=7 THEN TT_PUNTOS END),0) AS JUL,
                                            ISNULL(SUM(CASE WHEN MONTH(FECHA)=8 THEN TT_PUNTOS END),0) AS AGO,
                                            ISNULL(SUM(CASE WHEN MONTH(FECHA)=9 THEN TT_PUNTOS END),0) AS SEP,
                                            ISNULL(SUM(CASE WHEN MONTH(FECHA)=10 THEN TT_PUNTOS END),0) AS OCT,
                                            ISNULL(SUM(CASE WHEN MONTH(FECHA)=11 THEN TT_PUNTOS END),0) AS NOV,
                                            ISNULL(SUM(CASE WHEN MONTH(FECHA)=12 THEN TT_PUNTOS END),0) AS DIC
                                            FROM vtVS2_Facturas_CL
                                            WHERE FECHA BETWEEN '".$fecha1."' AND '".$fecha2."'
                                            GROUP BY CLIENTE,NOMBRE_CLIENTE,RUTA",SQLSRV_FETCH_ASSOC);
        
        foreach($query as $key){
            $json['data'][$i]['CODIGO'] = '<p class="negra noMargen">'.$key['CLIENTE']."</p>";
            $json['data'][$i]['NOMBRE'] = '<p class="bold noMargen">'.$key['NOMBRE_CLIENTE']."</p>";
            $json['data'][$i]['RUTA'] = '<p class="bold noMargen">'.$key['RUTA']."</p>";
            $json['data'][$i]['ENE'] = $this->formatDecimal($key['ENE']);
            $json['data'][$i]['FEB'] = $this->formatDecimal($key['FEB']);
            $json['data'][$i]['MAR'] = $this->formatDecimal($key['MAR']);
            $json['data'][$i]['ABR'] = $this->formatDecimal($key['ABR']);
            $json['data'][$i]['MAY'] = $this->formatDecimal($key['MAY']);
            $json['data'][$i]['JUN'] = $this->formatDecimal($key['JUN']);
            $json['data'][$i]['JUL'] = $this->formatDecimal($key['JUL']);
            $json['data'][$i]['AGO'] = $this->formatDecimal($key['AGO']);
            $json['data'][$i]['SEP'] = $this->formatDecimal($key['SEP']);
            $json['data'][$i]['OCT'] = $this->formatDecimal($key['OCT']);
            $json['data'][$i]['NOV'] = $this->formatDecimal($key['NOV']);
            $json['data'][$i]['DIC'] = $this->formatDecimal($key['DIC']);
            $i++;
        }
            $json['columns'][0]['data'] = "CODIGO";
            $json['columns'][0]['name'] = "CODIGO";
            $json['columns'][1]['data'] = "NOMBRE";
            $json['columns'][1]['name'] = "NOMBRE";
            $json['columns'][2]['data'] = "RUTA";
            $json['columns'][2]['name'] = "RUTA";
            $json['columns'][3]['data'] = "ENE";
            $json['columns'][3]['name'] = "ENE";
            $json['columns'][4]['data'] = "FEB";
            $json['columns'][4]['name'] = "FEB";
            $json['columns'][5]['data'] = "MAR";
            $json['columns'][5]['name'] = "MAR";
            $json['columns'][6]['data'] = "ABR";
            $json['columns'][6]['name'] = "ABR";
            $json['columns'][7]['data'] = "MAY";
            $json['columns'][7]['name'] = "MAY";
            $json['columns'][8]['data'] = "JUN";
            $json['columns'][8]['name'] = "JUN";
            $json['columns'][9]['data'] = "JUL";
            $json['columns'][9]['name'] = "JUL";
            $json['columns'][10]['data'] = "AGO";
            $json['columns'][10]['name'] = "AGO";
            $json['columns'][11]['data'] = "SEP";
            $json['columns'][11]['name'] = "SEP";
            $json['columns'][12]['data'] = "OCT";
            $json['columns'][12]['name'] = "OCT";
            $json['columns'][13]['data'] = "NOV";
            $json['columns'][13]['name'] = "NOV";
            $json['columns'][14]['data'] = "DIC";
            $json['columns'][14]['name'] = "DIC";
        echo json_encode($json);
        $this->sqlsrv->close();
    }
    public function canjes($fecha1,$fecha2)
    {
        $i=0;
        $json = array();
        $query = $this->db->query("SELECT 
                                    COUNT(CASE WHEN MONTH(t1.Fecha)=1 THEN t1.IdFRP END) AS ENE,
                                    COUNT(CASE WHEN MONTH(t1.Fecha)=2 THEN t1.IdFRP END) AS FEB,
                                    COUNT(CASE WHEN MONTH(t1.Fecha)=3 THEN t1.IdFRP END) AS MAR,
                                    COUNT(CASE WHEN MONTH(t1.Fecha)=4 THEN t1.IdFRP END) AS ABR,
                                    COUNT(CASE WHEN MONTH(t1.Fecha)=5 THEN t1.IdFRP END) AS MAY,
                                    COUNT(CASE WHEN MONTH(t1.Fecha)=6 THEN t1.IdFRP END) AS JUN,
                                    COUNT(CASE WHEN MONTH(t1.Fecha)=7 THEN t1.IdFRP END) AS JUL,
                                    COUNT(CASE WHEN MONTH(t1.Fecha)=8 THEN t1.IdFRP END) AS AGO,
                                    COUNT(CASE WHEN MONTH(t1.Fecha)=9 THEN t1.IdFRP END) AS SEP,
                                    COUNT(CASE WHEN MONTH(t1.Fecha)=10 THEN t1.IdFRP END) AS OCT,
                                    COUNT(CASE WHEN MONTH(t1.Fecha)=11 THEN t1.IdFRP END) AS NOV,
                                    COUNT(CASE WHEN MONTH(t1.Fecha)=12 THEN t1.IdFRP END) AS DIC
                                    FROM frp t1 WHERE Anulado='N' AND  t1.FECHA BETWEEN '".$fecha1."' AND '".$fecha2."'
                                    ");
    
        $query2 = $this->db->query("SELECT
                                    IFNULL(SUM(CASE WHEN MONTH(frp.Fecha)=1 THEN detallefrp.Puntos END ),0) AS ENE,
                                    IFNULL(SUM(CASE WHEN MONTH(frp.Fecha)=2 THEN detallefrp.Puntos END ),0) AS FEB,
                                    IFNULL(SUM(CASE WHEN MONTH(frp.Fecha)=3 THEN detallefrp.Puntos END ),0) AS MAR,
                                    IFNULL(SUM(CASE WHEN MONTH(frp.Fecha)=4 THEN detallefrp.Puntos END ),0) AS ABR,
                                    IFNULL(SUM(CASE WHEN MONTH(frp.Fecha)=5 THEN detallefrp.Puntos END ),0) AS MAY,
                                    IFNULL(SUM(CASE WHEN MONTH(frp.Fecha)=6 THEN detallefrp.Puntos END ),0) AS JUN,
                                    IFNULL(SUM(CASE WHEN MONTH(frp.Fecha)=7 THEN detallefrp.Puntos END ),0) AS JUL,
                                    IFNULL(SUM(CASE WHEN MONTH(frp.Fecha)=8 THEN detallefrp.Puntos END ),0) AS AGO,
                                    IFNULL(SUM(CASE WHEN MONTH(frp.Fecha)=9 THEN detallefrp.Puntos END ),0) AS SEP,
                                    IFNULL(SUM(CASE WHEN MONTH(frp.Fecha)=10 THEN detallefrp.Puntos END ),0) AS OCT,
                                    IFNULL(SUM(CASE WHEN MONTH(frp.Fecha)=11 THEN detallefrp.Puntos END ),0) AS NOV,
                                    IFNULL(SUM(CASE WHEN MONTH(frp.Fecha)=12 THEN detallefrp.Puntos END ),0) AS DIC
                                    FROM
                                    detallefrp
                                    INNER JOIN frp ON frp.IdFRP = detallefrp.IdFRP WHERE frp.Fecha BETWEEN '".$fecha1."' AND '".$fecha2."'");
        
        if ($query->num_rows()>0) {
            foreach($query->result_array() as $key){
                $json['data'][$i]['ENE'] = $this->formatDecimal($key['ENE']);
                $json['data'][$i]['ENE2'] = $this->formatDecimal($query2->result_array()[0]['ENE']);
                $json['data'][$i]['FEB'] = $this->formatDecimal($key['FEB']);
                $json['data'][$i]['FEB2'] = $this->formatDecimal($query2->result_array()[0]['FEB']);
                $json['data'][$i]['MAR'] = $this->formatDecimal($key['MAR']);
                $json['data'][$i]['MAR2'] = $this->formatDecimal($query2->result_array()[0]['MAR']);
                $json['data'][$i]['ABR'] = $this->formatDecimal($key['ABR']);
                $json['data'][$i]['ABR2'] = $this->formatDecimal($query2->result_array()[0]['ABR']);
                $json['data'][$i]['MAY'] = $this->formatDecimal($key['MAY']);
                $json['data'][$i]['MAY2'] = $this->formatDecimal($query2->result_array()[0]['MAY']);
                $json['data'][$i]['JUN'] = $this->formatDecimal($key['JUN']);
                $json['data'][$i]['JUN2'] = $this->formatDecimal($query2->result_array()[0]['JUN']);
                $json['data'][$i]['JUL'] = $this->formatDecimal($key['JUL']);
                $json['data'][$i]['JUL2'] = $this->formatDecimal($query2->result_array()[0]['JUL']);
                $json['data'][$i]['AGO'] = $this->formatDecimal($key['AGO']);
                $json['data'][$i]['AGO2'] = $this->formatDecimal($query2->result_array()[0]['AGO']);
                $json['data'][$i]['SEP'] = $this->formatDecimal($key['SEP']);
                $json['data'][$i]['SEP2'] = $this->formatDecimal($query2->result_array()[0]['SEP']);
                $json['data'][$i]['OCT'] = $this->formatDecimal($key['OCT']);
                $json['data'][$i]['OCT2'] = $this->formatDecimal($query2->result_array()[0]['OCT']);
                $json['data'][$i]['NOV'] = $this->formatDecimal($key['NOV']);
                $json['data'][$i]['NOV2'] = $this->formatDecimal($query2->result_array()[0]['NOV']);
                $json['data'][$i]['DIC'] = $this->formatDecimal($key['DIC']);
                $json['data'][$i]['DIC2'] = $this->formatDecimal($query2->result_array()[0]['DIC']);         
                $i++;
            }    
        }
        
            $json['columns'][0]['data'] = "ENE";
            $json['columns'][0]['name'] = "ENE";
            $json['columns'][1]['data'] = "ENE2";
            $json['columns'][1]['name'] = "PTS";

            $json['columns'][2]['data'] = "FEB";
            $json['columns'][2]['name'] = "FEB";
            $json['columns'][3]['data'] = "FEB2";
            $json['columns'][3]['name'] = "PTS";

            $json['columns'][4]['data'] = "MAR";
            $json['columns'][4]['name'] = "MAR";
            $json['columns'][5]['data'] = "MAR2";
            $json['columns'][5]['name'] = "PTS";

            $json['columns'][6]['data'] = "ABR";
            $json['columns'][6]['name'] = "ABR";
            $json['columns'][7]['data'] = "ABR2";
            $json['columns'][7]['name'] = "PTS";

            $json['columns'][8]['data'] = "MAY";
            $json['columns'][8]['name'] = "MAY";
            $json['columns'][9]['data'] = "MAY2";
            $json['columns'][9]['name'] = "PTS";

            $json['columns'][10]['data'] = "JUN";
            $json['columns'][10]['name'] = "JUN";
            $json['columns'][11]['data'] = "JUN2";
            $json['columns'][11]['name'] = "PTS";

            $json['columns'][12]['data'] = "JUL";
            $json['columns'][12]['name'] = "JUL";
            $json['columns'][13]['data'] = "JUL2";
            $json['columns'][13]['name'] = "PTS";

            $json['columns'][14]['data'] = "AGO";
            $json['columns'][14]['name'] = "AGO";
            $json['columns'][15]['data'] = "AGO2";
            $json['columns'][15]['name'] = "PTS";


            $json['columns'][16]['data'] = "SEP";
            $json['columns'][16]['name'] = "SEP";
            $json['columns'][17]['data'] = "SEP2";
            $json['columns'][17]['name'] = "PTS";

            $json['columns'][18]['data'] = "OCT";
            $json['columns'][18]['name'] = "OCT";
            $json['columns'][19]['data'] = "OCT2";
            $json['columns'][19]['name'] = "PTS";

            $json['columns'][20]['data'] = "NOV";
            $json['columns'][20]['name'] = "NOV";
            $json['columns'][21]['data'] = "NOV2";
            $json['columns'][21]['name'] = "PTS";

            $json['columns'][22]['data'] = "DIC";
            $json['columns'][22]['name'] = "DIC";
            $json['columns'][23]['data'] = "DIC2";
            $json['columns'][23]['name'] = "PTS";

        echo json_encode($json);
        $this->sqlsrv->close();
    }
    public function canje_premios($fecha1,$fecha2)
    {
        $i=0;
        $json = array();
        $query = $this->db->query("SELECT * FROM view_canje_premios WHERE FECHA BETWEEN '".$fecha1."' AND '".$fecha2."'");
        
        foreach($query->result_array() as $key){
            $json['data'][$i]['FRP'] = '<p class="negra noMargen">'.$key['IdFRP']."</p>";
            $json['data'][$i]['FECHA'] = date('d-m-Y',strtotime($key['Fecha']));
            $json['data'][$i]['CODIGO'] = $key['IdCliente'];
            $json['data'][$i]['NOMBRE'] = '<p class="bold noMargen">'.$key['Nombre']."</p>";
            $json['data'][$i]['ARTICULO'] = '<p class="bold noMargen">'.$this->formatDecimal($key['Descripcion'])."</p>";
            $json['data'][$i]['PUNTOS'] = number_format($this->formatDecimal(str_replace(".0000","",$key['PUNTO'])),0);
            $json['data'][$i]['CANTIDAD'] = $this->formatDecimal(str_replace(".0000","",$key['CANTIDAD']));       
            $i++;
        }
            $json['columns'][0]['data'] = "FRP";
            $json['columns'][0]['name'] = "FRP";
            $json['columns'][1]['data'] = "FECHA";
            $json['columns'][1]['name'] = "FECHA";
            $json['columns'][2]['data'] = "CODIGO";
            $json['columns'][2]['name'] = "CODIGO";
            $json['columns'][3]['data'] = "NOMBRE";
            $json['columns'][3]['name'] = "NOMBRE";
            $json['columns'][4]['data'] = "ARTICULO";
            $json['columns'][4]['name'] = "ARTICULO";
            $json['columns'][5]['data'] = "PUNTOS";
            $json['columns'][5]['name'] = "PUNTOS";
            $json['columns'][6]['data'] = "CANTIDAD";
            $json['columns'][6]['name'] = "CANTIDAD";
        echo json_encode($json);
        $this->sqlsrv->close();
    }
    public function detalles_canje($fecha1,$fecha2)
    {
        $i=0;
        $json = array();
        $query = $this->db->query("SELECT * FROM view_canje_premios
                                    WHERE FECHA BETWEEN '".$fecha1."' AND '".$fecha2."'");
        
        foreach($query->result_array() as $key){
            $numero=$i+1;
            $json['data'][$i]['NUMERO'] = '<p class="bold noMargen">'.$numero."</p>";
            $json['data'][$i]['FECHA'] = date('d-m-Y',strtotime($key['Fecha']));
            $json['data'][$i]['CODIGO'] = $key['IdFRP'];
            $json['data'][$i]['CLIENTE'] = $key['IdCliente'];
            $json['data'][$i]['PUNTOS'] = $key['CANTIDAD']*$key['PUNTO'];
            $json['data'][$i]['NOMBRE'] = '<p class="bold noMargen">'.$key['Descripcion']."</p>";
            $json['data'][$i]['CANTIDAD'] = str_replace(".0000", "", $key['CANTIDAD']);
            $i++;
        }
            $json['columns'][0]['data'] = "NUMERO";
            $json['columns'][0]['name'] = "NUMERO";
            $json['columns'][1]['data'] = "FECHA";
            $json['columns'][1]['name'] = "FECHA";
            $json['columns'][2]['data'] = "CODIGO";
            $json['columns'][2]['name'] = "COD FRP";
            $json['columns'][3]['data'] = "CLIENTE";
            $json['columns'][3]['name'] = "CLIENTE";
            $json['columns'][4]['data'] = "NOMBRE";
            $json['columns'][4]['name'] = "NOMBRE";
            $json['columns'][5]['data'] = "CANTIDAD";
            $json['columns'][5]['name'] = "CANTIDAD";
            $json['columns'][6]['data'] = "PUNTOS";
            $json['columns'][6]['name'] = "PUNTOS";
        echo json_encode($json);
        $this->sqlsrv->close();
    }
    public function informeFactura($factura)
    {
        $i=0;
        $json = array();
        $query = $this->db->query("SELECT * FROM view_informeFacturas
                                    WHERE FACTURA = '".$factura."'");
                $json['data'][$i]['FACTURA'] = "-";
                $json['data'][$i]['FECHA'] = "-";
                $json['data'][$i]['CLIENTE'] = "-";
                $json['data'][$i]['CODIGO'] = "NO HAY DATOS";
                $json['data'][$i]['PUNTOS'] = "-";
                $json['data'][$i]['APLICADO'] = "-";
                $json['data'][$i]['VER'] = "-";
        if ($query->num_rows()>0) {
            foreach($query->result_array() as $key){            
                $json['data'][$i]['FACTURA'] = '<p class="negra noMargen">'.$key['Factura'].'</p>';
                $json['data'][$i]['FECHA'] = date('d-m-Y',strtotime($key['Fecha']));
                $json['data'][$i]['CLIENTE'] = $key['IdCliente'];
                $json['data'][$i]['CODIGO'] = '<p class="negra noMargen">'.$key['IdFRP'].'</p>';
                $json['data'][$i]['PUNTOS'] = $key['Faplicado'];
                $json['data'][$i]['APLICADO'] = $key['PUNTOS'];
                $json['data'][$i]['VER'] = "<a   href='".base_url()."index.php/ExpFRP/".$key['IdFRP']."' target='_blank' class='noHover'><i class='material-icons'>&#xE417;</i></a>";
                $i++;
            }
        }
        echo json_encode($json);
        $this->sqlsrv->close();
    }
}