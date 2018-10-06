<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Trabajadores extends CI_Controller{

    public function listarTrabajadores(){
        $this->load->model('DataModel');
		$id = $this->input->post('id');
        $token =$this->input->post('token');
        $cargo=$this->DataModel->obtenerCargo($id,$token);
        if($cargo==null){
            $data['datos']= null;
        }else{
            $idLocal=$this->DataModel->obtenerLocal($id);
            $data['datos']=$this->DataModel->listarTrabajadores($idLocal);
        }
		$this->load->view('index',$data);
    }

}