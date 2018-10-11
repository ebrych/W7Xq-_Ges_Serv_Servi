<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Website extends CI_Controller{
     
     public $controlador='xx';
     
     public function getData(){
          $this->load->model('DataModel');
          $data['datos']= $this->DataModel->infoWeb();
          $this->load->view('index',$data);
     }
     public function getLocales(){
          $this->load->model('DataModel');
          $data['datos']= $this->DataModel->LocalSelectList();
          $this->load->view('index',$data);
     }
     public function getContacto(){
          $this->load->model('DataModel');
          $data['datos']= $this->DataModel->contactoWeb();
          $this->load->view('index',$data);
     }
     
     //upDates
     public function agregarInfoWeb(){
        $this->load->model('DataModel');
        $id = $this->input->post('id');
        $token =$this->input->post('token');
        //sesion
        $cargo=$this->DataModel->obtenerCargo($id,$token);
        if($cargo==null){
            $data['datos']= null; 
        }else{
            //permiso
            $permiso=$this->DataModel->veryfyPermission($cargo,$this->controlador);
            if($permiso != 0){
                $datos=array(
                    'titulo' => $this->input->post('titulo'),
                    'descripcion' => $this->input->post('descripcion'),
                    'orden ' =>  $this->input->post('orden')
                );
                $data['datos']=$this->DataModel->agregarInfoWeb($datos);
            }else{
                $data['datos']= null; 
            }  
        }
        $this->load->view('index',$data);
     }
     
     public function buscaInfoWeb($id){
     $this->load->model('DataModel');
        $id = $this->input->post('id');
        $token =$this->input->post('token');
        $cargo=$this->DataModel->obtenerCargo($id,$token);
        $idInfo = $this->input->post('infoWebId');
        //sesion
        if($cargo==null){
            $data['datos']= null; 
        }else{
            //permiso
            $permiso=$this->DataModel->veryfyPermission($cargo,$this->controlador);
            if($permiso != 0){
                $data['datos']=$this->DataModel->inforWebById($idInfo);
            }else{
                $data['datos']= null; 
            }  
        }
        $this->load->view('index',$data);
     }
     
     public function actualizaInfoWeb(){
        $this->load->model('DataModel');
        $id = $this->input->post('id');
        $token =$this->input->post('token');
        $controlador='2';
        $cargo=$this->DataModel->obtenerCargo($id,$token);
        if($cargo==null){
            $data['datos']= null;
        }else{
            //permiso
            $permiso=$this->DataModel->veryfyPermission($cargo,$this->controlador);
            if($permiso != 0){
                $info=$this->input->post('infoWebId');
                $datos=array(
                    'titulo' => $this->input->post('titulo'),
                    'descripcion' => $this->input->post('descripcion'),
                    'orden ' =>  $this->input->post('orden')
                );
                $data['datos']=$this->DataModel->updateInfoWeb($info,$datos);
            }else{
                $data['datos']= null;
            }
        }
        $this->load->view('index',$data);
     }
     
     public function eliminaIfoWeb(){
        $this->load->model('DataModel');
        $id = $this->input->post('id');
        $token =$this->input->post('token');
        //sesion
        $cargo=$this->DataModel->obtenerCargo($id,$token);
        if($cargo==null){
            $data['datos']= null; 
        }else{
            //permiso
            $permiso=$this->DataModel->veryfyPermission($cargo,$this->controlador);
            if($permiso != 0){
               $info=$this->input->post('infoWebId');
                $data['datos']=$this->DataModel->deleteInfoWeb($info);
            }else{
                $data['datos']= null; 
            }  
        }
        $this->load->view('index',$data);
     }
     
     public function actualizaContacto(){
        $this->load->model('DataModel');
        $id = $this->input->post('id');
        $token =$this->input->post('token');
        $controlador='2';
        $cargo=$this->DataModel->obtenerCargo($id,$token);
        if($cargo==null){
            $data['datos']= null;
        }else{
            //permiso
            $permiso=$this->DataModel->veryfyPermission($cargo,$this->controlador);
            if($permiso != 0){
                $id='1';
                $datos=array(
                    'numero' => $this->input->post('numero'),
                    'mail' => $this->input->post('mail'),
                    'facebook  ' =>  $this->input->post('facebook')
                );
                $data['datos']=$this->DataModel->updateContactoWeb($id,$datos);
            }else{
                $data['datos']= null;
            }
        }
        $this->load->view('index',$data);
     }
     
     
     
}
