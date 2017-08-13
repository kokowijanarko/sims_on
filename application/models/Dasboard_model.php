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
	
}