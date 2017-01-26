<?php
class Canje_model extends CI_Model
{
    public function __construct(){
        parent::__construct();
        $this->load->database();
    }
    public $CONDICION = '2015-06-01';
    public function getAplicadoP($idCliente)
    {
        
       $query = $this->sqlsrv->fetchArray("SELECT SUM(TT_PUNTOS) AS PUNTOS FROM PRODUCCION.dbo.vtVS2_Facturas_CL
                                         WHERE CLIENTE = '".$idCliente."' and FECHA >= '".$this->CONDICION."'",SQLSRV_FETCH_ASSOC);
       
        $i=0;
        $json = array();
        $PUNTOS=0;        
        foreach($query as $key){
            $PUNTOS = $key['PUNTOS'];            
            $i++;
        }
        $query = $this->db->query("call pc_clientes_pa ('".$idCliente."')");
        
        if($query->num_rows() > 0){
            $Arestar = $query->result_array()[0]['Puntos'];
        }else{
            $Arestar = 0;
        }
        $query->next_result();
        $query->free_result();
        $query = $this->db->query("call pc_clientes_pe ('".$idCliente."')");
        if($query->num_rows() > 0){
            $Arestar += $query->result_array()[0]['Puntos'];
        }
        echo  intval($PUNTOS) - intval($Arestar);
        $this->sqlsrv->close();
    }
    public function getFacturaFRP($idCliente)
    {   $query="";
        $q_rows = $this->db->query("call pc_Clientes_Facturas ('".$idCliente."')");
        if ($q_rows->num_rows() > 0) {
            $query = "SELECT FECHA,FACTURA,SUM(TT_PUNTOS) AS DISPONIBLE FROM vtVS2_Facturas_CL
                    WHERE CLIENTE = '".$idCliente."' AND FACTURA NOT IN(".$q_rows->result_array()[0]['Facturas'].") AND FECHA >= '".$this->CONDICION."'";
        }
        $q_rows->next_result();
        $q_rows->free_result();

        $q_rows = $this->db->query("call pc_Clientes_Facturas_Fre ('".$idCliente."')");
        if ($q_rows->num_rows() > 0) {
            if ($query=="") {
                $query = "SELECT FECHA,FACTURA,SUM(TT_PUNTOS) AS DISPONIBLE FROM vtVS2_Facturas_CL
                    WHERE CLIENTE = '".$idCliente."' AND FACTURA NOT IN (".$q_rows->result_array()[0]['Facturas'].") and FECHA >= '".$this->CONDICION."'";
            }else{
                $query .= " AND FACTURA NOT IN (".$q_rows->result_array()[0]['Facturas'].")";
            }
        }
        if ($query==""){
            $query = "SELECT FECHA,FACTURA,SUM(TT_PUNTOS) AS DISPONIBLE FROM vtVS2_Facturas_CL
                    WHERE CLIENTE = '".$idCliente."' AND FECHA >= '".$this->CONDICION."'";
        }
        $query .= "GROUP BY FACTURA,FECHA";
        //echo $query."<br>";
        $q_rows->next_result();
        $q_rows->free_result();
        $query = $this->sqlsrv->fetchArray($query,SQLSRV_FETCH_ASSOC);
        $json = array();
        $i=0;

        $json['data'][$i]['FECHA']      = "SIN DATOS";
        $json['data'][$i]['FACTURA']    = "";
        $json['data'][$i]['DISPONIBLE'] = "";
        $json['data'][$i]['CAM1']       = "";
        $json['data'][$i]['CAM2']       = "";
        $json['data'][$i]['CAM3']       = "";
        $json['data'][$i]['CAM4']       = "";
        
        foreach($query as $key){
            $ID_ROW = "CHK" . $key['FACTURA'];
            $ID_LBL = "LBL" . $key['FACTURA'];
            $ID_APl = "AP1" . $key['FACTURA'];
            $ID_DIS = "DIS" . $key['FACTURA'];
            $ID_EST = "EST" . $key['FACTURA'];

            $json['data'][$i]['FECHA']      = $key['FECHA']->format('Y-m-d');

            $json['data'][$i]['FACTURA']    = $key['FACTURA'];
            $json['data'][$i]['DISPONIBLE'] = intval($this->getSaldoParcial($key['FACTURA'],$key['DISPONIBLE']));
            $json['data'][$i]['CAM1']       = "<span id='".$ID_APl."'></span>";
            $json['data'][$i]['CAM2']       = "<span id='".$ID_DIS."'></span>";
            $json['data'][$i]['CAM3']       = "<p><input type='checkbox' onclick='isVerificar(".$i.','.'"'.$key['FACTURA'].'"'.")' id='".$ID_ROW."' /><label id='".$ID_LBL."' for='".$ID_ROW."'></label></p>";
            $json['data'][$i]['CAM4']       = "<span id='".$ID_EST."'></span>";
            $i++;
        }
        echo json_encode($json);
        return $json;
    }
    public function getSaldoParcial($id,$pts){
        $this->db->where('Puntos <>',0);
        $this->db->where('Factura',$id);
        $this->db->select('Puntos');
        $query = $this->db->get('rfactura');
        if($query->num_rows() > 0){
            $parcial = $query->result_array()[0]['Puntos'];
        } else {
            $parcial = $pts;
        }
        return $parcial;
    }
    public function getSaldo($id,$pts){
        //$this->db->where('Puntos <>',0);
        $this->db->where('Factura',$id);
        $this->db->select('Puntos');
        $query = $this->db->get('rfactura');
        if($query->num_rows() > 0){
            $parcial = $query->result_array()[0]['Puntos'];
        } else {
            $parcial = $pts;
        }
        return $parcial;
    }
    public function BuscaFRP($FRP) {//BUSCA SI EXISTE UN FRP EN LA BASE DE MYSQL BY CEREBRO
        $this->db->select('IdFRP');
        $this->db->from('frp');
        $this->db->where('IdFRP',$FRP);
        $query = $this->db->get();        
        if($query->num_rows() > 0){
            return $query->result_array()[0]['IdFRP'];
        }else{
            return 0;
        }
    }
    public function save($top,$art,$fact,$log){
        $this->db->where('Estado',0);
        $query = $this->db->get('catalogo');

        if ($query->num_rows()>0) {
            $top = array(
                'IdFRP'     => $top[0],
                'Fecha'     => date_format(date_create($top[1]), 'Y-m-d H:i:s'),
                'IdCliente' => $top[2],
                'Nombre'    => $top[3],
                'IdUsuario' => $_SESSION['id'],
                'Anulado'   => "N",
                'IdCT'   => $query->result_array()[0]['IdCT']
            );

            $q = $this->db->insert('frp', $top);
            //print_r($fact);
            for ($f=0; $f < count($fact); $f++) {
                $Facturas = explode(",",$fact[$f]);
                $InsertArticulos = array(
                    'IdFRP'         => $Facturas[0],
                    'Factura'       => $Facturas[1],
                    'Faplicado'     => $Facturas[2],
                    'IdArticulo'    => $Facturas[3],
                    'Descripcion'   => $Facturas[4],
                    'Puntos'        => $Facturas[5],
                    'Cantidad'      => $Facturas[6],
                    'Fecha'         => $Facturas[7],
                    'IdCT'   => $query->result_array()[0]['IdCT']
                );
                //echo $Facturas[3]."<br>";
                $q = $this->db->insert('detallefrp', $InsertArticulos);
            }

            for ($l=0; $l < count($log); $l++) {
                $Faclog = explode(",",trim($log[$l]));
                $this->db->query("call pc_RFactura ('".$Faclog[1]."','".$Faclog[2]."','".$Faclog[0]."','".date('Y-m-d h:i:s')."','".$Faclog[3]."')");
            }

            if ($q) { return 1;
            }
        }
        else { return 0;
        }
    }
    public function getBCMora($idCliente) {
       $MORA = '';

       $query = $this->sqlsrv->fetchArray("SELECT MOROSO FROM PRODUCCION.dbo.vtVS2_Clientes
                                           WHERE CLIENTE = '".$idCliente."'",SQLSRV_FETCH_ASSOC);
        echo $query[0]['MOROSO'];
        $this->sqlsrv->close();
    }
    public function getPtsItem($codigo){
        $valor = 0;
        $this->db->where('IdIMG',$codigo);
        $query = $this->db->get('view_catalogo_activo');
        if ($query->num_rows() >0) {
            foreach ($query->result_array() as $row){
                $valor =  $row['Puntos'];
            }
        }
        echo $valor;
    }
    public function getAllFRP(){
        $query = $this->db->get('frp');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return 0;
    }
    public function getFRP($id,$tabla){
        $this->db->where('IdFRP', $id);
        $query = $this->db->get($tabla);
        
        if($query->num_rows() > 0){
            return $query->result_array();
        }
        return 0;
    }
    public function inactivar($id){
        $this->FRPInac($id);
        $this->db->where('IdFRP',$id);
        return $this->db->update('frp',array('Anulado' => 'S'));
    }
    public function FRPInac($FRP){
        $this->db->where('IdFRP',$FRP);
        $query = $this->db->get('detalleFRP');
        
        foreach ($query->result_array() as $row){
            $this->db->query("call pc_MFactura ('".$row['Factura']."','".$row['Puntos']."','".date('Y-m-d h:i:s')."')");
        }     
    }
}
?>