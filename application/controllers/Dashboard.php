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
		// var_dump($login, site_url());die;
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
		var_dump($kmeans);
	}
	
	
	///hanya digunakan sekali untuk migrasi data
	public function prod(){
		$data = $this->dasboard_model->getProduct();
		
		foreach($data as $idx=>$val){
			foreach($val as $key=>$value){
				$params[$idx][$key] = $value;
			}
		}
		// var_dump($params);
		// die;
		$this->db->trans_start();
		$input = $this->db->insert_batch('produk', $params);
		var_dump($input);
		$this->db->trans_complete($input);
		
	}
	
	public function dp(){
		$data = $this->dasboard_model->getPenjualanDetail();
		
		foreach($data as $idx=>$val){
			foreach($val as $key=>$value){
				$params_detpenj[$idx][$key] = $value;
			}			
			$id_penj[] = $val->id_penj		;	
		}
		
		$id_penj = array_unique($id_penj);
		
		$id = '';
		foreach($id_penj as $key=>$val){
			$id .= $val.', ';
		}
		$id = rtrim($id, ', ');
		// $id .= ')'; 
		
		// var_dump($id);die;
		
		$data_penj = $this->dasboard_model->getPenjualan($id);
		

		$asd = 11;
		foreach($data_penj as $idx=>$val){
			$params_penj[$idx]['kode_invoice'] = 'INV.'. $asd .'/'. date('d/M/Y', strtotime($val->tgl_trans));
			foreach($val as $key=>$value){
				$params_penj[$idx][$key] = $value;
			}
			$asd++;
		}
		//var_dump($params_penj, $params_detpenj);die;
		
		$this->db->trans_start();
		$input = $this->db->insert_batch('penjualan', $params_penj);
		if($input){
			$input = $input && $this->db->insert_batch('detail_penjualan', $params_detpenj);
		}
		var_dump($input);
		$this->db->trans_complete($input);
		
	}
	
	public function cust(){
		$data = $this->dasboard_model->getCust();
		
		foreach($data as $idx=>$val){
			foreach($val as $key=>$value){
				$params[$idx][$key] = $value;
			}
		}
		// var_dump($params);
		// die;
		
		$this->db->trans_start();
		$input = $this->db->insert_batch('customer', $params);
		var_dump($input);
		$this->db->trans_complete($input);
		
	}
	
	
	
}
