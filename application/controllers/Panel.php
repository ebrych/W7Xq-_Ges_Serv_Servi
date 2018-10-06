<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Panel extends CI_Controller {

	public function Permisos()
	{
		$this->load->model('DataModel');
		$id = $this->input->post('id');
        $token =$this->input->post('token');
        $cargo=$this->DataModel->obtenerCargo($id,$token);
        $data['datos']=$this->DataModel->obtenerPermisos($cargo);
		$this->load->view('index',$data);
	}


}