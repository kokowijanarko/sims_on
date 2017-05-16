<?php

if(!defined('BASEPATH')) exit('No direct script access allowed');

class MassPrice_model extends CI_Model
{
	
    // public function __construct()
    // {
        // parent::__construct();
        // $this->load->database();
        // $this->load->library('session');
    // }
	
	public function getMassPrice($id){		
		$query = $this->db->query("
			SELECT 
				b.`inv_id`,
				b.`inv_name`,
				(SELECT MIN(massprice_range_start) 
				  FROM inv_mass_price
				  WHERE massprice_inv_id = a.`massprice_inv_id`)
				AS massprice_lowest_range_start,
				a.`massprice_range_start`,
				a.`massprice_range_end`,
				a.`massprice_price`,
				a.`massprice_id`				
			FROM inv_mass_price a
			LEFT JOIN inv_inventory b ON b.`inv_id` = a.`massprice_inv_id`
			WHERE a.`massprice_inv_id` = $id
			
		");
		$result = $query->result();
		return $result;
	}
	
	public function getMassPriceById($id){		
		$query = $this->db->query("
			select * from inv_mass_price where massprice_id = $id			
		");
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
	
	public function insertMassPrice($param){
		$query = $this->db->insert('inv_mass_price', $param);
		
		return $query;
		
	}
	public function updateMassPrice($param, $id){
		$query = $this->db->update('inv_mass_price', $param, array('massprice_id'=>$id));		
		return $query;
		
	}
	
	public function deleteMassPrice($id){
		$query = $this->db->delete('inv_mass_price', array('massprice_id'=>$id));
		return $query;
	}
	


}