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
 
			if(isset($_GET['msg'])){
				$data['message'] = $this->getMessage($_GET['msg']);
			}
			$data['list'] = $this->user_model->getUser();
			// var_dump($data);die;
			$this->load->view('admin/user/list', $data);
		 	
	}
	
	public function add(){
 
			$data['level'] = array(
				array(
					'id'=>2, 
					'name'=>'admin'
				),
				array(
					'id'=>3, 
					'name'=>'owner'
				),
			
			);
			//var_dump($data);die;
			$this->load->view('admin/user/add', $data);
		 		
	}
	
	public function edit($id){
		 
			$data['level'] = array(
				array(
					'id'=>2, 
					'name'=>'admin'
				),
				array(
					'id'=>3, 
					'name'=>'owner'
				),
			
			);
			$data['detail'] = $this->user_model->getDetailUser($id);
			// var_dump($data);die;
			$this->load->view('admin/user/edit', $data);

		 	
		
	}
	
	public function doAdd(){
			// var_dump($_POST, $_FILES);
			if(!empty($_POST)){
				$this->db->trans_start();
				$password = md5($_POST['username']);	
				$foto_name = str_replace(' ', '_', $_POST['username']).'-'.$_POST['level'].'.jpeg';
				$param = array(
					'nama_user'=>$_POST['username'],
					'level'=>$_POST['level'],
					'password'=>$password,
					'photo'=>$foto_name
				);
				// var_dump($param);die;
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
			// var_dump($_FILES);die;
			$this->db->trans_start();			
			$param = array(
				'nama_user'=>$_POST['username'],
				'level'=>$_POST['level']
			);
			$id=$_POST['id'];
			$result = $this->user_model->updateUser($param, $id);
			if($result && $_FILES['photo']['error'] != 4){
				$foto_name = str_replace(' ', '_', $_POST['username']).'-'.$_POST['level'].'.jpeg';
				$param = array(
					'photo'=>$foto_name
				);
				$result = $result && $this->user_model->updateUser($param, $id);
				if($result){
					$result = $result && $this->foto_upload->process_image($_FILES['photo']['tmp_name'], $foto_name);	
				}
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
				if($detail->password == $old_password){
					if($_POST['user_password_conf'] == $_POST['user_password']){
						$new_password = md5($_POST['user_password']);
						$param = array(
							'nama_user'=>$_POST['username'],
							'password'=>$new_password
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
					'nama_user'=>$_POST['username']
				);

			}
			if(!empty($param)){
				
				$result = $this->user_model->updateUser($param, $id);
			}
			// var_dump($_FILES);
			
			if($result && $_FILES['photo']['error'] != 4){
				$foto_name = str_replace(' ', '_', $_POST['username']).'-'.$_POST['level'].'.jpeg';
				$param = array(
					'photo'=>$foto_name
				);
				$result = $result && $this->user_model->updateUser($param, $id);
				if($result){
					$result = $result && $this->foto_upload->process_image($_FILES['photo']['tmp_name'], $foto_name);	
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
		 
			$user = $this->user_model->getDetailUser($id);
			unlink('assets/user_img/'. $user->photo);
			$result = $this->user_model->deleteInv($id);
			if($result == true){
				redirect(site_url('user/index?msg=Dm1'));
			}else{
				redirect(site_url('user/index?msg=Dm0'));			
			}

		 		
	}
	
	public function profile($id){
		 
			$data['level'] = array(
				array(
					'id'=>2, 
					'name'=>'admin'
				),
				array(
					'id'=>3, 
					'name'=>'owner'
				),
			
			);
			$data['detail'] = $this->user_model->getDetailUser($id);
			// var_dump($data);die;
			$this->load->view('admin/user/profile', $data);

		 	
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
