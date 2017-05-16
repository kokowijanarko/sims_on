<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
		$this->load->model('user_model');
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
			$data['list'] = $this->user_model->getUser();
			//var_dump($data);die;
			$this->load->view('admin/user/list', $data);
		}else{
			redirect(site_url(''));
		}	
	}
	
	public function add(){
		if($this->session->userdata('level') == 1 || $this->session->userdata('level') == 2){
			$data['level'] = $this->user_model->getUserLevel();
			//var_dump($data);die;
			$this->load->view('admin/user/add', $data);
		}else{
			redirect(site_url(''));
		}		
	}
	
	public function edit($id){
		if($this->session->userdata('level') == 1  || $this->session->userdata('level') == 2){
			$data['level'] = $this->user_model->getUserLevel();	
			$data['detail'] = $this->user_model->getDetailUser($id);
			// var_dump($data);die;
			$this->load->view('admin/user/edit', $data);

		}else{
			redirect(site_url(''));
		}	
		
	}
	
	public function doAdd(){
			var_dump($_POST, $_FILES);
			if(!empty($_POST)){
				$this->db->trans_start();
				$password = md5($_POST['username']);	
				$foto_name = str_replace(' ', '_', $_POST['full_name']).'-'.$_POST['level'].'.jpeg';
				$param = array(
					'user_name'=>$_POST['full_name'],
					'user_username'=>$_POST['username'],
					'user_email'=>$_POST['email'],
					'user_level_id'=>$_POST['level'],
					'user_desc'=>$_POST['deskripsi'],
					'user_password'=>$password
				);
				$result = $this->user_model->insertUser($param);
				// var_dump($_FILES);die;
				if($result && $_FILES['photo']['error'] != 4 && $_FILES['photo']['type'] == 'image/jpeg'){				
					
					$result = $result && $this->foto_upload->process_image($_FILES['photo']['tmp_name'], $foto_name);	
				}
				$this->db->trans_complete($result);
				
				if($result){
				redirect(base_url('index.php/user/index?msg=Am1'));
				}else{
					redirect(base_url('index.php/user/index?msg=Am0'));
				}
			}else{
				redirect(site_url('user/add'));
			}
		
	}
	
	public function doEdit(){
			$this->db->trans_start();
			$foto_name = str_replace(' ', '_', $_POST['user_name']).'-'.$_POST['level'].'.jpeg';
			$param = array(
				'user_name'=>$_POST['user_name'],
				'user_username'=>$_POST['user_username'],
				'user_level_id'=>$_POST['level'],
				'user_desc'=>$_POST['deskripsi'],
				'user_photo_name'=>$foto_name
			);
			$id=$_POST['id'];
			$result = $this->user_model->updateUser($param, $id);
			if($result && $_FILES['photo']['error'] != 4){
				$upload = $this->do_upload($foto_name);		
				// var_dump($upload);die;
			}
			$this->db->trans_complete($result);
			if($result == true){
				redirect(base_url('index.php/user/index?msg=Em1'));
			}else{
				redirect(base_url('index.php/user/index?msg=Em0'));
			}

	
	}
	
	public function doEditProffile(){
			$this->db->trans_start();
			$id=$_POST['id'];
			$detail = $this->user_model->getDetailUser($id);			
			$foto_name = str_replace(' ', '_', $_POST['user_name']).'-'.$this->session->userdata('level').'.jpeg';
			// var_dump($foto_name);die;
			$param = array();
			if($_POST['user_password'] != ''){
				$old_password = md5($_POST['user_password_old']);
				if($detail->user_password == $old_password){
					if($_POST['user_password_conf'] == $_POST['user_password']){
						$new_password = md5($_POST['user_password']);
						$param = array(
							'user_name'=>$_POST['user_name'],
							'user_username'=>$_POST['user_username'],
							'user_level_id'=>$_POST['level'],
							'user_desc'=>$_POST['deskripsi'],
							'user_password'=>$new_password,
							'user_photo_name'=>$foto_name
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
				
				$result = $this->user_model->updateUser($param, $id);
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
			redirect(base_url('index.php/user/profile/'. $id));
		
	}
	
	public function doDelete($id){
		if($this->session->userdata('level') == 1  ){
			$user = $this->user_model->getDetailUser($id);
			unlink('assets/user_img/'. $user->user_photo_name);
			$result = $this->user_model->deleteInv($id);
			if($result == true){
				redirect(site_url('user/index?msg=Dm1'));
			}else{
				redirect(site_url('user/index?msg=Dm0'));			
			}

		}else{
			redirect(site_url(''));
		}		
	}
	
	public function profile($id){
		if(!empty($this->session->userdata('level'))){
			$data['level'] = $this->user_model->getUserLevel();	
			$data['detail'] = $this->user_model->getDetailUser($id);
			// var_dump($data);die;
			$this->load->view('admin/user/profile', $data);

		}else{
			redirect(site_url(''));
		}	
	}
	private function do_upload($name)
        {
                $config['upload_path']      = 'assets/user_img/';
                $config['allowed_types']    = 'gif|jpg|png|JPG|PNG|jpeg|JPEG';
                $config['max_size']         = 10000;
				$config['overwrite'] 		= TRUE;
                $config['file_name']        = $name;
                $this->load->library('upload', $config);
				$this->upload->do_upload('photo');				
				var_dump($this->upload->display_errors('<p>', '</p>'));
                return $this->upload->display_errors('<p>', '</p>');
        }
		
	private function getMessage($idx){
		if($idx == 'Em1'){
			return '
				<div class="alert alert-success alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-check"></i> Berhasil!</h4>
					Edit Data user Sukses.
				</div>
			';
		}elseif($idx == 'Em0'){
			return '
				<div class="alert alert-danger alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-check"></i> Gagal!</h4>
					Edit Data user Gagal.
				</div>
			';
		}elseif($idx == 'Am1'){
			return '
				<div class="alert alert-success alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-check"></i> Berhasil!</h4>
					Tambah Data user Sukses.
				</div>
			';
		}elseif($idx == 'Am0'){
			return '
				<div class="alert alert-danger alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-check"></i> Gagal!</h4>
					Tambah Data user Gagal.
				</div>
			';
		}elseif($idx == 'Dm1'){
			return '
				<div class="alert alert-success alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-check"></i> Berhasil!</h4>
					Hapus Data user Sukses.
				</div>
			';
		}elseif($idx == 'Dm0'){
			return '
				<div class="alert alert-danger alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-check"></i> Gagal!</h4>
					Hapus Data user Gagal.
				</div>
			';
		}
	}
}
