<?php

if(!defined('BASEPATH')) exit('No direct script access allowed');

class Dasboard_model extends CI_Model
{
	
    public function getTop5(){
		$query = $this->db->query("
		SELECT
			a.`product_name`,
			(SELECT COUNT(aa.`ordprod_product_id`) FROM ord_order_products aa WHERE aa.`ordprod_product_id` = a.`product_id`) AS jumlah
		FROM prod_products a
		ORDER BY jumlah DESC
		LIMIT 0, 5
		");
		$result = $query->result();
		return $result;
	}
	
	public function getSellingStatistic(){
		$query = $this->db->query("
		SELECT
			a.`product_id`,
			a.`product_name`,
			(SELECT COUNT(aa.`ordprod_product_id`) FROM ord_order_products aa WHERE aa.`ordprod_product_id` = a.`product_id`) AS jumlah
		FROM prod_products a
		ORDER BY jumlah DESC
		");
		$result = $query->result();
		return $result;
	}
	
}