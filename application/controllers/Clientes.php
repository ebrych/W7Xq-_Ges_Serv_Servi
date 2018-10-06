<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clientes extends CI_Controller {

    public function listGroup(){
        $this->load->model('DataModel');
		$id = $this->input->post('id');
        $token =$this->input->post('token');
        $controlador='6';

        //cargo-sesion
        $cargo=$this->DataModel->obtenerCargo($id,$token);
        if($cargo==null){
            $data['datos']= null;
        }else{
            //permiso
            $permiso=$this->DataModel->veryfyPermission($cargo,$controlador);
            if($permiso != 0){
                $data['datos']= $this->DataModel->listGroupCliente();
            }else{
                $data['datos']= null;
            }
        }
        $this->load->view('index',$data);
    }


    public function listSelect(){
        $this->load->model('DataModel');
		$id = $this->input->post('id');
        $token =$this->input->post('token');
        //cargo-sesion
        $cargo=$this->DataModel->obtenerCargo($id,$token);
        if($cargo==null){
            $data['datos']= null;
        }else{
            $data['datos']= $this->DataModel->listSelectCliente();
        }
        $this->load->view('index',$data);
    }

    public function insertClient(){
        $this->load->model('DataModel');
        $id = $this->input->post('id');
        $token =$this->input->post('token');
        $controlador='6';

        $cargo=$this->DataModel->obtenerCargo($id,$token);
        if($cargo==null){
            $data['datos']= null; 
        }else{
            //permiso
            $permiso=$this->DataModel->veryfyPermission($cargo,$controlador);
            if($permiso != 0){
                $datos=array(
                    'nombres' => $this->input->post('nombre'),
                    'email' => $this->input->post('email'),
                    'telefono' => $this->input->post('telefono'),
                );
                $data['datos']=$this->DataModel->insertaCliente($datos);
            }else{
                $data['datos']= null; 
            }
            
        }
        $this->load->view('index',$data);
    }

    public function clienteById(){
        $this->load->model('DataModel');
        $id = $this->input->post('id');
        $token =$this->input->post('token');
        $idCliente = $this->input->post('clienteId');
        $cargo=$this->DataModel->obtenerCargo($id,$token);
        $controlador='6';

        if($cargo==null){
            $data['datos']= null; 
        }else{
            //permiso
            $permiso=$this->DataModel->veryfyPermission($cargo,$controlador);
            if($permiso != 0){
                $data['datos']=$this->DataModel->buscaClienteById($idCliente);
            }else{
                $data['datos']= null; 
            }
        }
        $this->load->view('index',$data);
    }

    public function updateCliente(){
        $this->load->model('DataModel');
        $id = $this->input->post('id');
        $token =$this->input->post('token');
        $controlador='6';

        $cargo=$this->DataModel->obtenerCargo($id,$token);
        if($cargo==null){
            $data['datos']= null;
        }else{
            //permiso
            $permiso=$this->DataModel->veryfyPermission($cargo,$controlador);
            if($permiso != 0){
                $idLocal=$this->input->post('idCliente');
                $datos=array(
                    'nombres' => $this->input->post('nombre'),
                    'email' => $this->input->post('email'),
                    'telefono' => $this->input->post('telefono'),
                );
                $data['datos']=$this->DataModel->actualizaClienteById($idLocal,$datos);
            }else{
                $data['datos']= null;
            }
        }
        $this->load->view('index',$data);
    }


}