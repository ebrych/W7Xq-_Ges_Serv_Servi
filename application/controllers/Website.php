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
          
     }
}
