<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
		$this->load->model('cashier_model');
		$this->load->model('report_model');
		$this->load->model('user_model');
		$this->load->model('dasboard_model');
		$this->load->library('authex');
		$this->load->library('kmeans'); //library kmeans
		$login = $this->authex->logged_in();
		if(!$login){
			redirect(site_url(''));
		}
    }
	
	
	public function get_type_by_cat(){
		//var_dump($_POST);die;
		$type = $this->cashier_model->getTypeByCat($_POST['category_id']);
		
		$result = json_encode($type);
		echo $result;
		exit;
		
	}
	
	
	public function daily_list(){
		 
			$filter = array(
				'date'=> '',
				'date_end'=> '',
				'user'=>'all'
			);
			if(!empty($_POST)){
				if($_POST['date'] == '1970-01-01' || $_POST['date'] == ''){
					$date = 'all';
				}else{
					$date = date('Y-m-d', strtotime($_POST['date']));
				}
				if($_POST['date_end'] == '1970-01-01' || $_POST['date_end'] == ''){
					$date_end = 'all';
				}else{
					$date_end = date('Y-m-d', strtotime($_POST['date_end']));
				}
				
				$filter = array(
					'date'=> $date,
					'date_end'=> $date_end,
					'user'=>$_POST['user']
				);
				
				$data['post'] = $_POST;
			}else{
				$data['post'] = $filter;
			}
			
			$prod = $this->dasboard_model->getSellingStatistic($filter);
			// var_dump($this->db->last_query());
			$data_kmeans = $this->kmeans->hitung($prod); // pemanggilan kmeans yg library $prod = produk, data dlm kmeans
			$txt = '';
			if($data_kmeans['msg'] !== ''){
				$txt = $data_kmeans['msg'];
			}else{
				$kmeans = $data_kmeans['data'];
				$cluster = array();
			
				foreach($kmeans as $idx=>$value){
					$id_clust = '';
					foreach($value as $key=>$val){
						$cluster[$idx][] = $key;
						$id_clust .= $key .', ';
					}
					$id_clust = rtrim($id_clust, ', ');
					$id[$idx] = $id_clust;
				}
				
				foreach($id as $idx=>$val){
					$product_det[$idx] = $this->dasboard_model->getProductDetail($val);	
				}
				
				foreach($product_det as $idx=>$value){
					$table_comp = '';
					$i = 1;		
					if($idx == 'rendah'){
						$txt .= "<tr><th>RENDAH</th>";
					}elseif($idx == 'sedang'){
						$txt .= "<tr><th>TINGGI</th>";
					}elseif($idx == 'tinggi'){
						$txt .= "<tr><th>SEDANG</th>";
					}			
					foreach($value as $key=>$val){
						$txt .= '<td>'. $val->product_name .'</td>';
						$i++;
					}
					$txt .= '</tr>';			
				}
			}
			$data['kmeans'] = $txt;
			// var_dump($_POST, $filter);die;
			$data['invoice'] = $this->report_model->getTransactionByDate($filter);
			// var_dump($this->db->last_query());
			$data['user'] = $this->report_model->getUser();
			// var_dump($data);die;			
			$this->load->view('admin/report/list', $data);
		 			
	}
	
	public function daily_list_print(){
		 
			$filter = array(
				'date'=> '',
				'date_end'=> '',
				'user'=>'all'
			);
			if(!empty($_POST)){
				if($_POST['date'] == '1970-01-01' || $_POST['date'] == ''){
					$date = 'all';
				}else{
					$date = date('Y-m-d', strtotime($_POST['date']));
				}
				if($_POST['date_end'] == '1970-01-01' || $_POST['date_end'] == ''){
					$date_end = 'all';
				}else{
					$date_end = date('Y-m-d', strtotime($_POST['date_end']));
				}
				
				$filter = array(
					'date'=> $date,
					'date_end'=> $date_end,
					'user'=>$_POST['user']
				);
				
				$data['post'] = $_POST;
			}else{
				$data['post'] = $filter;
			}
			
			$prod = $this->dasboard_model->getSellingStatistic($filter);
			$txt = '';
			$data['kmeans'] = $txt;
			// var_dump($_POST, $filter);die;
			$data['invoice'] = $this->report_model->getTransactionByDate($filter);
			// var_dump($this->db->last_query());
			$data['user'] = $this->report_model->getUser();
			// var_dump($data);die;			
			$this->load->view('admin/report/print', $data);
		 			
	}
	
	public function get_detail_invoice(){
		
		$result = $this->cashier_model->getDetailInvoiceByInvoiceCode($_POST['invo_number']);
		//var_dump($result);die;
		echo json_encode($result);
		exit;
	}
	
	public function kmeans_detail(){
		$date_start = '';		
		$date_end = '';		
		$user = '';		
		
		if($_GET['date_start'] !== '' || $_GET['date_start'] !== '1970-01-01'){
			$date_start = $_GET['date_start'];
		}
		
		if($_GET['date_end'] !== '' || $_GET['date_end'] !== '1970-01-01'){
			$date_end = $_GET['date_end'];
		}
		
		if($_GET['user'] !== ''){
			$user = $_GET['user'];
		}
		
		$filter = array(
			'date'=> $date_end,
			'date_end'=> $date_end,
			'user'=>$user
		);
		
		$data_prod = $this->dasboard_model->getSellingStatistic($filter);
		$prod = array();
		foreach($data_prod as $key=>$val){
			if($val->jumlah != 0){
				$prod[] = $val;
			}
		}
		// var_dump($this->db->last_query(), $prod);die;
		$data['statistic'] = $prod;
		$data_kmeans = $this->kmeans->hitung($prod);
		
		foreach($data_kmeans['data'] as $idx=>$val){
			foreach($val as $key=>$value){
				$product_detail = $this->dasboard_model->getProductDetail($key);
				$final_kmeans[$idx][$key] = $product_detail[0];
			}
		}
		
		$data['final_kmeans']=$final_kmeans;
		
		$txt = '';
		if($data_kmeans['msg'] !== ''){
			$txt = $data_kmeans['msg'];
		}else{
			$kmeans = $data_kmeans['data_detail'];
			foreach($kmeans['jarak'] as $idx=>$val){
				foreach($val as $key=>$value){
					$product = $this->dasboard_model->getProductDetail($key);
					// var_dump($product);die;
					$kmeans['jarak'][$idx][$key]['product_name'] = $product[0]->product_name;
					$kmeans['jarak'][$idx][$key]['jumlah'] = $product[0]->jumlah;
				}
				
			}
			$data['kmeans'] = $kmeans;
			
		}
		
		
		
		// var_dump($kmeans['jarak'], $kmeans['centroid']);die;
		$this->load->view('admin/report/kmeans_calculation', $data);
		
	}
}
