<?php

if(!defined('BASEPATH')) exit('No direct script access allowed');

class Dasboard_model extends CI_Model
{
	
    public function getTop5(){
		$query = $this->db->query("
		SELECT
			a.`id_prod` as product_id,
			a.`nama_prod` as product_name,
			(SELECT COUNT(id_prod) FROM detail_penjualan WHERE id_prod = a.`id_prod`) AS jumlah
		FROM produk a
		ORDER BY jumlah DESC
		LIMIT 0, 5
		");
		$result = $query->result();
		return $result;
	}
	
	public function getSellingStatistic(){
		$query = $this->db->query("
		SELECT
			a.`id_prod` as product_id,
			a.`nama_prod` as product_name,
			(SELECT COUNT(id_prod) FROM detail_penjualan WHERE id_prod = a.`id_prod`) AS jumlah
		FROM produk a
		ORDER BY jumlah DESC
		");
		$result = $query->result();
		return $result;
	}
	
	public function getProduct(){
		$old = $this->load->database('old', true);	
		$query = $old->query("
			SELECT
				b.`id` AS id_prod,
				b.`productname` AS nama_prod,
				IF(LOWER(d.`catname`) = 'gamis', 1, 2) AS jenis_prod,
				b.`productsellprice` AS harga,
				'50' AS stok
			FROM prod_products b
			LEFT JOIN prod_ref_category c ON c.`id` = b.`catid`
			LEFT JOIN prod_ref_category d ON d.`id` = c.`parentcat`
			WHERE
			1=1
			AND c.`parentcat` IN(10, 520, 564)
		");
		$result = $query->result();
		return $result;
	}
	
	public function getPenjualanDetail(){
		$old = $this->load->database('old', true);	
		$query = $old->query('
			SELECT
				a.`productid` AS id_prod,
				a.`orderid` AS id_penj,
				a.`ordersum` AS jml_jual,
				(a.`ordersum` * b.`productsellprice`) AS total
			FROM ord_products a
			LEFT JOIN prod_products b ON b.`id` = a.`productid`
			LEFT JOIN prod_ref_category c ON c.`id` = b.`catid`
			LEFT JOIN prod_ref_category d ON d.`id` = c.`parentcat`
			WHERE
			1=1
			AND c.`parentcat` IN(10, 520, 564)
		');
		$result = $query->result();
		return $result;
	}
	
	public function getPenjualan($id){
		$old = $this->load->database('old', true);	
		$query = $old->query("
			SELECT
				a.`id` AS id_penj,
				'1' AS id_user,
				a.`customerid` AS id_cust,
				a.`orderdate` AS tgl_trans,
				a.`ordershippingcost` AS biaya_kirim,
				a.`ordertotaldiscpercent` AS diskon,
				(SELECT SUM(ordertotal) FROM ord_products WHERE orderid = a.`id`) AS ttl_byr
			FROM ord_orders a
			WHERE a.`id` IN($id);
		");
		
		$result = $query->result();
		return $result;
	}
	
	public function getCust(){
		$old = $this->load->database('old', true);	
		$query = $old->query("
			SELECT
				a.`id` AS id_cust,
				a.`customername` AS nama_cust,
				a.`customeraddress` AS alamat_cust,
				a.`customerphone1` AS nohp_cust
			FROM core_customers a
		");
		
		$result = $query->result();
		return $result;
	}
	
	public function getProductDetail($id){
		$query = $this->db->query("
			SELECT
				a.`id_prod` as product_id,
				a.`nama_prod` as product_name,
				(SELECT COUNT(id_prod) FROM detail_penjualan WHERE id_prod = a.`id_prod`) AS jumlah
			FROM produk a
			WHERE 
				a.`id_prod` IN ($id)
			ORDER BY jumlah DESC
			LIMIT 0, 5
		");
		return $query->result();
	}
	
	
	
}