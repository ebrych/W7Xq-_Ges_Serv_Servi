<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Locales extends CI_Controller {

	public function ListGroup()
	{
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
                $data['datos']= $this->DataModel->LocalGroupList();
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
            $data['datos']=$this->DataModel->LocalSelectList();
        }
		$this->load->view('index',$data);
    }
    
    public function insertLocal(){
        $this->load->model('DataModel');
        $id = $this->input->post('id');
        $token =$this->input->post('token');
        $controlador='2';

        $cargo=$this->DataModel->obtenerCargo($id,$token);
        if($cargo==null){
            $data['datos']= null; 
        }else{
            //permiso
            $permiso=$this->DataModel->veryfyPermission($cargo,$controlador);
            if($permiso != 0){
                $datos=array(
                    'nombres' => $this->input->post('nombre'),
                    'direccion' => $this->input->post('direccion'),
                    'telefono' => $this->input->post('telefono'),
                    'estado' => $this->input->post('estado')
                );
                $data['datos']=$this->DataModel->insertaLocal($datos);
            }else{
                $data['datos']= null; 
            }
            
        }
        $this->load->view('index',$data);
    }

    public function localById(){
        $this->load->model('DataModel');
        $id = $this->input->post('id');
        $token =$this->input->post('token');
        $idLocal = $this->input->post('localId');
        $cargo=$this->DataModel->obtenerCargo($id,$token);
        $controlador='2';

        if($cargo==null){
            $data['datos']= null; 
        }else{
            //permiso
            $permiso=$this->DataModel->veryfyPermission($cargo,$controlador);
            if($permiso != 0){
                $data['datos']=$this->DataModel->buscaLoca($idLocal);
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
        $controlador='2';

        $cargo=$this->DataModel->obtenerCargo($id,$token);
        if($cargo==null){
            $data['datos']= null;
        }else{
            //permiso
            $permiso=$this->DataModel->veryfyPermission($cargo,$controlador);
            if($permiso != 0){
                $idLocal=$this->input->post('idLocal');
                $datos=array(
                    'nombres' => $this->input->post('nombre'),
                    'direccion' => $this->input->post('direccion'),
                    'telefono' => $this->input->post('telefono'),
                    'estado' => $this->input->post('estado')
                );
                $data['datos']=$this->DataModel->actualizaLocal($idLocal,$datos);
            }else{
                $data['datos']= null;
            }
        }
        $this->load->view('index',$data);
    }


}