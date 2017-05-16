<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inventory extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
		$this->load->model('Inventory_model');
		$this->load->library('authex');
		
		$login = $this->authex->logged_in();
		if(!$login){
			redirect(site_url(''));
		}
    }
	
	public function index()
	{	
		if(!empty($this->session->userdata('level'))){
			if(isset($_GET['msg'])){
				$data['message'] = $this->getMessage($_GET['msg']);
			}
			$filter = array();
			
			if($_POST){
				$filter['product'] = $_POST['product'];
				$filter['category'] = $_POST['category'];
			}			
			$data['list'] = $this->Inventory_model->getProduct($filter);
			// var_dump($data);die;
			$cat = $this->Inventory_model->getProductCategory();
			
			$category = array();
			foreach($cat as $key=>$val){
				$category[$key]['id'] = $val->category_id; 
				$category[$key]['parent_id'] = $val->category_parent_id; 
				$category[$key]['name'] = $val->category_name; 
			}
			
			$data['category'] = $this->treeView($category);
			$data['filter'] = $filter;
			// var_dump($data);die;
			$this->load->view('admin/inventory/list', $data);
		}else{
			redirect(site_url(''));
		}	
	}
	
	public function add(){
		if($this->session->userdata('level') == 1 || $this->session->userdata('level') == 2){
			
			$cat = $this->Inventory_model->getProductCategory();
			
			$category = array();
			foreach($cat as $key=>$val){
				$category[$key]['id'] = $val->category_id; 
				$category[$key]['parent_id'] = $val->category_parent_id; 
				$category[$key]['name'] = $val->category_name; 
			}
			
			$data['category'] = $this->treeView($category);

			
			// var_dump($data);die;
			$this->load->view('admin/inventory/add', $data);
		}else{
			redirect(site_url(''));
		}		
	}
	
	
	
	public function edit($id){
		if($this->session->userdata('level') == 1 || $this->session->userdata('level') == 2){
			$cat = $this->Inventory_model->getProductCategory();
			
			$category = array();
			foreach($cat as $key=>$val){
				$category[$key]['id'] = $val->category_id; 
				$category[$key]['parent_id'] = $val->category_parent_id; 
				$category[$key]['name'] = $val->category_name; 
			}
			
			$data['category'] = $this->treeView($category);
			
			$data['detail'] = $this->Inventory_model->getProductDetailById($id);
			// var_dump($data['detail']);die;
			$this->load->view('admin/inventory/edit', $data);

		}else{
			redirect(site_url(''));
		}	
		
	}
	
	public function doAdd(){
		// var_dump($_POST);die;
		if($this->session->userdata('level') == 1 || $this->session->userdata('level') == 2){
			//var_dump($_POST);//die;
			$param_inv = array(
				'product_name' => $_POST['produk'],
				'product_category_id' => $_POST['category'],
				'product_price' => $_POST['harga'],
				'product_price_base' => $_POST['harga_dasar'],
				'product_stock' => $_POST['stok'],
				'product_desc' => $_POST['deskripsi'],
				'insert_user_id' => $this->session->userdata('user_id'),
				'insert_timestamp'=> date('Y-m-h h:i:s')
			);
			
			// var_dump($param_inv);die;
			
			$result = $this->Inventory_model->insertProduct($param_inv);
			
			if($result == true){
				redirect(base_url('index.php/inventory/index?msg=Am1'));
			}else{
				redirect(base_url('index.php/inventory/index?msg=Am0'));
			}

		}else{
			redirect(site_url(''));
		}
		
	}
	
	public function doEdit(){
		if($this->session->userdata('level') == 1 || $this->session->userdata('level') == 2){
			$param_inv = array(
				'product_name' => $_POST['produk'],
				'product_category_id' => $_POST['category'],
				'product_price' => $_POST['harga'],
				'product_price_base' => $_POST['harga_dasar'],
				'product_stock' => $_POST['stok'],
				'product_desc' => $_POST['deskripsi'],
				'update_user_id' => $this->session->userdata('user_id'),
				'update_timestamp'=> date('Y-m-h h:i:s')
			);
			$id=$_POST['id'];
			$result = $this->Inventory_model->updateProduct($param_inv, $id);
			// var_dump($this->db->last_query());die;
			if($result == true){
				redirect(base_url('index.php/inventory/index?msg=Em1'));
			}else{
				redirect(base_url('index.php/inventory/index?msg=Em0'));
			}

		}else{
			redirect(site_url(''));
		}
	}
	
	public function doDelete($id){
		if($this->session->userdata('level') == 1 || $this->session->userdata('level') == 2){
			$result = $this->Inventory_model->deleteInv($id);
			if($result == true){
				redirect(site_url('inventory/index?msg=Dm1'));
			}else{
				redirect(site_url('inventory/index?msg=Dm0'));			
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
					Edit Data Inventory Sukses.
				</div>
			';
		}elseif($idx == 'Em0'){
			return '
				<div class="alert alert-danger alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-check"></i> Gagal!</h4>
					Edit Data Inventory Gagal.
				</div>
			';
		}elseif($idx == 'Am1'){
			return '
				<div class="alert alert-success alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-check"></i> Berhasil!</h4>
					Tambah Data Inventory Sukses.
				</div>
			';
		}elseif($idx == 'Am0'){
			return '
				<div class="alert alert-danger alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-check"></i> Gagal!</h4>
					Tambah Data Inventory Gagal.
				</div>
			';
		}elseif($idx == 'Dm1'){
			return '
				<div class="alert alert-success alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-check"></i> Berhasil!</h4>
					Hapus Data Inventory Sukses.
				</div>
			';
		}elseif($idx == 'Dm0'){
			return '
				<div class="alert alert-danger alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-check"></i> Gagal!</h4>
					Hapus Data Inventory Gagal.
				</div>
			';
		}
	}
	
	function treeView($items, $root_id = 0) {
        $this->html = array();
        $this->items = $items;

        foreach ($this->items as $item)
            $children[$item['parent_id']][] = $item;

        // loop will be false if the root has no children (i.e., an empty menu!)
        $loop = !empty($children[$root_id]);

        // initializing $parent as the root
        $parent = $root_id;
        $parent_stack = array();

        while ($loop && (($option = each($children[$parent])) || ($parent > $root_id))) {
            if ($option === false) {
                $parent = array_pop($parent_stack);
            } elseif (!empty($children[$option['value']['id']])) {
                $tab = str_repeat("&nbsp;&nbsp;", (count($parent_stack) + 1) * 2 - 2);

                // menu item containing childrens (open)
                $this->html[] = array(
                    'id' => $option['value']['id'],
                    'name' => $tab . $option['value']['name']
                );

                array_push($parent_stack, $option['value']['parent_id']);
                $parent = $option['value']['id'];
            } else {
                $tab = str_repeat("&nbsp;&nbsp;", (count($parent_stack) + 1) * 2 - 2);
                // menu item with no children (aka "leaf")

                $this->html[] = array(
                    'id' => $option['value']['id'],
                    'name' => $tab . $option['value']['name']
                );
            }
        }

        return $this->html;
    }
}
