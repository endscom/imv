<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Monitoreo_controller extends CI_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->library('session');
        if($this->session->userdata('logged')==0){ //No aceptar a usuarios sin loguearse
            redirect(base_url().'index.php/login','refresh');
        }
        $this->load->model('monitoreo_model');
    }
    public function index()
    {
    	$this->load->view('header/header');
        $this->load->view('pages/menu');
        $this->load->view('pages/monitoreo/monitoreo');
        $this->load->view('footer/footer');
        $this->load->view('jsview/js_monitoreo');
    }
}
?>