<?php

if(!defined('BASEPATH')) exit('No direct script access allowed');

class Customer_model extends CI_Model
{
	public function getCustomer(){
		$query = $this->db->query("
			SELECT * FROM customer ORDER BY nama_cust ASC 
		");
		$result = $query->result();
		return $result;
	}
	
	public function getDetailCustomer($id){
		$query = $this->db->query("
			SELECT * FROM customer WHERE id_cust= $id
		");
		$result = $query->row();
		return $result;
	}
	
	public function insertCustomer($param){
		$query = $this->db->insert('customer', $param);
		return $query;		
	}
	public function updateCustomer($param, $id_cust){
		$query = $this->db->update('customer', $param, array('id_cust'=>$id_cust));		
		return $query;
		
	}
    public function deleteCustomer($id){
		$query = $this->db->delete('customer', array('id_cust' => $id));
		return $query;
	}

}