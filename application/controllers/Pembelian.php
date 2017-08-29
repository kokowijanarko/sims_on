<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembelian extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
		$this->load->model('pembelian_model');
		$this->load->model('cashier_model');
		$this->load->library('authex');
		
		$login = $this->authex->logged_in();
		if(!$login){
			redirect(site_url(''));
		}
		
    }
	
	public function index()
	{	
 
			if(isset($_GET['msg'])){
				$data['message'] = $this->getMessage($_GET['msg']);
			}
			$data['list'] = $this->pembelian_model->getPembelian();
			// var_dump($data);die;
			$this->load->view('admin/pembelian/list', $data);
		 	
	}
	
	public function add(){
 
			
			$data['produk'] = $this->cashier_model->getInventory();
			$data['supplier'] = $this->pembelian_model->getSupplier();
			// var_dump($data);die;
			$this->load->view('admin/pembelian/add', $data);
		 		
	}
	public function add_pembelian(){
		 
			$post = $_POST;	
			// var_dump($post);die;
			$param_order = array(
				'id_sup' => $post['sup_id'],
				'id_user'=> $this->session->userdata('id_user'),
				'tgl_beli' => date('Y-m-d', strtotime($post['tgl_order']))
			);
			//var_dump($param_order);die;
			$this->db->trans_start();
			$execute = $this->pembelian_model->insertPembelian($param_order);
			// var_dump($execute);die;
			if($execute){
				$id_order = $this->db->insert_id();
				for($i=0; $i<count($post['data_order']['product_id']); $i++){
					$inv = $this->cashier_model->getInvDetailById($post['data_order']['product_id'][$i]);
					$new_stock = intval($inv->stok) + intval($post['data_order']['quantity'][$i]);
					$this->cashier_model->updateStock($new_stock, $post['data_order']['product_id'][$i]);
					$param_detail[] = array(
						'id_beli'=>$id_order,
						'id_prod'=>$post['data_order']['product_id'][$i],
						'harga_beli'=>$post['data_order']['price'][$i],
						'harga_jual'=>$post['data_order']['price_sell'][$i],
						'jml_brg'=>$post['data_order']['quantity'][$i]
					);
					
				}
				$execute = $execute && $this->pembelian_model->insertDetailPembelian($param_detail);
				// var_dump($execute);die;
			}			
			$this->db->trans_complete($execute);
			
			if($execute){
				echo json_encode($id_order);
				exit;
			}else{
				echo json_encode(FALSE);
				exit;
			}
		 	
		
	}
	public function edit($id){
		 
			$data['detail'] = $this->pembelian_model->getDetailPembelian($id);
			// var_dump($data);die;
			$this->load->view('admin/pembelian/edit', $data);

		 	
		
	}
	
	public function doAdd(){
			// var_dump($_POST);die;
			if(!empty($_POST)){
				$this->db->trans_start();
				
				$result = $this->pembelian_model->insertPembelian($_POST);
				// var_dump($result);die;
				$this->db->trans_complete($result);
				
				if($result){
				redirect(base_url('index.php/pembelian/index?msg=Am1'));
				}else{
					redirect(base_url('index.php/pembelian/index?msg=Am0'));
				}
			}else{
				redirect(site_url('user/add'));
			}
		
	}
	
	public function doEdit(){
		
		$this->db->trans_start();
		
		$result = $this->pembelian_model->updatePembelian($_POST, $_POST['id_sup']);
		// var_dump($result);die;
		$this->db->trans_complete($result);
		if($result == true){
			redirect(base_url('index.php/pembelian/index?msg=Em1'));
		}else{
			redirect(base_url('index.php/pembelian/index?msg=Em0'));
		}

	
	}
	
	
	public function doDelete($id){
		 
			
			$result = $this->pembelian_model->deletePembelian($id);
			if($result == true){
				redirect(site_url('Pembelian/index?msg=Dm1'));
			}else{
				redirect(site_url('Pembelian/index?msg=Dm0'));			
			}

		 		
	}
	
	public function get_detail_pembelian($id){
		$data = $this->pembelian_model->getDetailPembelian($id);
		$data = json_encode($data);
		// var_dump();
		echo $data;
		exit;
	}
	
	private function getMessage($idx){
		if($idx == 'Em1'){
			return '
				<div class="alert alert-success alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-check"></i> Berhasil!</h4>
					Edit Data Pembelian Sukses.
				</div>
			';
		}elseif($idx == 'Em0'){
			return '
				<div class="alert alert-danger alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-check"></i> Gagal!</h4>
					Edit Data Pembelian Gagal.
				</div>
			';
		}elseif($idx == 'Am1'){
			return '
				<div class="alert alert-success alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-check"></i> Berhasil!</h4>
					Tambah Data Pembelian Sukses.
				</div>
			';
		}elseif($idx == 'Am0'){
			return '
				<div class="alert alert-danger alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-check"></i> Gagal!</h4>
					Tambah Data Pembelian Gagal.
				</div>
			';
		}elseif($idx == 'Dm1'){
			return '
				<div class="alert alert-success alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-check"></i> Berhasil!</h4>
					Hapus Data Pembelian Sukses.
				</div>
			';
		}elseif($idx == 'Dm0'){
			return '
				<div class="alert alert-danger alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-check"></i> Gagal!</h4>
					Hapus Data Pembelian Gagal.
				</div>
			';
		}
	}
}
