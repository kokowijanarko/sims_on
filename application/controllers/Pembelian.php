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
		if($this->session->userdata('level') == 1 || $this->session->userdata('level') == 2){
			if(isset($_GET['msg'])){
				$data['message'] = $this->getMessage($_GET['msg']);
			}
			$data['list'] = $this->pembelian_model->getPembelian();
			// var_dump($data);die;
			$this->load->view('admin/pembelian/list', $data);
		}else{
			redirect(site_url(''));
		}	
	}
	
	public function add(){
		if($this->session->userdata('level') == 1 || $this->session->userdata('level') == 2){
			
			$data['produk'] = $this->cashier_model->getInventory();
			$data['supplier'] = $this->pembelian_model->getSupplier();
			// var_dump($data);die;
			$this->load->view('admin/pembelian/add', $data);
		}else{
			redirect(site_url(''));
		}		
	}
	public function add_pembelian(){
		if($this->session->userdata('level') == 1 || $this->session->userdata('level') == 3){
			$post = $_POST;	
			var_dump($post);
			$param_order = array(
				'kode_invoice' => $post['no_nota'],
				'id_user'=> $this->session->userdata('id_user'),
				'id_cust' => $post['cust_id'],
				'tgl_trans' => date('Y-m-d', strtotime($post['tgl_order'])),
				'biaya_kirim' => $post['ongkir'],
				'diskon' => $post['discount'],					
				'ttl_byr' => $post['total'],				
			);
			//var_dump($param_order);die;
			$this->db->trans_start();
			$execute = $this->cashier_model->insertOrder($param_order);
			
			if($execute){
				$id_order = $this->db->insert_id();
				for($i=0; $i<count($post['data_order']['product_id']); $i++){
					$inv = $this->cashier_model->getInvDetailById($post['data_order']['product_id'][$i]);
					$new_stock = intval($inv->stok) - intval($post['data_order']['quantity'][$i]);
					$this->cashier_model->updateStock($new_stock, $post['data_order']['product_id'][$i]);
					$param_detail[] = array(
						'id_penj'=>$id_order,
						'id_prod'=>$post['data_order']['product_id'][$i],
						'jml_jual'=>$post['data_order']['quantity'][$i],
						'total'=>$post['data_order']['sub_total'][$i]
					);
					
				}
				$execute = $execute && $this->cashier_model->insertOrderDetail($param_detail);
			}			
			$this->db->trans_complete($execute);
			
			if($execute){
				echo json_encode($id_order);
				exit;
			}else{
				echo json_encode(FALSE);
				exit;
			}
		}else{
			redirect(site_url(''));
		}	
		
	}
	public function edit($id){
		if($this->session->userdata('level') == 1  || $this->session->userdata('level') == 2){
			$data['detail'] = $this->pembelian_model->getDetailPembelian($id);
			// var_dump($data);die;
			$this->load->view('admin/pembelian/edit', $data);

		}else{
			redirect(site_url(''));
		}	
		
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
		if($this->session->userdata('level') == 1  ){
			
			$result = $this->pembelian_model->deletePembelian($id);
			if($result == true){
				redirect(site_url('Pembelian/index?msg=Dm1'));
			}else{
				redirect(site_url('Pembelian/index?msg=Dm0'));			
			}

		}else{
			redirect(site_url(''));
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
