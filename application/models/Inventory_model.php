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
				$str .= "AND a.product_name LIKE '%$product%' ";
			}
			
			if(!empty($category || $category !== '')){
				$str .= "AND a.`product_category_id` = $category ";
			}		
			
		}
		
		
		
		
		
		$query_str = "
			SELECT
				a.`product_id`,
				a.`product_name`,
				a.`product_category_id`,
				b.`category_name`,
				a.`product_price_base`,
				a.`product_price`,
				a.`product_stock`,
				a.`product_desc`,
				IFNULL(c.`user_name`, '~') AS insert_user,
				IF(a.`insert_timestamp` = '0000-00-00 00:00:00', '~', a.`insert_timestamp`) AS insert_timestamp,
				IFNULL(d.`user_name`, '~') AS update_user,
				IF(a.`update_timestamp` = '0000-00-00 00:00:00', '~', a.`update_timestamp`) AS update_timestamp
			FROM prod_products a
			LEFT JOIN prod_category b ON b.`category_id` = a.`product_category_id`
			LEFT JOIN dev_user c ON c.`user_id` = a.`insert_user_id`
			LEFT JOIN dev_user d ON d.`user_id` = a.`update_user_id`	
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
				a.`product_id`,
				a.`product_name`,
				a.`product_category_id`,
				b.`category_name`,
				a.`product_price_base`,
				a.`product_price`,
				a.`product_stock`,
				a.`product_desc`,
				IFNULL(c.`user_name`, '~') AS insert_user,
				IF(a.`insert_timestamp` = '0000-00-00 00:00:00', '~', a.`insert_timestamp`) AS insert_timestamp,
				IFNULL(d.`user_name`, '~') AS update_user,
				IF(a.`update_timestamp` = '0000-00-00 00:00:00', '~', a.`update_timestamp`) AS update_timestamp
			FROM prod_products a
			LEFT JOIN prod_category b ON b.`category_id` = a.`product_category_id`
			LEFT JOIN dev_user c ON c.`user_id` = a.`insert_user_id`
			LEFT JOIN dev_user d ON d.`user_id` = a.`update_user_id`
			WHERE a.product_id = $id
			
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
		$query = $this->db->insert('prod_products', $param);
		
		return $query;
		
	}
	public function updateProduct($param_inv, $id){
		//$query = $this->db->where('inv_id', $id);
		$query = $this->db->update('prod_products', $param_inv, array('product_id'=>$id));		
		return $query;
		
	}
	
	public function deleteInv($id){
		$query = $this->db->delete('prod_products', array('product_id' => $id));
		return $query;
	}
	


}