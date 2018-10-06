<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permisos extends CI_Controller{

    public function List(){
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
                $data['datos']= $this->DataModel->listarPermisos();
            }else{
                $data['datos']= null;
            }
        }
        $this->load->view('index',$data);
    }

    public function listaPermisosByCargo(){
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
                $idCargo =$this->input->post('idCargo');
                $data['datos']= $this->DataModel->listaPermisosById($idCargo);
            }else{
                $data['datos']= null;
            }
        }
        $this->load->view('index',$data);
    }

    public function agregaPermiso(){
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
                $crgo=$this->input->post('cargo');
                $prms=$this->input->post('permiso');
                $existe=$this->DataModel->buscaPermiso($crgo,$prms);
                if($existe==FALSE){
                    $data=array(
                        'idCargo' => $crgo,
                        'idPermiso' => $prms
                    );
                    $data['datos']= $this->DataModel->insertaPermiso($data);
                }else{
                    $data['datos']= null;
                }
                

            }else{
                $data['datos']= null;
            }
        }
        $this->load->view('index',$data);
    }

    public function eliminaPermiso(){
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
                $crgo=$this->input->post('cargo');
                $prms=$this->input->post('permiso');
                $data['datos']= $this->DataModel->eliminaPermiso($crgo,$prms);
            }else{
                $data['datos']= null;
            }
        }
        $this->load->view('index',$data);
    }


}