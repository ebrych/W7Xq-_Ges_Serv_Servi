<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sesiones extends CI_Controller {

	public function login()
	{
		$this->load->model('DataModel');
		$user = $this->input->post('user');
		$pass = $this->input->post('password');
		$data['datos']=$this->DataModel->sesionLocal($user,$pass);
		//$data['datos']=$this->DataModel->saludo();
		$this->load->view('index',$data);
	}

	public function logout(){
		$this->load->model('DataModel');
		$id = $this->input->post('id');
		$token =$this->input->post('token');
		$cargo=$this->DataModel->obtenerCargo($id,$token);
		if($cargo==null){
            $data['datos']= null;
        }else{
			$data['datos']= $this->DataModel->logout($id,$token);
		}
		$this->load->view('index',$data);
	}


}
