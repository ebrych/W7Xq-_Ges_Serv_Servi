<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Asistencia extends CI_Controller{

    public $controlador='10';

    public function listaAsistencias(){
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
                $date=$this->input->post('date');
                $data['datos']= $this->DataModel->listarAsistenciadelDia($date);
            }else{
                $data['datos']= null;
            }
        }
        $this->load->view('index',$data);
    }


}