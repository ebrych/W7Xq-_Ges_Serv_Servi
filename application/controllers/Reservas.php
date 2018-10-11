<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reservas extends CI_Controller{

    public $controlador='8';

    public function listarReservas(){
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
                $data['datos']= $this->DataModel->listarReservas();
            }else{
                $data['datos']= null;
            }
        }
        $this->load->view('index',$data);
    }

    public function confirmReserva(){
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
                //confirma
                $idReserva=$this->input->post('reserva');
		        $data['datos']= $this->DataModel->aceptaReserva($idReserva);
            }else{
                $data['datos']= null;
            }
        }
        $this->load->view('index',$data);
    }

    public function cancelaReserva(){
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
                //cancela
                $idReserva=$this->input->post('reserva');
                $data=array(
                    'estado' => 0
                );
                return $this->DataModel->updateReserva($idReserva,$data);
            }else{
                $data['datos']= null;
            }
        }
        $this->load->view('index',$data);
    }
    

    

}
