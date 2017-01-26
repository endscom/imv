<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Canje_efectivo_controller extends CI_Controller
{
	public function __construct(){
        parent::__construct();
        $this->load->library('session');
        if($this->session->userdata('logged')==0){ //No aceptar a usuarios sin loguearse
            redirect(base_url().'index.php/login','refresh');
        }
        $this->load->model('canje_efectivo_model');
    }
    public function index()
    {
    	$data = $this->cliente_model->ListarClientes();
    	$data['fre'] = $this->canje_efectivo_model->traerAllFRE();

    	$this->load->view('header/header');
        $this->load->view('pages/menu');
        $this->load->view('pages/CanjeEfec',$data);
        $this->load->view('footer/footer');
        $this->load->view('jsview/js_canje_efectivo');
    }
    public function getAplicadoP($idCliente)
    {
        $this->canje_efectivo_model->getAplicadoP($idCliente);
    }
    public function getFacturaFRE($idCliente)
    {
        $this->canje_efectivo_model->getFacturaFRE($idCliente);
    }
    public function BuscaFRE($FRE){
        echo $this->canje_efectivo_model->BuscaFRE($FRE);
    }
    public function SaverFRE(){
        echo $this->canje_efectivo_model->save(
            $this->input->post('frp'),
            $this->input->post('fac'),
            $this->input->post('log'));
    }
    public function viewFre(){
        $id =  $this->input->post('fre');
        $data['top'] = $this->canje_efectivo_model->getFRE($id,'fre');
        $data['DFactura'] = $this->canje_efectivo_model->getFRE($id,"view_fre_factura");
        echo json_encode($data);
    }
     public function inactivar(){
        echo $this->canje_efectivo_model->inactivar($this->input->post('fre'));
    }
}
?>