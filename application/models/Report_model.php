<?php

if(!defined('BASEPATH')) exit('No direct script access allowed');

class Report_model extends CI_Model
{
	
    public function getTransactionByDate($filter){		
		$sql = '
			SELECT 
				a.`order_id`,
				a.`order_code`,
				a.`order_cash_minus`,
				a.`order_amount`,
				a.`order_custommer_name`,
				a.`order_date_order`,
				a.`order_date_take`,
				a.`order_address`,
				a.`order_contact`,
				a.`insert_user_id`,
				a.`insert_timestamp`,	
				a.`order_type`,
				IF(a.`order_payment_way`=0, "Cash", 
					(IF(a.`order_payment_way`=1, "Transfer", 
						(IF(a.`order_payment_way`=2, "Debit", "-"))))) AS `payment_way`,
				b.`user_id`,
				b.`user_full_name`,
				b.`user_level_id`,
				c.`level_name`
			FROM `cash_order` a
			JOIN `user` b ON b.`user_id` = a.`insert_user_id`
			JOIN `user_ref_level` c ON c.`level_id` = b.`user_level_id`
			WHERE 
				1=1
				---search---
		';
		
		$str='';
		if(!empty($filter['date']) && $filter['date'] != 'all'){
			$str .= " AND a.`order_date_order` LIKE '%". $filter['date'] ."%'";
		}
		if(!empty($filter['user']) && $filter['user'] !== 'all'){
			$str .= " AND b.`user_id` =". $filter['user'];
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