<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Servicios extends CI_Controller {

    public $controlador='3';

    public function listarTipoPrecio(){
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
                $data['datos']= $this->DataModel->listaTipoPrecio();
            }else{
                $data['datos']= null;
            }
        }
        $this->load->view('index',$data);
    }

    public function ListGroup()
	{
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
                $data['datos']= $this->DataModel->listarServicios();
            }else{
                $data['datos']= null;
            }
        }
        $this->load->view('index',$data);
    }

    public function selectList(){
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
                $data['datos']= $this->DataModel->selectListServicio();
            }else{
                $data['datos']= null;
            }
        }
        $this->load->view('index',$data);
    }
    
    public function insertServicio(){
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
                $datos=array(
                    'descripcion' => $this->input->post('descripcion'),
                    'idCategoriaPrecio' => $this->input->post('categoria'),
                    'costo' => $this->input->post('costo'),
                    'estado' => $this->input->post('estado')
                );
                $data['datos']=$this->DataModel->insertaServicio($datos);
            }else{
                $data['datos']= null; 
            }
        }
        $this->load->view('index',$data);
    }

    public function buscaServiciosById(){
        $this->load->model('DataModel');
        $id = $this->input->post('id');
        $token =$this->input->post('token');
        $idServicio = $this->input->post('servicioId');
        $cargo=$this->DataModel->obtenerCargo($id,$token);
        //cargo-sesion
        if($cargo==null){
            $data['datos']= null; 
        }else{
            //permiso
            $permiso=$this->DataModel->veryfyPermission($cargo,$this->controlador);
            if($permiso != 0){
                $data['datos']=$this->DataModel->buscaServicioById($idServicio);
            }else{
                $data['datos']= null; 
            }
            
        }
        $this->load->view('index',$data);
    }

    public function updateServicio(){
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
                $idServicio=$this->input->post('idServicio');
                $datos=array(
                    'descripcion' => $this->input->post('descripcion'),
                    'idCategoriaPrecio' => $this->input->post('categoria'),
                    'costo' => $this->input->post('costo'),
                    'estado' => $this->input->post('estado')
                );
                $data['datos']=$this->DataModel->actualizaServicio($idServicio,$datos);
            }else{
                $data['datos']= null;
            }
        }
        $this->load->view('index',$data);
    }

    public function agregarInsumoToServicio(){
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
                $datos=array(
                    'idServicio' => $this->input->post('servicio'),
                    'idInsumo' => $this->input->post('insumo')
                );
                $data['datos']=$this->DataModel->agregarInsumoServicio($datos);
            }else{
                $data['datos']= null;
            }
        }
        $this->load->view('index',$data);
    }

    public function listarMisInsumos(){
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
                $idServicio=$this->input->post('servicio');
                $data['datos']=$this->DataModel->listarInsmoServicio($idServicio);
            }else{
                $data['datos']= null;
            }
        }
        $this->load->view('index',$data);
    }

    public function eliminaInsumo(){
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
                $idServicio=$this->input->post('servicio');
                $idInsumo=$this->input->post('insumo');
                $data['datos']=$this->DataModel->eliminaInsumoServicio($idServicio,$idInsumo);
            }else{
                $data['datos']= null;
            }
        }
        $this->load->view('index',$data);
    }




}