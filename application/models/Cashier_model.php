<?php

if(!defined('BASEPATH')) exit('No direct script access allowed');

class Cashier_model extends CI_Model
{
	
	public function getCustomer(){
		$query = $this->db->query("
			SELECT * FROM customer ORDER BY nama_cust		
		");
		$result = $query->result();
		return $result;
	}
	
	public function updateStock($stock, $id){
		$param = array(
			'stok'=>$stock
		);
		$query = $this->db->update('produk', $param, array('id_prod'=>$id));	
		return $query;
	}
	public function getInventory(){		
		$query = $this->db->query("
			SELECT
				a.`id_prod`,
				a.`nama_prod`,
				IF(a.`jenis_prod` = 1, 'gamis', 'jilbab') as jenis_prod,
				a.jenis_prod as `id_jenis`,
				a.`harga`,
				a.`stok`
			FROM produk a
			ORDER BY a.nama_prod
			
		");
		$result = $query->result();
		return $result;
	}
	
	public function getInvDetailById($id){		
		$query = $this->db->query("
			SELECT
				a.`id_prod`,
				a.`nama_prod`,
				IF(a.`jenis_prod` = 1, 'gamis', 'jilbab') as jenis_prod,
				a.jenis_prod as `id_jenis`,
				a.`harga`,
				a.`stok`
			FROM produk a
			WHERE a.id_prod = $id
			
		");
		$result = $query->row();
		return $result;
	}
	
	public function getLastOrderCode($date){
		$query = $this->db->query('SELECT kode_invoice AS order_code FROM penjualan WHERE tgl_trans LIKE "%'. $date .'%" ORDER BY id_penj DESC LIMIT 1');
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
		// var_dump($param);
		$query = $this->db->insert('penjualan', $param);
		// var_dump($this->db->last_query());die;
		return $query;
	}
	
	public function insertOrderDetail($param){
		$query = $this->db->insert_batch('detail_penjualan', $param);		
		return $query;
	}
	
	public function getInvDetailByInvNumber($inv_number){
		$query = $this->db->query("
			SELECT * FROM penjualan WHERE order_id='$inv_number'
		");
		return $query->row();
	}
	public function getOrderByCode($inv_number){
		$query = $this->db->query("
			SELECT * FROM penjualan WHERE order_code='$inv_number'
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
				
			FROM penjualan_detail a 
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
		FROM penjualan a
		LEFT JOIN `user` b ON b.`user_id` = a.`insert_user_id`
		LEFT JOIN `user` c ON c.`user_id` = a.`update_user_id`
		");
		$result = $query->result();
		return $result;
	}
	
	public function getDetailInvoiceByInvoiceCode($code){
		$query1 = $this->db->query('
			SELECT 
				a.`id_penj`,
				a.`kode_invoice`,
				a.`id_user`,
				a.`id_cust`,
				b.`nama_cust`,
				b.`alamat_cust`,
				b.`nohp_cust`,
				a.`tgl_trans`,
				a.`biaya_kirim`,
				a.`diskon`,
				a.`ttl_byr`
			FROM penjualan a
			LEFT JOIN customer b ON b.`id_cust` = a.`id_cust`
			WHERE kode_invoice="'.$code.'"
		');
		$result1 = $query1->row();
		$query2 = $this->db->query('
			SELECT
				a.`id_penj`,
				a.`id_prod`,
				a.`jml_jual`,
				a.`total`,
				b.`jenis_prod`,
				b.`nama_prod`,
				b.`harga`

			FROM detail_penjualan a
			LEFT JOIN produk b ON b.`id_prod`= a.`id_prod`
					
			WHERE a.`id_penj`="'.$result1->id_penj.'"		
		');		
		$result2 = $query2->result();
		
		$result = new stdClass();
		$result->penjualan = $result1;
		$result->detail = $result2;
		return $result;
	}
	public function getOrderById($id){
		$query = $this->db->query('SELECT * FROM penjualan WHERE order_id="'.$id.'"');
		
		$result = $query->row();
		return $result;
	}
	
	public function doUpdateOrder($param, $id){
		$query = $this->db->update('penjualan', $param, array('order_code'=>$id));	
		return $query;
	}
	public function doUpdateOrderStat($param, $id){
		$query = $this->db->update('penjualan', $param, array('order_id'=>$id));	
		return $query;
	}

}