<?php

if(!defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model
{
	public function getUser(){
		$query = $this->db->query("
			SELECT
			a.`id_user`,
			a.`nama_user`,			 
			a.`level`,
			IF(a.`level` = 1, 'root', (IF(a.`level` = 2, 'admin', 'owner' )) ) as `level_name`,
			a.`photo`
		FROM `user` a	 
		");
		$result = $query->result();
		return $result;
	}
	
	public function getDetailUser($id){
		$query = $this->db->query("
			SELECT
			a.`id_user`,
			a.`nama_user`,			 
			a.`password`,
			a.`level`,
			IF(a.`level` = 1, 'root', (IF(a.`level` = 2, 'admin', 'owner' )) ) as `level_name`,			
			a.`photo`
		FROM `user` a
		WHERE a.`id_user`= $id
		");
		$result = $query->row();
		return $result;
	}
	
	public function getUserLevel(){
		$query = $this->db->get('dev_level');
		return $query->result();
	}
	public function insertUser($param){
		$query = $this->db->insert('user', $param);
		return $query;		
	}
	public function updateUser($param, $id_user){
		$query = $this->db->update('user', $param, array('id_user'=>$id_user));		
		return $query;
		
	}
    public function deleteInv($id){
		$query = $this->db->delete('user', array('id_user' => $id));
		return $query;
	}

}