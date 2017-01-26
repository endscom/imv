<?php
class Canje_efectivo_model extends CI_Model
{
    public function __construct(){
        parent::__construct();
        $this->load->database();
    }
	public $CONDICION = '2015-06-01';
    public function getFacturaFRE($idCliente)
    {   
        $query="";
        $q_rows = $this->db->query("call pc_Clientes_Facturas ('".$idCliente."')");
        if ($q_rows->num_rows() > 0) {
            $query = "SELECT FECHA,FACTURA,SUM(TT_PUNTOS) AS DISPONIBLE FROM vtVS2_Facturas_CL
                    WHERE CLIENTE = '".$idCliente."' AND FECHA >= '".$this->CONDICION."' AND FACTURA NOT IN(".$q_rows->result_array()[0]['Facturas'].")";
                    //echo "entro en el 1er if <br>";
        }
        $q_rows->next_result();
        $q_rows->free_result();

        $q_rows = $this->db->query("call pc_Clientes_Facturas_Fre ('".$idCliente."')");
        if ($q_rows->num_rows() > 0) {
            if ($query=="") {
                $query = "SELECT FECHA,FACTURA,SUM(TT_PUNTOS) AS DISPONIBLE FROM vtVS2_Facturas_CL
                    WHERE CLIENTE = '".$idCliente."' AND FECHA >= '".$this->CONDICION."' AND FACTURA NOT IN (".$q_rows->result_array()[0]['Facturas'].") GROUP BY FACTURA, FECHA";
                    //echo "entro en el 2do if <br>";
                    
            }else{
                $query .= " AND FACTURA NOT IN (".$q_rows->result_array()[0]['Facturas'].") GROUP BY FACTURA, FECHA";

            }
        }
        else if ($query==""){
            $query = "SELECT FECHA,FACTURA,SUM(TT_PUNTOS) AS DISPONIBLE FROM vtVS2_Facturas_CL
                    WHERE CLIENTE = '".$idCliente."' AND FECHA >= '".$this->CONDICION."' GROUP BY FACTURA, FECHA ";
        }else{
            $query .=" GROUP BY FACTURA, FECHA";
        }
        //echo "query----->".$query."<br>";
		$q_rows->next_result();
        $q_rows->free_result();
        $query = $this->sqlsrv->fetchArray($query,SQLSRV_FETCH_ASSOC);
        $json = array();
        $i=0;

        $json['data'][$i]['FECHA']      = "SIN DATOS";
        $json['data'][$i]['FACTURA']    = "";
        $json['data'][$i]['DISPONIBLE'] = "";
        $json['data'][$i]['PUNTOS']     = "";
        $json['data'][$i]['EFECTIVO']   = "";
        $json['data'][$i]['OPCION']     = "";


        foreach($query as $key){
        	$ID_ROW = "CHK" . $key['FACTURA'];
        	$ID_LBL = "LBL" . $key['FACTURA'];

            $json['data'][$i]['FECHA']      = $key['FECHA']->format('Y-m-d');
            $json['data'][$i]['FACTURA']    = $key['FACTURA'];
            $json['data'][$i]['DISPONIBLE'] = intval($this->getSaldoParcial($key['FACTURA'],$key['DISPONIBLE']));
            $json['data'][$i]['EFECTIVO']   = intval($this->getSaldoParcial($key['FACTURA'],$key['DISPONIBLE'])/2);
            $json['data'][$i]['OPCION']     = "<p><input type='checkbox' onclick='isVerificar(".$i.','.'"'.$key['FACTURA'].'"'.")' id='".$ID_ROW."' /><label 								id='".$ID_LBL."' for='".$ID_ROW."'></label></p>";
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
    public function BuscaFRE($FRE) {
            $this->db->select('IdFRE');
            $this->db->from('fre');
            $this->db->where('IdFRE',$FRE);
            $this->db->where('Anulado','N');
            $query = $this->db->get();        
        if($query->num_rows() > 0){
            return $query->result_array()[0]['IdFRE'];
        }else{
            return 0;
        }
    }
    public function save($frp,$fact,$log){
        $frp = array(
            'IdFRE'     => $frp[0],
            'Fecha'     => date_format(date_create($frp[1]), 'Y-m-d H:i:s'),
            'IdCliente' => $frp[2],
            'Nombre'    => $frp[3],
            'IdUsuario' => $_SESSION['id'],
            'Anulado'   => "N",
            'Comentario'   => $frp[4]
        );
         $q = $this->db->insert('fre', $frp);

        for ($f=0; $f < count($fact); $f++) {
            $Facturas = explode(",",$fact[$f]);
            $InsertDetalles = array(
                'IdFRE'         => $Facturas[0],
                'Factura'       => $Facturas[1],
                'Fecha'         => $Facturas[2],
                'Puntos'        => $Facturas[3],
                'Efectivo'      => $Facturas[4]
            );
             $q = $this->db->insert('detallefre', $InsertDetalles);
        }

        for ($l=0; $l < count($log); $l++) {
            $Faclog = explode(",",trim($log[$l]));
            $this->db->query("call pc_RFactura ('".$Faclog[1]."','".$Faclog[3]."','".$Faclog[0]."','".date('Y-m-d h:i:s')."','".$Faclog[3]."')");
        }

        if ($q) {
            return 1;
        } else { 
            return 0;
        }
    }
    public function traerAllFRE()
    {
        $query = $this->db->get('view_all_fre');
        if ($query->num_rows() >0) {
            return $query->result_array();
        }
        return 0;
    }
    public function getFRE($id,$tabla){
        $this->db->where('IdFRE', $id);
        $query = $this->db->get($tabla);
        
        if($query->num_rows() > 0){
            return $query->result_array();
        }
        return 0;
    }
    public function inactivar($id){
        $this->FREInac($id);
        $this->db->where('IdFRE',$id);
        $this->db->delete('detallefre', array('IdFRE' => $id));
        return $this->db->delete('fre', array('IdFRE' => $id));
        //if ($this->db->update('fre',array('Anulado' => 'S'))) {
        //return $this->db->query("CALL pc_MFactura ('".$id."'')");
        //}
    }
    public function FREInac($fre){
        $this->db->where('IdFRE',$fre);
        $query = $this->db->get('detallefre');
        
        foreach ($query->result_array() as $row){
            $this->db->query("call pc_MFactura ('".$row['Factura']."','".$row['Puntos']."','".date('Y-m-d h:i:s')."')");
        }
    }
}
?>