<?php
class Usuario_model extends CI_Model
{
    public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    /* VISTA USUARIO*/
    public function LoadUser(){ /*CARGAR USUARIOS*/
        $this->db->select('*');
        $this->db->from('usuario');
        $this->db->order_by('IdUsuario','desc');
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

        $this->load->model('cliente_model');

        $query = $this->sqlsrv -> fetchArray("SELECT CLIENTE, NOMBRE, VENDEDOR FROM vtVS2_Clientes WHERE CLIENTE NOT IN(".$this->cliente_model->LoadAllClients().") AND(ACTIVO = 'S') AND (RUBRO1_CLI = 'S')",SQLSRV_FETCH_ASSOC);

        $json = array();
        $i=0;
        echo '<option value="" disabled selected> BUSCAR... </option>';
         foreach ($query as $key)
         {
             //$json['query'][$i]['NOMBRE']=$key['NOMBRE'];
            echo '<option value="'.$key['NOMBRE'].'">'.$key['NOMBRE'].'</option>';
             $i++;
         }
       //return $json;
        $this->sqlsrv->close();
    }

    public function LoadVendedores(){ /* CARGAR CLIENTES */
        $query = $this->sqlsrv -> fetchArray("SELECT VENDEDOR, NOMBRE FROM Softland.umk.VENDEDOR WHERE  (VENDEDOR LIKE 'F%')",SQLSRV_FETCH_ASSOC);
        $json= array();
        $i=0;
        echo '<option value="" disabled selected> BUSCAR... </option>';
        foreach ($query as $key)
        {
            //$json['query'][$i]['NOMBRE']=$key['NOMBRE'];
            echo '<option value="'.$key['NOMBRE'].'">'.$key['NOMBRE'].'</option>';
            $i++;
        }
        //return $json;
        $this->sqlsrv->close();
    }

    public function AddCl($user,$clave,$rol,$fecha,$vendedor,$cliente,$nomCliente){

        $q = $this->verificarUser($user,$clave);
        if ($q == 1) {
            $user = array(
                'Usuario'=> $user,
                'Clave' => MD5($clave),
                'Rol' => $rol,
                'Estado'=>0,
                'FechaCreacion' => $fecha,
                'IdCL' =>$cliente,
                'Cliente' => $nomCliente,
                'Zona' => $vendedor,
                'Nombre' => $user
            );    
            if ($user !="" && $q == 1) {
                $query = $this->db->insert('usuario', $user);
                echo  "1";
            } 
        }
        else if ($q == 0){
            echo "ESTE USUARIO YA ESTA REGISTRADO";
        }else{
            echo "ERROR AL CREAR EL USUARIO";
        }
    }

    public function AddVdor($user,$clave,$rol,$fecha,$zona){

        $q = $this->verificarUser($user,$clave);
        if ($q == 1) {
            $user = array(
                'Usuario'=> $zona,
                'Clave' => md5($clave),
                'Rol' => $rol,
                'FechaCreacion' => $fecha,
                'Estado'=>0,
                'Zona' => $zona,
                'Nombre' => $user
            );
            $query = $this->db->insert('usuario', $user);
            if ($query) {            
                echo  "1";
            } 
        }
        else if ($q == 0){
            echo "ESTE USUARIO YA ESTA REGISTRADO";
        }else{
            echo "ERROR AL CREAR EL USUARIO";
        }
    }

    public function addUser($user, $clave, $rol, $fecha) {
        $q = $this->verificarUser($user,$clave);//echo $q;
        if ($q == 1) {
            $Usuario = array(
            'Usuario' => $user,
            'Clave' => MD5($clave),
            'Rol' => $rol,
            'Estado' =>0,
            'FechaCreacion' => $fecha,
            'Nombre' => $user);

            $query = $this->db->insert('usuario', $Usuario);
            if ($query) {
                echo  "1";
            }
        }
        else if ($q == 0){
            echo "ESTE USUARIO YA ESTA REGISTRADO";
        }else{
            echo "ERROR AL CREAR EL USUARIO";
        }
    }

    public function verificarUser($user,$pass)
    {
        $this->db->where('Nombre',$user);
        $this->db->where('Clave',MD5($pass));
        $query = $this->db->get('usuario');
        if ($query->num_rows()>0) {
            return 0;
        }else{
            return 1;
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