<?php

if(!defined('BASEPATH')) exit('No direct script access allowed');

class Report_model extends CI_Model
{
	
    public function getTransactionByDate($filter){		
		$sql = '
			SELECT
				a.`id_penj`,
				a.`id_cust`,
				a.`kode_invoice`,
				c.`nama_cust`,
				c.`alamat_cust`,
				c.`nohp_cust`,
				a.`tgl_trans`,
				(SELECT SUM(total) FROM detail_penjualan WHERE id_penj = a.`id_penj`) AS `total_amount`,
				a.`biaya_kirim`,	
				a.`diskon`,
				a.`ttl_byr`,
				a.`id_user`,
				b.`nama_user`,
				(((SELECT SUM(total) FROM detail_penjualan WHERE id_penj = a.`id_penj`) + a.`biaya_kirim`) - a.`diskon` ) AS `total`
			FROM penjualan a
			LEFT JOIN `user` b ON b.`id_user` = a.`id_user`
			LEFT JOIN customer c ON c.`id_cust` = a.`id_cust`
			WHERE 
				1=1
				---search---
			ORDER BY a.`id_penj` DESC
		';
		
		$str='';
		if(!empty($filter['date']) && $filter['date'] != 'all'){
			$str .= " AND a.`tgl_trans` LIKE '%". $filter['date'] ."%'";
		}
		if(!empty($filter['user']) && $filter['user'] !== 'all'){
			$str .= " AND b.`id_user` =". $filter['user'];
		}
		
		$sql = str_replace('---search---', $str, $sql);
		$query = $this->db->query($sql);	
		
		$result = $query->result();
		return $result;
	}
	
	public function getUser(){
		$query = $this->db->get('user');
		return $query->result();
	}

}