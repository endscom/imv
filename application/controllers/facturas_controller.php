<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Facturas_controller extends CI_Controller
{
 public function __construct(){
        parent::__construct();
        $this->load->library('session');

        if($this->session->userdata('logged')==0){ //No aceptar a usuarios sin loguearse
            redirect(base_url().'index.php/login','refresh');
        }
        $this->load->model('facturas_model');
    }

    public function index()
    {
        
    	$data = $this->facturas_model->traerFacturas();
        $this->load->view('header/header');
        $this->load->view('pages/menu');
        $this->load->view('pages/facturas',$data);
        $this->load->view('footer/footer');
        $this->load->view('jsview/js_facturas');
    }
    public function detallefacturas($factura)
    {
    	$this->facturas_model->detallefacturas($factura);
    }
}
?>