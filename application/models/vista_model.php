<?php
class Vista_model extends CI_Model
{
    public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    /* VISTA USUARIO*/
    public function LoadUser(){ /*CARGAR USUARIOS*/
        $this->db->select('*');
        $this->db->from('usuario');
        $query = $this->db->get();

        if($query->num_rows() > 0){
            return $query->result_array();
        }else{
            return 0;
        }
    }

    public  function  LoadRol() {/*CARGAR ROLES*/
        $this->db->select('*');
        $this->db->from('Roles');
        $query = $this->db->get();

        if($query->num_rows() > 0){
            return $query->result_array();
        }else{
            return 0;
        }
    }

    public function LoadVendedor() {/*CARGAR VENDEDOR*/
        $this->db->select('*');
        $this->db->from('Vendedor');
        $this->db->where('Estado',0);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result_array();
        }else{
            return 0;
        }
    }

    public function LoadClient(){ /* CARGAR CLIENTES */
      $query = $this->sqlsrv -> fetchArray("SELECT CLIENTE, NOMBRE, VENDEDOR FROM Softland.umk.CLIENTE WHERE (ACTIVO = 'S')
      AND (RUBRO1_CLI = 'S')",SQLSRV_FETCH_ASSOC);
      $json = array();
        $i=0;

         foreach ($query as $key)
         {
             $json['data'][$i]['nombre'] = $key['NOMBRE'];
             $i++;
         }
         return $json;

        $this->sqlsrv->close();
    }

    public function addUser($nombre, $clave, $rol, $fecha, $vendedor) {/*CREACIÓN DE USUARIOS*/
        $Usuario = array(
            'Nombre' => $nombre,
            'Clave' => $clave,
            'Rol' => $rol,
            'Estado' =>0,
            'FechaCreacion' => $fecha,
            'Zona' => $vendedor);

        $query = $this->db->insert('usuario', $Usuario);

        if ($query) {
            return 1;
        } else {
            return 0;
        }
    }

    public function ActUser($cod,$estado){ /* CAMBIAR ESTADO DEL USUARIO*/

        $data = array(
            'Estado' => !$estado,
            'FechaBaja' =>date('Y-m-d H:i:s')
        );

        $this->db->where('IdUsuario', $cod);
        $this->db->update('usuario',$data);
    }
}