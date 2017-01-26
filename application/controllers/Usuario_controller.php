<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario_controller extends CI_Controller
{

    // AGREGAR USUARIO
    public function addUser()
    {
        $user = $this->input->post('user');
        $clave = $this->input->post('clave');
        $rol = $this->input->post('rol');
        $vendedor = $this->input->post('vendedor');
        $cliente = $this->input->post('cliente');
        $nomCliente = $this->input->post('nomCliente');
        $fecha = date('Y-m-d H:i:s');
        

        if ($rol == 'SuperAdministrador' || $rol == 'Administrador' || $rol == 'SAC' || $rol == 'Cartera') {
            $this->usuario_model->addUser($user, $clave, $rol, $fecha);
        }
        if ($rol == 'Vendedor') {
            $this->usuario_model->AddVdor($user, $clave, $rol, $fecha, $vendedor);
        }
        if ($rol == 'Cliente') {
            $this->usuario_model->AddCl($user, $clave, $rol, $fecha, $vendedor,$cliente,$nomCliente);
        }else if($rol==""){
           echo 0;
        }
    }
    

    public function ActUser($IdUser, $Estado)
    {/*CAMBIAR ESTADO DE USUARIO*/
        $this->usuario_model->ActUser($IdUser, $Estado);
    }

    public function LoadClient()
    {//Cargar los clientes
        $this->usuario_model->LoadClient();
    }

    public function LoadVendedor()
    {//cargar los vendedores
        $this->usuario_model->LoadVendedores();
    }
}