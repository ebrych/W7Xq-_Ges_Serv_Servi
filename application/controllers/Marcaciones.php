<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Marcaciones extends CI_Controller{

    public $controlador='9';

    public function listPersonal(){
        $this->load->model('DataModel');
		$id = $this->input->post('id');
        $token =$this->input->post('token');
        $local =$this->DataModel->obtenerLocal($id);
        //cargo-sesion
        $cargo=$this->DataModel->obtenerCargo($id,$token);
        if($cargo==null){
            $data['datos']= null;
        }else{
            //permiso
            $permiso=$this->DataModel->veryfyPermission($cargo,$this->controlador);
            if($permiso != 0){
                $data['datos']= $this->DataModel->listaPersonalByLocal($local);
            }else{
                $data['datos']= null;
            }
        }
        $this->load->view('index',$data);
    }

    public function agregarMarcacion(){
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
               $idUser=$this->input->post('user');
               $hoy=date("Y-m-d");
               $busca=$this->DataModel->buscaAsistencia($idUser,$hoy);
                if($busca==0){
                        //agrega asistencia
                        $data=array(
                            'idUsuario'=> $idUser,
                            'fecha'=> $hoy,
                            'entrada'=>date("H:i:s")
                        );
                        $data['datos']= $this->DataModel->registrarAsistencia($data);
                }else{
                        //update asistencia
                        $data=array(
                            'salida' => date("H:i:s")
                        );
                        //$salida=date("H:i:s");
                        $data['datos']=$this->DataModel->actualizaAsistencia($idUser,$hoy,$data);
                }
            }else{
                $data['datos']= null;
            }
        }
        $this->load->view('index',$data);
    }



/*
 $date=$this->input->post('date');
                $encript=$this->input->post('user');
                $uncript=$this->encrypt->decode($encript);
                $user=EXPLODE("-",$uncript);
                $busca=$this->DataModel->buscaAsistencia($id,$user[1]);
                if($busca==0){
                    //agrega asistencia
                    $data=array(
                        'idUsuario'=> $id,
                        'fecha'=> date("Y-m-d"),
                        'entrada'=>date("H:i:s")
                    );
                    $this->DataModel->registrarAsistencia($data);
                }else{
                    //update asistencia
                    $data=array(
                        'salida'=>date("H:i:s")
                    );
                    $this->DataModel->actualizaAsistencia($id,date("Y-m-d"),$data);
*/


}