<?php

if(!defined('BASEPATH')) exit('No direct script access allowed');

class Cashier_model extends CI_Model
{
	
    // public function __construct()
    // {
        // parent::__construct();
        // $this->load->database();
        // $this->load->library('session');
    // }
	public function updateStock($stock, $id){
		$param = array(
			'inv_stock'=>$stock
		);
		$query = $this->db->update('inv_inventory', $param, array('inv_id'=>$id));	
		return $query;
	}
	public function getInventory(){		
		$query = $this->db->query('
			SELECT
				a.inv_id,
				a.inv_name,
				a.inv_category_id,
				a.inv_type_id,
				a.inv_desc,
				a.inv_price,
				a.inv_stock,
				b.type_name,
				c.category_name
			FROM inv_inventory a 
			LEFT JOIN inv_ref_inventory_category c ON c.category_id = a.inv_category_id 
			LEFT JOIN inv_ref_inventory_type b ON b.type_id = a.inv_type_id
			ORDER BY inv_name
			
		');
		$result = $query->result();
		return $result;
	}
	
	public function getInvDetailById($id){		
		$query = $this->db->query('
			SELECT
				a.inv_id,
				a.inv_name,
				a.inv_category_id,
				a.inv_type_id,
				a.inv_desc,
				a.inv_price,
				a.inv_stock,
				b.type_name,
				c.category_name
			FROM inv_inventory a 
			LEFT JOIN inv_ref_inventory_category c ON c.category_id = a.inv_category_id 
			LEFT JOIN inv_ref_inventory_type b ON b.type_id = a.inv_type_id
			WHERE a.inv_id = "'.$id.'"
			
		');
		$result = $query->row();
		return $result;
	}
	
	public function getLastOrderCode($date){
		$query = $this->db->query('SELECT order_code AS order_code FROM cash_order WHERE insert_timestamp LIKE "%'. $date .'%" ORDER BY order_id DESC LIMIT 1');
		$order_code = $query->row();
		if($order_code){
			return $order_code->order_code;
		}else{
			return $order_code;
		}
		
	}
	
	public function getInventoryType(){
		$query = $this->db->get('inv_ref_inventory_type');
		$result = $query->result();
		return $result;
	}
	public function getInventoryCategory(){
		$query = $this->db->get('inv_ref_inventory_category');
		$result = $query->result();
		return $result;
	}
	
	public function insertInventory($param){
		$query = $this->db->insert('inv_inventory', $param);
		
		return $query;
		
	}
	public function UpdateInventory($param_inv, $id){
		//$query = $this->db->where('inv_id', $id);
		$query = $this->db->update('inv_inventory', $param_inv, array('inv_id'=>$id));		
		return $query;
		
	}
	
	public function insertOrder($param){
		$query = $this->db->insert('cash_order', $param);
		return $query;
	}
	
	public function insertOrderDetail($param){
		$query = $this->db->insert_batch('cash_order_detail', $param);		
		return $query;
	}
	
	public function getInvDetailByInvNumber($inv_number){
		$query = $this->db->query("
			SELECT * FROM cash_order WHERE order_id='$inv_number'
		");
		return $query->row();
	}
	public function getOrderByCode($inv_number){
		$query = $this->db->query("
			SELECT * FROM cash_order WHERE order_code='$inv_number'
		");
		return $query->row();
	}
	public function getInvDetail($id){
		$query = $this->db->query("
			SELECT 
				a.`orderdetail_id`,
				b.`inv_name`,
				b.`inv_id`,
				b.`inv_price`,
				c.`type_name`,
				d.`category_name`
				
			FROM cash_order_detail a 
			JOIN inv_inventory b ON a.`orderdetail_product_id` = b.`inv_id`
			JOIN inv_ref_inventory_type c ON c.`type_id` = b.`inv_type_id`
			JOIN inv_ref_inventory_category d ON d.`category_id` = b.`inv_category_id`
			WHERE a.`orderdetail_order_id` = '$id'
		");
		return $query->result();
	}
	
	public function getTypeByCat($id){
		$query = $this->db->query('SELECT * FROM inv_ref_inventory_type WHERE type_category_id='.$id);
		$result = $query->result();
		return $result;
	}
	
	public function getInvoice(){
		$query = $this->db->query("
		SELECT
			IFNULL(DATE_FORMAT(a.`insert_timestamp`, '%d-%m-%Y'), '-') AS insert_date,
			a.`insert_user_id`,
			IFNULL(b.`user_full_name`, '-') AS insert_user,
			IFNULL(b.`user_full_name`,  '-') AS insert_username,
			a.`order_address`,
			a.`order_amount`,
			a.`order_cash_minus`,
			a.`order_code`,
			a.`order_contact`,
			a.`order_custommer_name`,
			a.`order_date_design`,
			a.`order_date_order`,
			a.`order_date_take`,
			a.`order_down_payment`,
			a.`order_email`,
			a.`order_id`,
			a.`order_payment_way`,
			a.`order_retur`,
			a.`order_status`,
			a.`order_type`,
			IFNULL(DATE_FORMAT(a.`update_timestamp`, '%d-%m-%Y'), '-') AS update_date,
			a.`update_user_id`,
			IFNULL(c.`user_full_name`,  '-') AS `update_user`,
			IFNULL(c.`user_full_name`,  '-') AS `update_username`
		FROM cash_order a
		LEFT JOIN `user` b ON b.`user_id` = a.`insert_user_id`
		LEFT JOIN `user` c ON c.`user_id` = a.`update_user_id`
		");
		$result = $query->result();
		return $result;
	}
	
	public function getDetailInvoiceByInvoiceCode($code){
		$query1 = $this->db->query('SELECT * FROM cash_order WHERE order_code="'.$code.'"');
		$result1 = $query1->row();
		$query2 = $this->db->query('
					SELECT
						a.`orderdetail_id`,
						a.`orderdetail_order_id`,
						a.`orderdetail_product_id`,
						b.`inv_name`,
						c.`category_id`,
						c.`category_name`,
						d.`type_id`,
						d.`type_name`,
						b.`inv_price`,
						a.`orderdetail_quantity`

					FROM cash_order_detail a
					LEFT JOIN inv_inventory b ON b.`inv_id` = a.`orderdetail_product_id`
					LEFT JOIN inv_ref_inventory_category c ON c.`category_id` = b.`inv_category_id`
					LEFT JOIN inv_ref_inventory_type d ON d.`type_id` = b.`inv_type_id`
					
					WHERE a.`orderdetail_order_id`="'.$result1->order_id.'"		
					');		
		$result2 = $query2->result();
		
		$result = new stdClass();
		$result->order = $result1;
		$result->detail = $result2;
		return $result;
	}
	public function getOrderById($id){
		$query = $this->db->query('SELECT * FROM cash_order WHERE order_id="'.$id.'"');
		
		$result = $query->row();
		return $result;
	}
	
	public function doUpdateOrder($param, $id){
		$query = $this->db->update('cash_order', $param, array('order_code'=>$id));	
		return $query;
	}
	public function doUpdateOrderStat($param, $id){
		$query = $this->db->update('cash_order', $param, array('order_id'=>$id));	
		return $query;
	}

}