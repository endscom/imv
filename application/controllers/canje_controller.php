<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Canje_controller extends CI_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->library('session');
        if($this->session->userdata('logged')==0){ //No aceptar a usuarios sin loguearse
            redirect(base_url().'index.php/login','refresh');
        }
        $this->load->model('canje_model');
    }
    public function index()
    {
        $data = $this->cliente_model->ListarClientes();
        $data['premios'] = $this->catalogo_model->traerCatalogoImgActual();
        $data['Lista']   = $this->canje_model->getAllFRP();
    	$this->load->view('header/header');
        $this->load->view('pages/menu');
        $this->load->view('pages/CanjeFRP',$data);
        $this->load->view('footer/footer');
        $this->load->view('jsview/js_canje');
    }
    public function getAplicadoP($idCliente)
    {
        $this->canje_model->getAplicadoP($idCliente);
    }
    public function getBCMora($idCliente)
    {
        $this->canje_model->getBCMora($idCliente);
    }
    public function getFacturaFRP($idCliente)
    {
        $this->canje_model->getFacturaFRP($idCliente);
    }
    public function BuscaFRP($FRP){
        echo $this->canje_model->BuscaFRP($FRP);
    }
    public function SaverFRP(){
        echo $this->canje_model->save(
            $this->input->post('top'),
            $this->input->post('art'),
            $this->input->post('fac'),
            $this->input->post('log'));
    }
    public function getPuntosArticulosCatalogo(){
        $data['PtsItem'] = $this->canje_model->getPtsItem($this->input->post('codigo'));
    }

    public function viewFrp(){
        $id =  $this->input->post('frp');
        $data['top'] = $this->canje_model->getFRP($id,'frp');
        $data['DFactura'] = $this->canje_model->getFRP($id,"view_frp_factura");
        $data['DArticulo'] = $this->canje_model->getFRP($id,"view_frp_articulo");
        echo json_encode($data);
    }
    public function inactivar(){
        echo $this->canje_model->inactivar($this->input->post('frp'));
    }
}
?>