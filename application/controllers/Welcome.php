<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
		$this->load->model('DataModel');
		$data['datos']=$this->DataModel->saludo();
		$this->load->view('index',$data);
	}

}
