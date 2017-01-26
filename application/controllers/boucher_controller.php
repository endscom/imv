<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Boucher_controller extends CI_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->library('session');
        if($this->session->userdata('logged')==0){ //No aceptar a usuarios sin loguearse
            redirect(base_url().'index.php/login','refresh');
        }
        $this->load->model('canje_model');
    }
    public function index(){
        $this->load->view('header/header');
        $this->load->view('pages/menu');
        $this->load->view('pages/EliminarVineta');
        $this->load->view('footer/footer');
    }
}