<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Personal extends CI_Controller{

    public $controlador='1';

    public function listPersonal(){
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
                $data['datos']= $this->DataModel->listaPersonal();
            }else{
                $data['datos']= null;
            }
        }
        $this->load->view('index',$data);
    }

    public function agregarUsuario(){
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
                $nmbrs=$this->input->post('nombre');
                $crg=$this->input->post('cargo');
                $lcl=$this->input->post('local');
                $ml=$this->input->post('email');
                $tfn=$this->input->post('telefono');
                $est=$this->input->post('estado');
                $fech=date("Y-m-d");

                $existe=$this->DataModel->buscaUsuario($ml);
                if($existe==0){
                    $data=array(
                        'nombres' => $nmbrs,
                        'idCargo' => $crg,
                        'idLocal' => $lcl,
                        'email' => $ml,
                        'telefono' => $tfn,
                        'pws' => $this->DataModel->generatePass(4),
                        'fechaRegistro' => $fech,
                        'estado'=>$est
                    );
                    $data['datos']= $this->DataModel->agregarUsuario($data);
                }else{
                    $data['datos']= null;
                }
                
            }else{
                $data['datos']= null;
            }
        }
        $this->load->view('index',$data);
    }

    public function buscaPersonalById(){
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
                $idUsr =$this->input->post('idUsuario');
                $data['datos']= $this->DataModel->listaUsuarioById($idUsr);
            }else{
                $data['datos']= null;
            }
        }
        $this->load->view('index',$data);
    }

    public function updatePersonal(){
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
                $idUsr =$this->input->post('idUsuario');
                $datos=array(
                    'nombres' => $this->input->post('nombres'),
                    'idCargo' => $this->input->post('cargo'),
                    'idLocal' => $this->input->post('local'),
                    'email' => $this->input->post('email'),
                    'telefono' => $this->input->post('telefono'),
                    'estado' =>  $this->input->post('estado')
                );
                $data['datos']= $this->DataModel->actualizaUsuario($idUsr,$datos);
            }else{
                $data['datos']= null;
            }
        }
        $this->load->view('index',$data);
    }

    public function ObtenerQr(){
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
                $idUsr =$this->input->post('idUsuario');
                $codeQr=$this->encrypt->encode("qrt-"+$idUsr);
                $data=array(
                    'code' => $codeQr
                );
                $data['datos']= $data;
            }else{
                $data['datos']= null;
            }
        }
        $this->load->view('index',$data);
    }

    


}