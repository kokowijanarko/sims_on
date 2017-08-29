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
		 
			if(isset($_GET['msg'])){
				$data['message'] = $this->getMessage($_GET['msg']);
			}
			
			$data['order_code'] = $this->orderCodeGenerator();
			$data['produk'] = $this->cashier_model->getInventory();
			$data['customer'] = $this->cashier_model->getCustomer();
			
			$this->load->view('admin/cashier/add', $data);
		 	
		
		
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
		 
			$post = $_POST;	
			//var_dump($post);
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
		 	
		
	}
	
	public function edit($id){
		$data['type'] = $this->cashier_model->getcashierType();
		$data['category'] = $this->cashier_model->getcashierCategory();		
		$data['detail'] = $this->cashier_model->getInvDetailById($id);
		//var_dump($data);die;
		$this->load->view('admin/cashier/edit', $data);
	}
	
	public function doAdd(){
		 
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
		 	
		
	}
	
	public function doEdit(){
		 
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
		 
			$data['inv'] = $this->cashier_model->getInvDetailByInvNumber($id);		
			$data['inv_detail'] = $this->cashier_model->getInvDetailById($data['inv']->id_penj);
			// var_dump($data);die;
			$this->load->view('admin/cashier/print', $data);
		 
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
		 		
	}
	
	public function orderDone($id){
		 
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
