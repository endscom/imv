<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('login_model');
        $this->load->library('session');
        $this->load->helper('cookie');
    }

    public function index(){
        $this->load->view('header/header_login');
        $this->load->view('login/login');
        $this->load->view('footer/footer_login');
    }

    public function Salir(){
        $this->session->sess_destroy();
        $sessiondata = array('logged' => 0);
        $this->session->unset_userdata($sessiondata);
        $this->index();
    }

    public function Acreditar(){
        $this->form_validation->set_rules('txtUsuario', 'nombre', 'required');
        $this->form_validation->set_rules('txtpassword', 'pass', 'required');

        if ($this->form_validation->run()== FALSE){
            redirect('?error=1');
        } else {
            $name = $this->input->get_post('txtUsuario');
            $pass = $this->input->get_post('txtpassword');
            $data['user'] = $this->login_model->login($name, $pass);
            
            if ($data['user'] == 0){
                redirect('?error=2');
            } else {
                $sessiondata = array(
                    'id' => $data['user'][0]['UsuarioID'],
                    'UserN' => $data['user'][0]['Nombre'],
                    'RolUser'=>$data['user'][0]['rol'],
                    'Zona'=>$data['user'][0]['vendedor'],
                    'logged' => 1
                );
                $this->session->set_userdata($sessiondata);

                if($this->session->userdata){
                    redirect('Main');
                }


            }
        }
    }
    public function cambiarPass()
    {
       $query = $this->login_model->cambiarPass($this->input->get_post('pass'),$this->session->userdata('id'));
       if ($query==1) {
           $this->Salir();
       }redirect('Main');
    }

}