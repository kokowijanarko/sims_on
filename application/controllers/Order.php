<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
		$this->load->model('cashier_model');
		$this->load->model('order_model');
		$this->load->library('authex');
		$login = $this->authex->logged_in();
		if(!$login){
			redirect(site_url(''));
		}
    }
	
	public function index()
	{
		 
			
			$data['list'] = $this->order_model->getOrder();
			// var_dump($data);die;
			$this->load->view('admin/order/list', $data);
			
		 	
	}
}
