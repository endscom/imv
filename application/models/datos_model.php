<?php
class datos_model extends CI_Model
{
    public function __construct(){
        parent::__construct();
        $this->load->database();
    }
    public function metaCuota($tipo,$fecha)
    {
    	$query = $this->db->query("SELECT * FROM metacuota WHERE MONTH(Fecha) = '".date('m',strtotime($fecha))."'
    								 AND YEAR(Fecha)='".date('Y',strtotime($fecha))."' AND Tipo = '".$tipo."'");
    	if ($query->num_rows() == 0) {
    		$datos = array('Tipo' => $tipo,
    						'Descripcion' => $tipo." - ".$fecha,
    						'Fecha' => date('Y-m-d',strtotime($fecha))
    						);
    		$this->db->insert('MetaCuota',$datos);
    	}
    	$query = $this->db->query("SELECT MAX(IdPeriodo) AS IdPeriodo FROM MetaCuota WHERE MONTH(Fecha) = '".date('m',strtotime($fecha))."'
    							AND YEAR(Fecha)='".date('Y',strtotime($fecha))."' AND Tipo = '".$tipo."'");
    	if ($tipo == 'META') {
    		$this->db->delete('metas', array('IdPeriodo' => $query->result_array()[0]['IdPeriodo']));
    	}else{
    		$this->db->delete('cuotaxproducto', array('IdPeriodo' => $query->result_array()[0]['IdPeriodo']));	
    	}    	
    }
    public function subir($CodVendedor,$NombreVendedor,$Cliente,$NombreCliente,$MVenta,$NumFact,$MFactura,$Promedio)
    {
    	$query = $this->db->query("SELECT MAX(IdPeriodo) AS IdPeriodo FROM MetaCuota WHERE Tipo = 'META'");
    	$datos = array('CodVendedor' => $CodVendedor,
    					'NombreVendedor' => $NombreVendedor,
    					'CodCliente' => $Cliente,
    					'NombreCliente' => $NombreCliente,
    					'MontoVenta' => $MVenta,
    					'NumItemFac' => $NumFact,
    					'MontoXFac' => $MFactura,
    					'PromItemXFac' => $Promedio,
    					'Usuario' => $this->session->userdata('id'),
    					'FHGrabacion' => date('Y-m-d'),
    					'IdPeriodo' => $query->result_array()[0]['IdPeriodo']
    				);
    	$this->db->insert('metas',$datos);
    }
    public function subir2($CodVendedor,$NombreVendedor,$CodProducto,$NombreProducto,$meta)
    {
    	$query = $this->db->query("SELECT MAX(IdPeriodo) AS IdPeriodo FROM MetaCuota WHERE Tipo = 'CUOTA'");
    	$datos = array('CodVendedor' => $CodVendedor,
    					'NombreVendedor' => $NombreVendedor,
    					'CodProducto' => $CodProducto,
    					'NombreProducto' => utf8_encode($NombreProducto),
                        'Meta' => $meta,
    					'FHGrabacion' => date('Y-m-d'),
    					'IdPeriodo' => $query->result_array()[0]['IdPeriodo']
    				);
    	$this->db->insert('cuotaxproducto',$datos);
    }
    public function vistaPrevia($fecha,$tabla,$tipo)
    {
        $query = $this->db->query("SELECT * FROM metacuota WHERE MONTH(Fecha) = '".date('m',strtotime($fecha))."'
                                     AND YEAR(Fecha)='".date('Y',strtotime($fecha))."' AND Tipo = '".$tipo."'");
        if ($query->num_rows() > 0) {
            $this->db->where('IdPeriodo',$query->result_array()[0]['IdPeriodo']);
            $query = $this->db->get($tabla);
            if ($query->num_rows() > 0) {
                return $query->result_array();
            }
        }return 0;
    }
    public function descartarDatos($id,$tabla)
    {
        $this->db->delete($tabla, array('IdPeriodo' => $id));
        $this->db->delete('metacuota', array('IdPeriodo' => $id));
    }
    public function getDatos()
    {
        $query = $this->db->get('metacuota');
        if ($query->num_rows()>0) {
            return $query->result_array();
        }return 0;
    }
    public function viewDatos($id,$tipo)
    {
        $vista = ($tipo=="META") ? 'view_metas' : 'view_cuotas';
        $i=0;
        $json = array();
        $query = $this->db->query("SELECT * FROM ".$vista." WHERE IdPeriodo = ".$id." ");
          
        if ($query->num_rows()>0) {            
    
              if ($tipo=="META") {
                foreach($query->result_array() as $key){
                    $json['data'][$i]['Tipo'] = $key['Tipo'];
                    $json['data'][$i]['CodVendedor'] = $key['CodVendedor'];
                    $json['data'][$i]['NombreVendedor'] = $key['NombreVendedor'];
                    $json['data'][$i]['CodCliente'] = $key['CodCliente'];
                    $json['data'][$i]['NombreCliente'] = $key['NombreCliente'];
                    $json['data'][$i]['MontoVenta'] = number_format($key['MontoVenta'],0);
                    $json['data'][$i]['NumItemFac'] = $key['NumItemFac'];
                    $json['data'][$i]['MontoXFac'] = number_format($key['MontoXFac'],0);
                    $json['data'][$i]['PromItemXFac'] = $key['PromItemXFac'];
                    $i++;
                }    
                $json['columns'][0]['data'] = "Tipo";
                $json['columns'][0]['name'] = "TIPO";
                $json['columns'][1]['data'] = "CodVendedor";
                $json['columns'][1]['name'] = "COD. VENDEDOR";
                $json['columns'][2]['data'] = "NombreVendedor";
                $json['columns'][2]['name'] = "VENDEDOR";
                $json['columns'][3]['data'] = "CodCliente";
                $json['columns'][3]['name'] = "COD CLIENTE";
                $json['columns'][4]['data'] = "NombreCliente";
                $json['columns'][4]['name'] = "CLIENTE";
                $json['columns'][5]['data'] = "MontoVenta";
                $json['columns'][5]['name'] = "MONTO VENTA";
                $json['columns'][6]['data'] = "NumItemFac";
                $json['columns'][6]['name'] = "NUM. ITEM X FACTURA";
                $json['columns'][7]['data'] = "MontoXFac";
                $json['columns'][7]['name'] = "MONTO X FACTURA";
                $json['columns'][8]['data'] = "PromItemXFac";
                $json['columns'][8]['name'] = "PROMEDIO ITEM X FACTURA";
            }else{
                foreach($query->result_array() as $key){
                    $json['data'][$i]['Tipo'] = $key['Tipo'];
                    $json['data'][$i]['CodVendedor'] = $key['CodVendedor'];
                    $json['data'][$i]['NombreVendedor'] = $key['NombreVendedor'];
                    $json['data'][$i]['CodProducto'] = $key['CodProducto'];
                    $json['data'][$i]['NombreProducto'] = $key['NombreProducto'];
                    $json['data'][$i]['Meta'] = $key['Meta'];                 
                    $i++;
                }    
                $json['columns'][0]['data'] = "Tipo";
                $json['columns'][0]['name'] = "TIPO";
                $json['columns'][1]['data'] = "CodVendedor";
                $json['columns'][1]['name'] = "COD. VENDEDOR";
                $json['columns'][2]['data'] = "NombreVendedor";
                $json['columns'][2]['name'] = "VENDEDOR";
                $json['columns'][3]['data'] = "CodProducto";
                $json['columns'][3]['name'] = "COD PRODUCTO";
                $json['columns'][4]['data'] = "NombreProducto";
                $json['columns'][4]['name'] = "DESCRIPCIÓN";
                $json['columns'][5]['data'] = "Meta";
                $json['columns'][5]['name'] = "META";
            }
        echo json_encode($json);
    }
    }
}
?>