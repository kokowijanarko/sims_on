<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mass_price extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
		$this->load->model('MassPrice_model');
			
    }
	
	public function listing($id=null, $mspr_id=null)
	{
		//var_dump($id, $mspr_id);die;
		if(isset($_GET['msg'])){
			$data['message'] = $this->getMessage($_GET['msg']);
		}
		if($mspr_id !== null){
			$data['detail'] = $this->MassPrice_model->getMassPriceById($mspr_id);
		}
		$data['list'] = $this->MassPrice_model->getMassPrice($id);
		$data['inventory'] = $this->MassPrice_model->getInvDetailById($id);
		//var_dump($data);die;
		//var_dump($data);die;
		$this->load->view('admin/mass_price/list', $data);
	}
	
	public function add(){
		$data['type'] = $this->MassPrice_model->getinventoryType();
		$data['category'] = $this->MassPrice_model->getinventoryCategory();
		//var_dump($data);die;
		$this->load->view('admin/mass_price/add', $data);
	}
	
	public function edit($id){
		$data['type'] = $this->MassPrice_model->getinventoryType();
		$data['category'] = $this->MassPrice_model->getinventoryCategory();		
		$data['detail'] = $this->MassPrice_model->getInvDetailById($id);
		//var_dump($data);die;
		$this->load->view('admin/mass_price/edit', $data);
	}
	
	public function doAdd(){
		//var_dump($_POST);die;
		if(intval($_POST['start']) > intval($_POST['end'])){
			redirect(site_url('mass_price/listing/'.$_POST['produk_id'].'?msg=Er0'));
		}else{
			$param_mass_price = array (
				'massprice_inv_id' => $_POST['produk_id'],
				'massprice_range_start' => $_POST['start'],
				'massprice_range_end' => (!empty(trim($_POST['end'])))?$_POST['end']:9999999, 
				'massprice_price' => $_POST['harga']
			);
			//var_dump(!empty($param_mass_price));die;
			$this->db->trans_start();
			if(empty(trim($_POST['mass_price_id'])) || $_POST['mass_price_id'] == ''){
				$result = $this->MassPrice_model->insertMassPrice($param_mass_price);
				//var_dump($this->db->last_query());die;
				$this->db->trans_complete($result);
				if($result == true){
					redirect(site_url('mass_price/listing/'.$_POST['produk_id'].'?msg=Am1'));
				}else{
					redirect(site_url('mass_price/listing'.$_POST['produk_id'].'?msg=Am0'));
				}			
			}else{
				$result = $this->MassPrice_model->updateMassPrice($param_mass_price, $_POST['mass_price_id']);
				//var_dump($this->db->last_query());die;
				$this->db->trans_complete($result);
				if($result == true){
					redirect(site_url('mass_price/listing/'.$_POST['produk_id'].'?msg=Em1'));
				}else{
					redirect(site_url('mass_price/listing/'.$_POST['produk_id'].'?msg=Em0'));
				}
			}
			
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
		$result = $this->MassPrice_model->UpdateInventory($param_inv, $id);
		
		if($result == true){
			redirect(base_url('index.php/inventory/index?msg=Em1'));
		}else{
			redirect(base_url('index.php/inventory/index?msg=Em0'));
		}
	}
	
	public function doDelete($id=null, $mspr_id=null){
		$result = $this->MassPrice_model->deleteMassPrice($mspr_id);
		if($result == true){
				redirect(site_url('mass_price/listing/'.$id.'?msg=Dm1'));
			}else{
				redirect(site_url('mass_price/listing'.$id.'?msg=Dm0'));
			}
	}
	
	private function getMessage($idx){
		if($idx == 'Em1'){
			return '
				<div class="alert alert-success alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-check"></i> Berhasil!</h4>
					Edit Data Produk Masal Sukses.
				</div>
			';
		}elseif($idx == 'Em0'){
			return '
				<div class="alert alert-danger alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-check"></i> Gagal!</h4>
					Edit Data Produk Masal Gagal.
				</div>
			';
		}elseif($idx == 'Am1'){
			return '
				<div class="alert alert-success alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-check"></i> Berhasil!</h4>
					Tambah Data Produk Masal Sukses.
				</div>
			';
		}elseif($idx == 'Am0'){
			return '
				<div class="alert alert-danger alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-check"></i> Gagal!</h4>
					Tambah Data Produk Masal Gagal.
				</div>
			';
		}elseif($idx == 'Dm1'){
			return '
				<div class="alert alert-success alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-check"></i> Berhasil!</h4>
					Hapus Data Produk Masal Sukses.
				</div>
			';
		}elseif($idx == 'Dm0'){
			return '
				<div class="alert alert-danger alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-check"></i> Gagal!</h4>
					Hapus Data Produk Masal Gagal.
				</div>
			';
		}elseif($idx == 'Er0'){
			return '
				<div class="alert alert-danger alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-check"></i> Gagal!</h4>
					Field Mulai dan Sampai Tidak Singkron.
				</div>
			';
		}
	}
}
