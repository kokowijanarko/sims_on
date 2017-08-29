<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
		$this->load->model('Customer_model');
		$this->load->library('authex');
		$this->load->library('foto_upload');
		
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
			$data['list'] = $this->Customer_model->getCustomer();
			// var_dump($data);die;
			$this->load->view('admin/customer/list', $data);
		 	
	}
	
	public function add(){
 
			$this->load->view('admin/customer/add');
		 		
	}
	
	public function edit($id){
		 
			$data['detail'] = $this->Customer_model->getDetailCustomer($id);
			// var_dump($data);die;
			$this->load->view('admin/customer/edit', $data);

		 	
		
	}
	
	public function doAdd(){
			// var_dump($_POST);die;
			if(!empty($_POST)){
				$this->db->trans_start();
				
				$result = $this->Customer_model->insertCustomer($_POST);
				// var_dump($result);die;
				$this->db->trans_complete($result);
				
				if($result){
				redirect(base_url('index.php/customer/index?msg=Am1'));
				}else{
					redirect(base_url('index.php/customer/index?msg=Am0'));
				}
			}else{
				redirect(site_url('user/add'));
			}
		
	}
	
	public function doEdit(){
		
		$this->db->trans_start();
		
		$result = $this->Customer_model->updateCustomer($_POST, $_POST['id_sup']);
		// var_dump($result);die;
		$this->db->trans_complete($result);
		if($result == true){
			redirect(base_url('index.php/customer/index?msg=Em1'));
		}else{
			redirect(base_url('index.php/customer/index?msg=Em0'));
		}

	
	}
	
	
	public function doDelete($id){
		 
			
			$result = $this->Customer_model->deleteCustomer($id);
			if($result == true){
				redirect(site_url('Customer/index?msg=Dm1'));
			}else{
				redirect(site_url('Customer/index?msg=Dm0'));			
			}

		 		
	}
	
	
	private function getMessage($idx){
		if($idx == 'Em1'){
			return '
				<div class="alert alert-success alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-check"></i> Berhasil!</h4>
					Edit Data Customer Sukses.
				</div>
			';
		}elseif($idx == 'Em0'){
			return '
				<div class="alert alert-danger alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-check"></i> Gagal!</h4>
					Edit Data Customer Gagal.
				</div>
			';
		}elseif($idx == 'Am1'){
			return '
				<div class="alert alert-success alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-check"></i> Berhasil!</h4>
					Tambah Data Customer Sukses.
				</div>
			';
		}elseif($idx == 'Am0'){
			return '
				<div class="alert alert-danger alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-check"></i> Gagal!</h4>
					Tambah Data Customer Gagal.
				</div>
			';
		}elseif($idx == 'Dm1'){
			return '
				<div class="alert alert-success alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-check"></i> Berhasil!</h4>
					Hapus Data Customer Sukses.
				</div>
			';
		}elseif($idx == 'Dm0'){
			return '
				<div class="alert alert-danger alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-check"></i> Gagal!</h4>
					Hapus Data Customer Gagal.
				</div>
			';
		}
	}
}
