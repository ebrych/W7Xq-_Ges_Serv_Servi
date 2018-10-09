<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ReporteLocal extends CI_Controller{

public $controlador='12';

public function listLocales(){
    $this->load->model('DataModel');
    $id = $this->input->post('id');
    $token =$this->input->post('token');

    //cargo-sesion
    $cargo=$this->DataModel->obtenerCargo($id,$token);
    if($cargo==null){
        $data['datos']= null;
    }else{
        //permiso
        $permiso=$this->DataModel->veryfyPermission($cargo,$this->controlador);
        if($permiso != 0){
            $hoy=$this->input->post('date');
            $dataFecha=EXPLODE("-",$hoy);
            $data['datos']= $this->DataModel->listaLocalesReporte($dataFecha[1]);
        }else{
            $data['datos']= null;
        }
    }
    $this->load->view('index',$data);
}


}