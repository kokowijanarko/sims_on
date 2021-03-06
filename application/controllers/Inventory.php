<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inventory extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
		$this->load->model('Inventory_model');
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
			$filter = array();
			
			if($_POST){
				$filter['product'] = $_POST['product'];
				$filter['category'] = $_POST['category'];
			}			
			$data['list'] = $this->Inventory_model->getProduct($filter);
			// var_dump($data);die;
			// $cat = $this->Inventory_model->getProductCategory();
			
			$category = array(
				array(
					'id'=>1,
					'name'=>'gamis'
				),
				array(
					'id'=>2,
					'name'=>'jilbab'
				),			
			);
			$data['category'] = $category;
			// foreach($cat as $key=>$val){
				// $category[$key]['id'] = $val->category_id; 
				// $category[$key]['parent_id'] = $val->category_parent_id; 
				// $category[$key]['name'] = $val->category_name; 
			// }
			
			
			// $data['category'] = $this->treeView($category);
			$data['filter'] = $filter;
			// var_dump($data);die;
			$this->load->view('admin/inventory/list', $data);
		 	
	}
	
	public function add(){
 
			
			// $cat = $this->Inventory_model->getProductCategory();
			
			$category = array(
				array(
					'id'=>1,
					'name'=>'gamis'
				),
				array(
					'id'=>2,
					'name'=>'jilbab'
				),			
			);
			// foreach($cat as $key=>$val){
				// $category[$key]['id'] = $val->category_id; 
				// $category[$key]['parent_id'] = $val->category_parent_id; 
				// $category[$key]['name'] = $val->category_name; 
			// }
			
			$data['category'] = $category;

			
			// var_dump($data);die;
			$this->load->view('admin/inventory/add', $data);
		 		
	}
	
	
	
	public function edit($id){
 
			$category = array(
				array(
					'id'=>1,
					'name'=>'gamis'
				),
				array(
					'id'=>2,
					'name'=>'jilbab'
				),			
			);
			$data['category'] = $category;			
			$data['detail'] = $this->Inventory_model->getProductDetailById($id);
			// var_dump($data['detail']);die;
			$this->load->view('admin/inventory/edit', $data);

		 	
		
	}
	
	public function doAdd(){
		// var_dump($_POST);die;
 
			//var_dump($_POST);//die;
			$foto_name = $_POST['produk'].'_'.$_POST['category'].'.jpeg';
			$param_inv = array(
				'nama_prod' => $_POST['produk'],
				'jenis_prod' => $_POST['category'],
				'harga' => $_POST['harga'],
				'stok' => $_POST['stok'],
				'photo'=>$foto_name
			);
			
			// var_dump($param_inv);die;
			
			$result = $this->Inventory_model->insertProduct($param_inv);
			if($result && $_FILES['photo']['error'] != 4 && $_FILES['photo']['type'] == 'image/jpeg'){				
				$result = $result && $this->foto_upload->process_image($_FILES['photo']['tmp_name'], $foto_name);	
			}
				
			if($result == true){
				redirect(base_url('index.php/inventory/index?msg=Am1'));
			}else{
				redirect(base_url('index.php/inventory/index?msg=Am0'));
			}

		 
		
	}
	
	public function doEdit(){
			// var_dump($_FILES);die;
			$foto_name = $_POST['produk'].'_'.$_POST['category'].'.jpeg';
			$param_inv = array(
				'nama_prod' => $_POST['produk'],
				'jenis_prod' => $_POST['category'],
				'harga' => $_POST['harga'],
				'stok' => $_POST['stok'],
				'photo'=>$foto_name
			);
			$id=$_POST['id'];
			$result = $this->Inventory_model->updateProduct($param_inv, $id);
			// var_dump($this->db->last_query());die;
			if($result && $_FILES['photo']['error'] != 4 && $_FILES['photo']['type'] == 'image/jpeg'){				
				$result = $result && $this->foto_upload->process_image($_FILES['photo']['tmp_name'], $foto_name);	
			}
			if($result == true){
				redirect(base_url('index.php/inventory/index?msg=Em1'));
			}else{
				redirect(base_url('index.php/inventory/index?msg=Em0'));
			}

		 
	}
	
	public function doDelete($id){
 
			$result = $this->Inventory_model->deleteInv($id);
			if($result == true){
				redirect(site_url('inventory/index?msg=Dm1'));
			}else{
				redirect(site_url('inventory/index?msg=Dm0'));			
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
