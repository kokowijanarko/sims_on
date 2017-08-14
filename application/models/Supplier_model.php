<?php

if(!defined('BASEPATH')) exit('No direct script access allowed');

class Supplier_model extends CI_Model
{
	public function getSupplier(){
		$query = $this->db->query("
			SELECT * FROM supplier ORDER BY nama_sup ASC 
		");
		$result = $query->result();
		return $result;
	}
	
	public function getDetailSupplier($id){
		$query = $this->db->query("
			SELECT * FROM supplier WHERE id_sup= $id
		");
		$result = $query->row();
		return $result;
	}
	
	public function insertSupplier($param){
		$query = $this->db->insert('supplier', $param);
		return $query;		
	}
	public function updateSupplier($param, $id_sup){
		$query = $this->db->update('supplier', $param, array('id_sup'=>$id_sup));		
		return $query;
		
	}
    public function deleteSupplier($id){
		$query = $this->db->delete('supplier', array('id_sup' => $id));
		return $query;
	}

}