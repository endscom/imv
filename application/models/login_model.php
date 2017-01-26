<?php 
class Login_model extends CI_Model
{
    public function __construct(){
        parent::__construct();
        $this->load->database();
    }
    
    public function index(){
        $this->load->view('header/header_login');
        $this->load->view('paginas/login');
        $this->load->view('footer/footer_login');
    }

    public function login($name, $pass ){
        if($name != FALSE && $pass != FALSE){
            $this->db->where('Vendedor', $name);
            $this->db->where('Password',$pass);
            $this->db->where('Activo',0);

            $query = $this->db->get('usuario');

            if($query->num_rows() == 1){
                echo "asdas";
                return $query->result_array();
            }
            return 0;
        }
    }
    public function cambiarPass($pass,$id)
    {
        $datos = array('Clave' => MD5($pass));
        $this->db->where('IdUsuario',$id);
        $query = $this->db->update('usuario',$datos);
        if ($query) {
            return 1;
        }return 0;
    }


}