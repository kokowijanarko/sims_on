<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
		$this->load->model('dasboard_model');
		$this->load->library('authex');
		$this->load->library('kmeans');
		$login = $this->authex->logged_in();
		if(!$login){
			redirect(site_url(''));
		}
    }
	public function index()
	{
		$this->load->view('dashboard');
	}
	
	public function get_top5(){
		$data = $this->dasboard_model->getTop5();		
		echo json_encode($data);
		exit;
		
	}
	
	public function iseng(){
		$data = $this->dasboard_model->getSellingStatistic();		
		$kmeans = $this->kmeans->hitung($data);
	}
	
	
	
}
