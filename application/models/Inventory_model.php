<?php

if(!defined('BASEPATH')) exit('No direct script access allowed');

class Inventory_model extends CI_Model
{
	
    // public function __construct()
    // {
        // parent::__construct();
        // $this->load->database();
        // $this->load->library('session');
    // }
	
	public function getProduct($filter=array()){		
		$str = '';
		
		if(!empty($filter)){
			extract($filter);
			
			if(!empty($product || $product !== '')){
				$str .= "AND a.nama_prod LIKE '%$product%' ";
			}
			
			if(!empty($category || $category !== '')){
				$str .= "AND a.`jenis_prod` = $category ";
			}		
			
		}
		
		$query_str = "
			SELECT
				a.`id_prod`,
				a.`nama_prod`,
				IF(a.`jenis_prod` = 1, 'gamis', 'jilbab') as jenis_prod,
				a.jenis_prod as `id_jenis`,
				a.`harga`,
				a.`stok`
			FROM produk a
			WHERE
				1=1
				--search--
		";
		
		$query_str = str_replace('--search--', $str, $query_str);
		// var_dump($query_str);
		$query = $this->db->query($query_str);
		$result = $query->result();
		return $result;
	}
	
	public function getProductDetailById($id){		
		$query = $this->db->query("
			SELECT
				a.`id_prod`,
				a.`nama_prod`,
				a.`jenis_prod`,
				a.`harga`,
				a.`stok`
			FROM produk a
			WHERE a.id_prod = $id
			
		");
		$result = $query->row();
		return $result;
	}
	
	public function getProductCategory(){
		$query = $this->db->get('prod_category');
		$result = $query->result();
		return $result;
	}
	
	public function insertProduct($param){
		$query = $this->db->insert('produk', $param);
		
		return $query;
		
	}
	public function updateProduct($param_inv, $id){
		//$query = $this->db->where('inv_id', $id);
		$query = $this->db->update('produk', $param_inv, array('id_prod'=>$id));		
		return $query;
		
	}
	
	public function deleteInv($id){
		$query = $this->db->delete('produk', array('id_prod' => $id));
		return $query;
	}
	


}