<?php

if(!defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model
{
	public function getUser(){
		$query = $this->db->query("
			SELECT
			a.`user_id`,
			a.`user_name`,
			a.`user_username`,
			a.`user_level_id`,
			b.`level_name`,
			a.`user_photo_name`

		FROM `dev_user` a
		JOIN dev_level b ON a.`user_level_id` = b.`level_id`
		");
		$result = $query->result();
		return $result;
	}
	
	public function getDetailUser($id){
		$query = $this->db->query("
			SELECT
			a.`user_id`,
			a.`user_name`,
			a.`user_username`,
			a.`user_password`,
			a.`user_level_id`,
			a.`user_desc`,
			b.`level_name`,			
			a.`user_photo_name`
		FROM `dev_user` a
		LEFT JOIN dev_level b ON a.`user_level_id` = b.`level_id`
		WHERE a.`user_id`= $id
		");
		$result = $query->row();
		return $result;
	}
	
	public function getUserLevel(){
		$query = $this->db->get('dev_level');
		return $query->result();
	}
	public function insertUser($param){
		$query = $this->db->insert('dev_user', $param);
		return $query;		
	}
	public function updateUser($param, $user_id){
		$query = $this->db->update('dev_user', $param, array('user_id'=>$user_id));		
		return $query;
		
	}
    public function deleteInv($id){
		$query = $this->db->delete('dev_user', array('user_id' => $id));
		return $query;
	}

}