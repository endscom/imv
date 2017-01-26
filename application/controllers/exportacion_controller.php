<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Exportacion_controller extends CI_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->library('MPDF/mpdf');
        $this->load->model('canje_model');
        $this->load->model('reportes_model');        
    }

    public function ExpoClients(){
        $query = $this->cliente_model->LoadClients();// Cargar Clientes
        $this->load->view('Exportar/Excel_Cliente',$query);
    }

    public function ExpoPdf(){
        $query = $this->cliente_model->LoadClients();// Cargar Clientes
        $PdfCliente = new mPDF('utf-8','A4');
        $PdfCliente -> writeHTML($this->load->view('Exportar/Pdf_Cliente',$query,true));
        $PdfCliente->Output();
    }

    public function ExpPDF_PuntosClientes()
    {
        $query = $this->cliente_model->LoadClientsPuntos();// Cargar puntos clientes
        $PdfCliente = new mPDF('utf-8','A4');
        $PdfCliente -> writeHTML($this->load->view('Exportar/pdf_PuntosClientes',$query,true));
        $PdfCliente->Output();
    }

    public function ExpEXCEL_PuntosClientes()
    {
        $query = $this->cliente_model->LoadClientsPuntos();// Cargar puntos clientes
        $this->load->view('Exportar/Excel_PuntosClientes',$query);
    }
    public function ExpoFrp($id){
        $data['top'] = $this->canje_model->getFRP($id,'frp');
        $data['DFactura'] = $this->canje_model->getFRP($id,"view_frp_factura");
        $data['DArticulo'] = $this->canje_model->getFRP($id,"view_frp_articulo");
        $this->load->view('Exportar/Pdf_FRP',$data);
    }
    public function pdfCTAxCLIENTE($codigo,$fecha1,$fecha2)
    {   
        $this->load->model('reportes_model');
        $fecha1 = ($fecha1==null) ? $fecha1 : '2014-01-01';
        $fecha2 = ($fecha1==null) ? $fecha2 : date('Y-d-m');
        $query = array();
        $query['data'] = $this->reportes_model->datosCliente($codigo,1);
        $query['data2'] = $this->reportes_model->cuentaXcliente($codigo,$fecha1,$fecha2,1);
        
        $PdfCliente = new mPDF('utf-8','A4');
        $PdfCliente -> writeHTML($this->load->view('Exportar/PDF_cuentaXcliente',$query,true));
        $PdfCliente->Output();
    }
    public function excelCTAxCLIENTE()
    {
        $this->load->model('reportes_model');
        $codigo = explode(" | ", $_POST['CXCcodigo']);
        $fecha1 = ($_POST['CXCf1']=="") ? '2014-01-01' : $_POST['CXCf1'];
        $fecha2 = ($_POST['CXCf2']=="") ? date('Y-d-m') : $_POST['CXCf2'];

        $query = array();
        $query['data'] = $this->reportes_model->datosCliente($codigo[0],1);
        $query['data2'] = $this->reportes_model->cuentaXcliente($codigo[0],$fecha1,$fecha2,1);
        
        $this->load->view('Exportar/Excel_cuentaXcliente',$query);
    }
    public function ExpPDFEstadoCuenta()
    {
        $fecha1 = ($_POST['fecha1']=="") ? '01-01-2014' : $_POST['fecha1'];
        $fecha2 = ($_POST['fecha2']=="") ? date('d-m-Y') : $_POST['fecha2'];
        
        $codigo = $this->session->userdata('IdCL');
        $query['query1'] = $this->reportes_model->cuentaXcliente($codigo,$fecha1,$fecha2,1);
        $query['query2'] = $this->reportes_model->datosCliente($codigo);

        $PdfCliente = new mPDF('utf-8','A4');
        $PdfCliente -> writeHTML($this->load->view('Exportar/PDF_cuentaXcliente',$query,true));
        $PdfCliente->Output();
    }
}   