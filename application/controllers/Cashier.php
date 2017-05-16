<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cashier extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
		$this->load->model('cashier_model');
		$this->load->library('authex');
		$login = $this->authex->logged_in();
		if(!$login){
			redirect(site_url(''));
		}
    }
	
	public function index()
	{
		// var_dump($this->session->userdata('fullname'));die;
		if($this->session->userdata('level') == 1 || $this->session->userdata('level') == 3){
			if(isset($_GET['msg'])){
				$data['message'] = $this->getMessage($_GET['msg']);
			}
			$data['order_code'] = $this->orderCodeGenerator();
			$data['produk'] = $this->cashier_model->getInventory();
			$this->load->view('admin/cashier/add', $data);
		}else{
			redirect(site_url(''));
		}	
		
		
	}
	
	private function orderCodeGenerator(){
		$date = date('Y-m-d');
		$last_order_code = $this->cashier_model->getLastOrderCode($date);
		if(is_null($last_order_code)){
			$new_order_code = 'INV.1/'.date('d').'/'.date('M').'/'.date('Y');
		}else{
			$loc_explode = explode('/', $last_order_code);
			$loc_identifier = explode('.', $loc_explode[0]);
			$loc_prefix = $loc_identifier[0];
			$loc_index = $loc_identifier[1];
			$loc_date = $loc_explode[1];
			$loc_month = $loc_explode[2];
			$loc_year = $loc_explode[3];
			$loc_datestamp = $loc_date.'-'.$loc_month.'-'.$loc_year;
			
			if(date('d-M-Y') == $loc_datestamp){
				$new_loc_index = intval($loc_index) +  1;
			}else{
				$new_loc_index = 1;
			}
			$new_order_code = 'INV.'.$new_loc_index.'/'.date('d').'/'.date('M').'/'.date('Y');
		}
		return $new_order_code;
	}
	
	public function add_order(){
		if($this->session->userdata('level') == 1 || $this->session->userdata('level') == 3){
			$post = $_POST;		
			// var_dump($post);die;
			$param_order = array(
				'order_code' => $post['no_nota'],
				'order_custommer_name' => $post['nama'],
				'order_address'=> $post['alamat'],
				'order_contact'=> $post['kontak'],
				'order_email'=> $post['email'],
				'order_date_order'=> date('Y-m-d', strtotime($post['tgl_order'])),
				'order_date_design'=> date('Y-m-d', strtotime($post['tgl_lihat_design'])),
				'order_date_take'=> date('Y-m-m', strtotime($post['tgl_pengambilan'])),
				'order_amount'=> $post['total'],
				'order_down_payment'=> $post['dp'],
				'order_cash_minus'=> $post['kurang'],
				'order_payment_way'=> $post['payment_way'],
				'order_status'=> 1,
				'insert_user_id'=> $this->session->userdata('user_id'),
				'insert_timestamp'=>date('Y-m-d H:i:s')		
			);
			$this->db->trans_start();
			$execute = $this->cashier_model->insertOrder($param_order);
			
			if($execute){
				$id_order = $this->db->insert_id();
				for($i=0; $i<count($post['data_order']['product_id']); $i++){
					$inv = $this->cashier_model->getInvDetailById($post['data_order']['product_id'][$i]);
					$new_stock = intval($inv->inv_stock) - intval($post['data_order']['quantity'][$i]);
					$this->cashier_model->updateStock($new_stock, $post['data_order']['product_id'][$i]);
					$param_detail[] = array(
						'orderdetail_order_id'=>$id_order,
						'orderdetail_product_id'=>$post['data_order']['product_id'][$i],
						'orderdetail_quantity'=>$post['data_order']['quantity'][$i],
						'orderdetail_desc'=>$post['data_order']['desc'][$i]
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
		$data['type'] = $this->cashier_model->getcashierType();
		$data['category'] = $this->cashier_model->getcashierCategory();		
		$data['detail'] = $this->cashier_model->getInvDetailById($id);
		//var_dump($data);die;
		$this->load->view('admin/cashier/edit', $data);
	}
	
	public function doAdd(){
		if($this->session->userdata('level') == 1 || $this->session->userdata('level') == 3){
			//var_dump($_POST);//die;
			$param_inv = array(
				'inv_name' => $_POST['produk'],
				'inv_type_id' => $_POST['type'],
				'inv_category_id' => $_POST['category'],
				'inv_price' => $_POST['harga'],
				'inv_stock' => $_POST['stok'],
				'inv_desc' => $_POST['deskripsi']
			);
			//var_dump($param_inv);die;
			$result = $this->cashier_model->insertcashier($param_inv);
			
			if($result == true){
				redirect(base_url('index.php/cashier/index?msg=Am1'));
			}else{
				redirect(base_url('index.php/cashier/index?msg=Am0'));
			}
		}else{
			redirect(site_url(''));
		}	
		
	}
	
	public function doEdit(){
		if($this->session->userdata('level') == 1 || $this->session->userdata('level') == 3){
			//var_dump($_POST);die;
			$param_inv = array(
				'inv_name' => $_POST['produk'],
				'inv_type_id' => $_POST['type'],
				'inv_category_id' => $_POST['category'],
				'inv_price' => $_POST['harga'],
				'inv_stock' => $_POST['stok'],
				'inv_desc' => $_POST['deskripsi']
			);
			$id=$_POST['id'];
			$result = $this->cashier_model->Updatecashier($param_inv, $id);
			
			if($result == true){
				redirect(base_url('index.php/cashier/index?msg=Em1'));
			}else{
				redirect(base_url('index.php/cashier/index?msg=Em0'));
			}
		}else{
			redirect(site_url(''));
		}	
		
	}
	
	public function doDelete(){
		$this->load->view('add');
	}
	
	public function get_type_by_cat(){
		//var_dump($_POST);die;
		$type = $this->cashier_model->getTypeByCat($_POST['category_id']);
		
		$result = json_encode($type);
		echo $result;
		exit;
		
	}
	
	public function inv_print($id){
		if($this->session->userdata('level') == 1 || $this->session->userdata('level') == 3){
			$data['inv'] = $this->cashier_model->getInvDetailByInvNumber($id);		
			$data['inv_detail'] = $this->cashier_model->getInvDetail($data['inv']->order_id);
			// var_dump($data);die;
			$this->load->view('admin/cashier/print', $data);
		}else{
			redirect(site_url(''));
		}
	}
	
	public function list_invoice(){
		
		//var_dump($data['msg']);die;
		$data['invoice'] = $this->cashier_model->getInvoice();
		$this->load->view('admin/cashier/list', $data);
	}
	
	public function get_detail_invoice(){
		$result = $this->cashier_model->getDetailInvoiceByInvoiceCode($_POST['invo_number']);
		// var_dump($result);die;
		echo json_encode($result);
		exit;
	}
	
	public function doAcQuittal(){
		if($this->session->userdata('level') == 1 || $this->session->userdata('level') == 3){
			$post = $_POST;
			$result = 0;
			if(!empty($post['invo_number'])){
				$params = array(
					'order_amount'=>$post['total'],
					'order_retur'=>$post['retur'],
					'order_cash_minus'=>0,
					'update_user_id'=>$this->session->userdata('user_id'),
					'update_timestamp'=>date('Y-m-d H:i:s')
				);
				$update = $this->cashier_model->doUpdateOrder($params, $post['invo_number']);
				if($update){
					$result = 1;
				}
			}
			echo json_encode($result);
			exit;
		}else{
			redirect(site_url(''));
		}		
	}
	
	public function orderDone($id){
		if($this->session->userdata('level') == 1 || $this->session->userdata('level') == 3){
			$msg = '';
			$this->db->trans_start();
			if(!empty($id)){
				$order = $this->cashier_model->getOrderById($id);
				if(intval($order->order_cash_minus) > 0){
					$msg .= '<div class="alert alert-danger alert-dismissible">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<h4><i class="icon fa fa-check"></i> Gagal!</h4>
							Tagihan Belum Lunas.
						</div>';
					
				}else{
					$params = array(
						'order_status'=>0								
					);
					
					$result = $this->cashier_model->doUpdateOrderStat($params, $id);
				}
			}
			// var_dump($result);die;
			$this->db->trans_complete($result);
			if($result){
				$msg .= '<div class="alert alert-success alert-dismissible">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<h4><i class="icon fa fa-check"></i> Berhasil!</h4>
							Job Order Selesai
						</div>';
			}else{
				
				$msg .= '<div class="alert alert-danger alert-dismissible">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<h4><i class="icon fa fa-check"></i> Gagal!</h4>
							Job Order Gagal Diperbarui.
						</div>';
			}
			$this->session->set_flashdata('msg', $msg);
			$url = site_url('cashier/list_invoice');				
			redirect($url);
			
		}else{
			redirect(site_url(''));
		}
	}
	private function getMessage($idx){
		if($idx == 'Em1'){
			return '
				<div class="alert alert-success alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-check"></i> Berhasil!</h4>
					Edit Data cashier Sukses.
				</div>
			';
		}elseif($idx == 'Em0'){
			return '
				<div class="alert alert-danger alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-check"></i> Gagal!</h4>
					Edit Data cashier Gagal.
				</div>
			';
		}elseif($idx == 'Am1'){
			return '
				<div class="alert alert-success alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-check"></i> Berhasil!</h4>
					Tambah Data cashier Sukses.
				</div>
			';
		}elseif($idx == 'Am0'){
			return '
				<div class="alert alert-danger alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-check"></i> Gagal!</h4>
					Tambah Data cashier Gagal.
				</div>
			';
		}elseif($idx == 'Dm1'){
			return '
				<div class="alert alert-success alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-check"></i> Berhasil!</h4>
					Hapus Data cashier Sukses.
				</div>
			';
		}elseif($idx == 'Dm0'){
			return '
				<div class="alert alert-danger alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-check"></i> Gagal!</h4>
					Hapus Data cashier Gagal.
				</div>
			';
		}elseif($idx == 'ord_done'){
			return '
				<div class="alert alert-success alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-check"></i> Berhasil!</h4>
					Job Order Telah Selesai.
				</div>
			';
		}elseif($idx == 'ord_fail'){
			return '
				<div class="alert alert-danger alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-check"></i> Gagal!</h4>
					Update Status Job Order Gagal.
				</div>
			';
		}elseif($idx == 'ord_done_txt'){
			return '
				Job Order Telah Selesai.
				
			';
		}elseif($idx == 'ord_fail_txt'){
			return '
				Update Status Job Order Gagal.
				
			';
		}
	}
}
