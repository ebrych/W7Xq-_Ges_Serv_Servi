<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tareas extends CI_Controller {

    public $controlador='7';

    public function listarTareas(){
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
                $date=$this->input->post('date');
                $data['datos']= $this->DataModel->listarTareas($date);
            }else{
                $data['datos']= null;
            }
        }
        $this->load->view('index',$data);
    }

    public function insertaTarea(){
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
                    'idLocal' => $this->DataModel->obtenerLocal($id),
                    'idCliente' => $this->input->post('cliente'),
                    'fecha' => $this->input->post('fecha'),
                    'estado' => $this->input->post('estado')
                );
                $data['datos']=$this->DataModel->insertaTarea($datos);
            }else{
                $data['datos']= null; 
            }
            
        }
        $this->load->view('index',$data);
    }

    public function buscaTareaById(){
        $this->load->model('DataModel');
        $id = $this->input->post('id');
        $token =$this->input->post('token');
        $idTarea = $this->input->post('tareaId');
        $cargo=$this->DataModel->obtenerCargo($id,$token);
        //sesion
        if($cargo==null){
            $data['datos']= null; 
        }else{
            //permiso
            $permiso=$this->DataModel->veryfyPermission($cargo,$this->controlador);
            if($permiso != 0){
                $data['datos']=$this->DataModel->buscaTareaById($idTarea);
            }else{
                $data['datos']= null; 
            }  
        }
        $this->load->view('index',$data);
    }

    public function insertaServicioToTarea(){
        $this->load->model('DataModel');
        $id = $this->input->post('id');
        $token =$this->input->post('token');
        $cargo=$this->DataModel->obtenerCargo($id,$token);
        //sesion
        if($cargo==null){
            $data['datos']= null; 
        }else{
            //permiso
            $permiso=$this->DataModel->veryfyPermission($cargo,$this->controlador);
            if($permiso != 0){
                //estado tarea
                $tarea=$this->input->post('tarea');
                $estado=$this->DataModel->buscaestadoTarea($tarea);
                if($estado != 1){
                    $data['datos']= null;
                }else{
                    $servicio=$this->input->post('servicio');
                    $datos=array(
                        'idTarea'=>$tarea,
                        'idServicio'=>$servicio,
                        'valor' =>$this->DataModel->obtenerValorServicio($servicio)
                    );
                    $data['datos']=$this->DataModel->insertaServiciosTarea($datos);
                }
            }else{
                $data['datos']= null; 
            }  
        }
        $this->load->view('index',$data);
    }

    public function listarServicioByTarea(){
        $this->load->model('DataModel');
        $id = $this->input->post('id');
        $token =$this->input->post('token');
        $idTarea = $this->input->post('tareaId');
        $cargo=$this->DataModel->obtenerCargo($id,$token);
        //sesion
        if($cargo==null){
            $data['datos']= null; 
        }else{
            //permiso
            $permiso=$this->DataModel->veryfyPermission($cargo,$this->controlador);
            if($permiso != 0){
                $data['datos']=$this->DataModel->buscaServiciosTareaById($idTarea);
            }else{
                $data['datos']= null; 
            }  
        }
        $this->load->view('index',$data);
    }

    public function eliminaServicioTarea(){
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
                $idTarea=$this->input->post('tarea');
                $idServicio=$this->input->post('servicio');
                $data['datos']=$this->DataModel->eliminaServicioTarea($idTarea,$idServicio);
            }else{
                $data['datos']= null; 
            }
            
        }
        $this->load->view('index',$data);
    }

    public function resumenTotal(){
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
                $idTarea=$this->input->post('tarea');
                $data['datos']=$this->DataModel->resumenTotalTarea($idTarea);
            }else{
                $data['datos']= null; 
            }
            
        }
        $this->load->view('index',$data);
    }

    public function montoTotal(){
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
                $idTarea=$this->input->post('tarea');
                $data['datos']=$this->DataModel->montoTotalTarea($idTarea);
            }else{
                $data['datos']= null; 
            }
            
        }
        $this->load->view('index',$data);
    }

    public function finalizaTarea(){
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
                $idTarea=$this->input->post('tarea');
                $estado=$this->DataModel->buscaestadoTarea($idTarea);
                if($estado != 1){
                    $data['datos']= null;
                }else{
                    $datos=array(
                        'estado' => 2
                    );
                    $data['datos']=$this->DataModel->updateTarea($idTarea,$datos);
                }
            }else{
                $data['datos']= null; 
            } 
        }
        $this->load->view('index',$data);
    }

    public function cancelaTarea(){
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
                $idTarea=$this->input->post('tarea');
                $estado=$this->DataModel->buscaestadoTarea($idTarea);
                if($estado != 1){
                    $data['datos']= null;
                }else{
                    $datos=array(
                        'estado' => 0
                    );
                    $data['datos']=$this->DataModel->updateTarea($idTarea,$datos);
                }
            }else{
                $data['datos']= null; 
            } 
        }
        $this->load->view('index',$data);
    }

    public function agregaTrabajadorToTarea(){
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
                $idTarea=$this->input->post('tarea');
                $estado=$this->DataModel->buscaestadoTarea($idTarea);
                if($estado != 1){
                    $data['datos']= null;
                }else{
                    $datos=array(
                        'idTarea' => $idTarea,
                        'idUsuario' => $this->input->post('trabajador')
                    );
                    $data['datos']=$this->DataModel->agregaTrabajadorToTarea($datos);
                }
            }else{
                $data['datos']= null; 
            } 
        }
        $this->load->view('index',$data);
    }

    public function listarTrabajadoresByTarea(){
        $this->load->model('DataModel');
        $id = $this->input->post('id');
        $token =$this->input->post('token');
        $idTarea = $this->input->post('tareaId');
        $cargo=$this->DataModel->obtenerCargo($id,$token);
        //sesion
        if($cargo==null){
            $data['datos']= null; 
        }else{
            //permiso
            $permiso=$this->DataModel->veryfyPermission($cargo,$this->controlador);
            if($permiso != 0){
                $data['datos']=$this->DataModel->listarTrabajadoresDeTarea($idTarea);
            }else{
                $data['datos']= null; 
            }  
        }
        $this->load->view('index',$data);
    }

    public function eliminaTrabajadorByTarea(){
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
                $idTarea=$this->input->post('tarea');
                $trabajador=$this->input->post('trabajador');
                $data['datos']=$this->DataModel->eliminaTrabajadorDeTarea($idTarea,$trabajador);
            }else{
                $data['datos']= null; 
            }
            
        }
        $this->load->view('index',$data);
    }

    public function obtenDatosFacturacion(){
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
                $idTarea=$this->input->post('tarea');
                $estado=$this->DataModel->buscaestadoTarea($idTarea);
                if($estado==2){
                    $data['datos']=$this->DataModel->buscarDatosBoleta($idTarea);
                }else if($estado==0){
                    $respuesta=array(
                        'datos' => '0'
                    );
                    $data['datos']=$respuesta;
                }
            }else{
                $data['datos']= null; 
            }
            
        }
        $this->load->view('index',$data);
    }

    public function insertaBoleta(){
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
                $idTarea=$this->input->post('tarea');
                $existe=$this->DataModel->buscaBoleta($idTarea);
                if($existe == 0){
                    $datos=array(
                        'serie'=>$this->input->post('serie'),
                        'numero'=>$this->input->post('numero'),
                        'idTarea'=>$idTarea
                    );
                    $data['datos']=$this->DataModel->insertaBoleta($datos);
                }else{
                    $data['datos']= FALSE; 
                }
            }else{
                $data['datos']= null; 
            } 
        }
        $this->load->view('index',$data);
    }



}