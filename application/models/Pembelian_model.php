<?php

if(!defined('BASEPATH')) exit('No direct script access allowed');

class Pembelian_model extends CI_Model
{
	public function getPembelian(){
		$query = $this->db->query("
			SELECT
				a.`id_beli`,
				a.`tgl_beli`,
				b.`id_sup`,
				b.`nama_sup`,
				a.`id_user`
			FROM pembelian a
			LEFT JOIN supplier b ON b.`id_sup`=a.`id_sup`
			LEFT JOIN `user` c ON c.`id_user` = a.`id_user`
		");
		$result = $query->result();
		return $result;
	}
	
	public function getDetailPembelian($id){
		$query = $this->db->query("
			SELECT
				a.`id_beli`,
				c.`id_sup`,
				d.`nama_sup`,
				a.`id_prod`,
				b.`nama_prod`,
				a.`harga_jual`,
				a.`harga_beli`,
				a.`jml_brg`
			FROM detail_pembelian a
			LEFT JOIN produk b ON b.`id_prod`=a.`id_prod`
			LEFT JOIN pembelian c ON c.`id_beli`=a.`id_beli`
			LEFT JOIN supplier d ON d.`id_sup`=c.`id_sup`
			WHERE a.`id_beli` = $id
		");
		$result = $query->result();
		return $result;
	}
	
	public function insertPembelian($param){
		$query = $this->db->insert('pembelian', $param);
		return $query;		
	}
	public function insertDetailPembelian($param){
		$query = $this->db->insert('detail_pembelian', $param);
		return $query;		
	}
	public function updatePembelian($param, $id_cust){
		$query = $this->db->update('pembelian', $param, array('id_cust'=>$id_cust));		
		return $query;
		
	}
    public function deletePembelian($id){
		$query = $this->db->delete('pembelian', array('id_cust' => $id));
		return $query;
	}

}