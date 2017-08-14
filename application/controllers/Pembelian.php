<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembelian extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
		$this->load->model('pembelian_model');
		$this->load->library('authex');
		$this->load->library('foto_upload');
		
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
			$this->load->view('admin/pembelian/add');
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
