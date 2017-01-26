<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Impresion_controller extends CI_Controller
{

    public function __construct(){
        parent::__construct();
        if($this->session->userdata('logged')==0){ //No aceptar a usuarios sin loguearse
            redirect(base_url().'index.php/login','refresh');
        }
    $this->load->model('canje_efectivo_model');
    }

    public function DetalleFRP() {
        $this->load->view('header/header');
        $this->load->view('pages/ImprimirDatos/FRP_Impresion');
        $this->load->view('footer/footer');
    }

    public function DetalleFRE($id) {
        $data['fre'] = $this->canje_efectivo_model->getFRE($id,'fre');
        $data['detalles'] = $this->canje_efectivo_model->getFRE($id,'view_fre_factura');
        $this->load->view('header/header');
        $this->load->view('pages/ImprimirDatos/FRE_Impresion',$data);
        $this->load->view('footer/footer');

    }
}