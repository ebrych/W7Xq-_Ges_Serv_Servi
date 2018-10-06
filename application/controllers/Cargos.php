<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cargos extends CI_Controller {


    public function ListGroup(){
        $this->load->model('DataModel');
		$id = $this->input->post('id');
        $token =$this->input->post('token');
        $controlador='4';
        //cargo-sesion
        $cargo=$this->DataModel->obtenerCargo($id,$token);
        if($cargo==null){
            $data['datos']= null;
        }else{
            //permiso
            $permiso=$this->DataModel->veryfyPermission($cargo,$controlador);
            if($permiso != 0){
                $data['datos']= $this->DataModel->cargosGroupList();
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
            $data['datos']=$this->DataModel->cargosSelectList();
        }
		$this->load->view('index',$data);
    }

    public function insertCargo(){
        $this->load->model('DataModel');
        $id = $this->input->post('id');
        $token =$this->input->post('token');
        $controlador='4';

        $cargo=$this->DataModel->obtenerCargo($id,$token);
        if($cargo==null){
            $data['datos']= null; 
        }else{
            //permiso
            $permiso=$this->DataModel->veryfyPermission($cargo,$controlador);
            if($permiso != 0){
                $datos=array(
                    'descripcion' => $this->input->post('descripcion'),
                    'estado' => $this->input->post('estado')
                );
                $data['datos']=$this->DataModel->insertacargo($datos);
            }else{
                $data['datos']= null;
            }
            
        }
        $this->load->view('index',$data);
    }

    public function cargoById(){
        $this->load->model('DataModel');
        $id = $this->input->post('id');
        $token =$this->input->post('token');
        $idCargo = $this->input->post('insumoId');
        $cargo=$this->DataModel->obtenerCargo($id,$token);
        $controlador='4';

        if($cargo==null){
            $data['datos']= null; 
        }else{
            //permiso
            $permiso=$this->DataModel->veryfyPermission($cargo,$controlador);
            if($permiso != 0){
                $data['datos']=$this->DataModel->buscacargo($idCargo);
            }else{
                $data['datos']= null;
            }
        }
        $this->load->view('index',$data);
    }

    public function updateCargo(){
        $this->load->model('DataModel');
        $id = $this->input->post('id');
        $token =$this->input->post('token');
        $controlador='4';

        $cargo=$this->DataModel->obtenerCargo($id,$token);
        if($cargo==null){
            $data['datos']= null;
        }else{
            //permiso
            $permiso=$this->DataModel->veryfyPermission($cargo,$controlador);
            if($permiso != 0){
                $idCargo=$this->input->post('idCargo');
                $datos=array(
                    'descripcion' => $this->input->post('descripcion'),
                    'estado' => $this->input->post('estado')
                );
                $data['datos']=$this->DataModel->actualizacargo($idCargo,$datos);
            }else{
                $data['datos']= null;
            }
        }
        $this->load->view('index',$data);
    }

}
    