<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clientes_controller extends CI_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->library('session');

        if($this->session->userdata('logged')==0){ //No aceptar a usuarios sin loguearse
            redirect(base_url().'index.php/login','refresh');
        }
        $this->load->model('facturas_model');
        $this->load->model('reportes_model');
    }
    public function estadoCuenta()
    {       
        $f1 = '2015-06-01';
        $f2 = date('d-m-Y');
        $data = $this->reportes_model->cuentaXcliente($this->session->userdata('IdCL'),$f1,$f2,1);

        $this->load->view('header/header');
        $this->load->view('pages/menu');
        $this->load->view('pages/EstadoCuenta',$data);
        $this->load->view('footer/footer');
        $this->load->view('jsview/js_facturas');
    }
    public function FindClient($cond){
         $this->cliente_model($cond);
    }
    public function Clientes(){
        $query = $this->cliente_model->LoadClients();// Cargar Clientes

        $this->load->view('header/header');
        $this->load->view('pages/menu');
        $this->load->view('pages/Clientes',$query);
        $this->load->view('footer/footer');
        $this->load->view('jsview/js_clientes');
    }
    public  function BajaClientes(){
        $query = $this->cliente_model->LoadClientsBaja();

        $this->load->view('header/header');
        $this->load->view('pages/menu');
        $this->load->view('pages/BajaClientes',$query);
        $this->load->view('footer/footer');
        $this->load->view('jsview/js_clientes');
    }
    public  function  PuntosClientes(){
        $query = $this->cliente_model->LoadClientsPuntos();// Cargar puntos clientes
        
        $this->load->view('header/header');
        $this->load->view('pages/menu');
        $this->load->view('pages/PuntosClientes',$query);
        $this->load->view('footer/footer');
        $this->load->view('jsview/js_clientes');
    }
    public function buscarEstadoCuenta()
    {
        $fecha1 = $_GET['fecha1'];
        $fecha2 = $_GET['fecha2'];
        $fecha1 = ($fecha1=="") ? '2014-01-01' : date('Y-d-m',strtotime($fecha1));
        $fecha2 = ($fecha2=="") ? date('Y-d-m') : date('Y-d-m',strtotime($fecha2));
        $codigo = $this->session->userdata('IdCL');
        
        $this->reportes_model->cuentaXcliente($codigo,$fecha1,$fecha2);
    }
    public function generarUsuarios()
    {
        $this->cliente_model->generarUsuarios($this->input->post('codigo'),$this->input->post('nombre'),$this->input->post('vendedor'));
    }
    public function traerUsuario($codigo)
    {
        $this->cliente_model->traerUsuario($codigo);
    }
    public function darBajaCliente()
    {
        $this->cliente_model->darBajaCliente($this->input->post('codigo'));
    }
    public function ListarClientes()
    {
        $this->cliente_model->ListarClientes();
    }
    public function ajaxFacturasXcliente($IdCL)
    {
        $this->cliente_model->ajaxFacturasXcliente($IdCL);
    }
}
?>