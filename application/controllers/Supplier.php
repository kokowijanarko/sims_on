<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
		$this->load->model('supplier_model');
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
			$data['list'] = $this->supplier_model->getSupplier();
			// var_dump($data);die;
			$this->load->view('admin/supplier/list', $data);
		}else{
			redirect(site_url(''));
		}	
	}
	
	public function add(){
		if($this->session->userdata('level') == 1 || $this->session->userdata('level') == 2){
			$this->load->view('admin/supplier/add');
		}else{
			redirect(site_url(''));
		}		
	}
	
	public function edit($id){
		if($this->session->userdata('level') == 1  || $this->session->userdata('level') == 2){
			$data['detail'] = $this->supplier_model->getDetailSupplier($id);
			// var_dump($data);die;
			$this->load->view('admin/supplier/edit', $data);

		}else{
			redirect(site_url(''));
		}	
		
	}
	
	public function doAdd(){
			// var_dump($_POST);die;
			if(!empty($_POST)){
				$this->db->trans_start();
				
				$result = $this->supplier_model->insertSupplier($_POST);
				// var_dump($result);die;
				$this->db->trans_complete($result);
				
				if($result){
				redirect(base_url('index.php/supplier/index?msg=Am1'));
				}else{
					redirect(base_url('index.php/supplier/index?msg=Am0'));
				}
			}else{
				redirect(site_url('user/add'));
			}
		
	}
	
	public function doEdit(){
		
		$this->db->trans_start();
		
		$result = $this->supplier_model->updateSupplier($_POST, $_POST['id_sup']);
		// var_dump($result);die;
		$this->db->trans_complete($result);
		if($result == true){
			redirect(base_url('index.php/supplier/index?msg=Em1'));
		}else{
			redirect(base_url('index.php/supplier/index?msg=Em0'));
		}

	
	}
	
	public function doEditProffile(){
			$this->db->trans_start();
			$id=$_POST['id'];
			$detail = $this->supplier_model->getDetailUser($id);			
			$foto_name = str_replace(' ', '_', $_POST['user_name']).'-'.$this->session->userdata('level').'.jpeg';
			// var_dump($foto_name);die;
			$param = array();
			if($_POST['user_password'] != ''){
				$old_password = md5($_POST['user_password_old']);
				if($detail->user_password == $old_password){
					if($_POST['user_password_conf'] == $_POST['user_password']){
						$new_password = md5($_POST['user_password']);
						$param = array(
							'nama_user'=>$_POST['user_username'],
							'level'=>$_POST['level'],
							'password'=>$new_password,
							'photo'=>$foto_name
						);
					}else{
						$msg = '
							<div class="alert alert-danger alert-dismissible disabled">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								<h4><i class="icon fa fa-check"></i>Password Tidak Cocok !</h4>
							</div>
						';
					}
				}else{
					$msg = '
						<div class="alert alert-danger alert-dismissible disabled">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<h4><i class="icon fa fa-check"></i>Password Salah !</h4>
						</div>
					';
				}
			}else{
				$param = array(
					'user_name'=>$_POST['user_name'],
					'user_username'=>$_POST['user_username'],
					'user_email'=>$_POST['user_email'],
					'user_desc'=>$_POST['deskripsi'],
					'user_photo_name'=>$foto_name
				);

			}
			if(!empty($param)){
				
				$result = $this->supplier_model->updateUser($param, $id);
			}
			var_dump($_FILES);
			if($result && $_FILES['photo']['error'] != 4){
				unlink('assets/user_img/'. $foto_name);	
				$upload = $this->do_upload($foto_name);	
				
				$this->session->set_userdata("photo", $foto_name);
				//var_dump($this->session->userdata());die;
				if($upload != ''){
					$msg = '
						<div class="alert alert-danger alert-dismissible disabled">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<h4><i class="icon fa fa-check"></i> '. $upload .' !</h4>
						</div>
					';
				}
			}
			if($result && !isset($msg)){
				$msg .= '
					<div class="alert alert-success alert-dismissible disabled">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<h4><i class="icon fa fa-check"></i>Ubah Profil berhasil !</h4>
					</div>
					';
			}elseif(!isset($msg)){
				$msg .= '
					<div class="alert alert-danger alert-dismissible disabled">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<h4><i class="icon fa fa-check"></i>Ubah Profil Gagal !</h4>
					</div>
					';
			}
			$this->session->set_flashdata('msg', $msg);
			$this->db->trans_complete($result);
			redirect(base_url('index.php/supplier/profile/'. $id));
		
	}
	
	public function doDelete($id){
		if($this->session->userdata('level') == 1  ){
			
			$result = $this->supplier_model->deleteSupplier($id);
			if($result == true){
				redirect(site_url('supplier/index?msg=Dm1'));
			}else{
				redirect(site_url('supplier/index?msg=Dm0'));			
			}

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
					Edit Data supplier Sukses.
				</div>
			';
		}elseif($idx == 'Em0'){
			return '
				<div class="alert alert-danger alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-check"></i> Gagal!</h4>
					Edit Data supplier Gagal.
				</div>
			';
		}elseif($idx == 'Am1'){
			return '
				<div class="alert alert-success alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-check"></i> Berhasil!</h4>
					Tambah Data supplier Sukses.
				</div>
			';
		}elseif($idx == 'Am0'){
			return '
				<div class="alert alert-danger alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-check"></i> Gagal!</h4>
					Tambah Data supplier Gagal.
				</div>
			';
		}elseif($idx == 'Dm1'){
			return '
				<div class="alert alert-success alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-check"></i> Berhasil!</h4>
					Hapus Data supplier Sukses.
				</div>
			';
		}elseif($idx == 'Dm0'){
			return '
				<div class="alert alert-danger alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-check"></i> Gagal!</h4>
					Hapus Data supplier Gagal.
				</div>
			';
		}
	}
}
