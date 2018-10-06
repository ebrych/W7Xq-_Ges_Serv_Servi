<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Insumos extends CI_Controller {
    
    public function ListGroup(){
        $this->load->model('DataModel');
		$id = $this->input->post('id');
        $token =$this->input->post('token');
        $controlador='2';
        //cargo-sesion
        $cargo=$this->DataModel->obtenerCargo($id,$token);
        if($cargo==null){
            $data['datos']= null;
        }else{
            //permiso
            $permiso=$this->DataModel->veryfyPermission($cargo,$controlador);
            if($permiso != 0){
                $data['datos']= $this->DataModel->insumoGroupList();
            }else{
                $data['datos']= null;
            }
        }
        $this->load->view('index',$data);
    }

    public function SelectList()
	{
		$this->load->model('DataModel');
		$id = $this->input->post('id');
        $token =$this->input->post('token');
        $cargo=$this->DataModel->obtenerCargo($id,$token);
        if($cargo==null){
            $data['datos']= null;
        }else{
            $data['datos']=$this->DataModel->insumoSelectList();
        }
		$this->load->view('index',$data);
    }

    public function insertInsumo(){
        $this->load->model('DataModel');
        $id = $this->input->post('id');
        $token =$this->input->post('token');
        $controlador='5';

        $cargo=$this->DataModel->obtenerCargo($id,$token);
        if($cargo==null){
            $data['datos']= null; 
        }else{
            //permiso
            $permiso=$this->DataModel->veryfyPermission($cargo,$controlador);
            if($permiso != 0){
                $datos=array(
                    'nombre' => $this->input->post('nombre'),
                    'descripcion' => $this->input->post('descripcion'),
                    'estado' => $this->input->post('estado')
                );
                $data['datos']=$this->DataModel->insertaInsumo($datos);
            }else{
                $data['datos']= null;
            }
            
        }
        $this->load->view('index',$data);
    }

    public function InsumoById(){
        $this->load->model('DataModel');
        $id = $this->input->post('id');
        $token =$this->input->post('token');
        $idInsumo = $this->input->post('insumoId');
        $cargo=$this->DataModel->obtenerCargo($id,$token);
        $controlador='5';

        if($cargo==null){
            $data['datos']= null; 
        }else{
            //permiso
            $permiso=$this->DataModel->veryfyPermission($cargo,$controlador);
            if($permiso != 0){
                $data['datos']=$this->DataModel->buscaInsumo($idInsumo);
            }else{
                $data['datos']= null;
            }
        }
        $this->load->view('index',$data);
    }

    public function updateLocal(){
        $this->load->model('DataModel');
        $id = $this->input->post('id');
        $token =$this->input->post('token');
        $controlador='5';

        $cargo=$this->DataModel->obtenerCargo($id,$token);
        if($cargo==null){
            $data['datos']= null;
        }else{
            //permiso
            $permiso=$this->DataModel->veryfyPermission($cargo,$controlador);
            if($permiso != 0){
                $idInsumo=$this->input->post('idInsumo');
                $datos=array(
                    'nombre' => $this->input->post('nombre'),
                    'descripcion' => $this->input->post('descripcion'),
                    'estado' => $this->input->post('estado')
                );
                $data['datos']=$this->DataModel->actualizaInsumo($idInsumo,$datos);
            }else{
                $data['datos']= null;
            }
        }
        $this->load->view('index',$data);
    }



}