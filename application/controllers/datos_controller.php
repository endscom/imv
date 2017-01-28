<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Datos_controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if($this->session->userdata('logged')==0){ //No aceptar a usuarios sin loguearse
            redirect(base_url().'index.php/login','refresh');
        }
        $this->load->model('datos_model');
        $this->load->library('session');
        $this->load->helper('cookie');
        require_once(APPPATH.'libraries/Excel/reader.php');
    }
    public function index()
    {
        $data['datos'] = $this->datos_model->getDatos();

        $this->load->view('header/header');
        $this->load->view('pages/menu');
        $this->load->view('pages/datos/datos',$data);
        $this->load->view('footer/footer'); 
        $this->load->view('jsview/js_datos'); 
    }
    
    public function subir()
    {
      $data = new Spreadsheet_Excel_Reader();
      $data->setOutputEncoding('CP-1251');
      $data->read($_FILES["file"]['tmp_name']);
      error_reporting(E_ALL ^ E_NOTICE);
      $codigo = (@ereg_replace("[^0-9]", "", $data->sheets[0]['cells'][$i][1]));

      $this->datos_model->metaCuota('META',$this->input->post('fecha'));
      for ($i=0; $i <= count($data->sheets[0]['cells']); $i++) {
        
        if ($codigo<>""){
            $this->datos_model->subir($data->sheets[0]['cells'][$i][1],$data->sheets[0]['cells'][$i][2],$data->sheets[0]['cells'][$i][3],
                                      $data->sheets[0]['cells'][$i][4],$data->sheets[0]['cells'][$i][5],$data->sheets[0]['cells'][$i][6],
                                      $data->sheets[0]['cells'][$i][7],$data->sheets[0]['cells'][$i][8]);
            
        }
      }
      
      $this->datos_model->metaCuota('CUOTA',$this->input->post('fecha'));
      for ($i=0; $i <= count($data->sheets[1]['cells']); $i++) {
        $codigo = (@ereg_replace("[^0-9]", "", $data->sheets[1]['cells'][$i][1]));  
        if ($codigo<>""){
            $this->datos_model->subir2($data->sheets[1]['cells'][$i][1],$data->sheets[1]['cells'][$i][2],$data->sheets[1]['cells'][$i][3],
                                      $data->sheets[1]['cells'][$i][4],$data->sheets[1]['cells'][$i][5]);
        }
      }
      $this->vistaPrevia($this->input->post('fecha'));
    }
    public function vistaPrevia($fecha)
    {
      $data['cuotas'] = $this->datos_model->vistaPrevia($fecha,"cuotaxproducto","CUOTA");
      $data['metas'] = $this->datos_model->vistaPrevia($fecha,"metas","META");
      
      $this->load->view('header/header');
      $this->load->view('pages/menu');
      $this->load->view('pages/datos/vistaPrevia',$data);
      $this->load->view('footer/footer'); 
      $this->load->view('jsview/js_datos');
    }
    public function descartarDatos()
    {
      $this->datos_model->descartarDatos($_POST['cuota'],'cuotaxproducto');
      $this->datos_model->descartarDatos($_POST['meta'],'metas');
      $this->index();
    }
    public function viewDatos($id,$tipo)
    {
      $this->datos_model->viewDatos($id,$tipo);
    }
}
?>