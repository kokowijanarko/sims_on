<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Authex{

 function Authex()
 {
     $CI =& get_instance();

     //load libraries
     $CI->load->database();
     $CI->load->library("session");
 }

 function get_userdata()
 {
     $CI =& get_instance();

     if( ! $this->logged_in())
     {
         return false;
     }
     else
     {
          $query = $CI->db->get_where("dev_custommer", array("custommer_id" => $CI->session->userdata("user_id")));
          return $query->row();
     }
 }

 function logged_in()
 {
     $CI =& get_instance();
     return ($CI->session->userdata('user_id')) ? true : false;
 }

 function login($username, $password)
 {
     $CI =& get_instance();

     $data = array(
         "user_username" => $username,
         "user_password" => md5($password)
     );
	
     $query = $CI->db->get_where("dev_user", $data);
	//var_dump( $data);
     if($query->num_rows() !== 1)
     {
         /* their username and password combination
         * were not found in the databse */

         return false;
     }
     else
     {
         //update the last login time
         $last_login = date("Y-m-d H:i:s");

         $data = array(
             "user_last_login" => $last_login
         );

         // $CI->db->query("UPDATE user SET user_last_login='".$last_login."' WHERE 
			// user_username = '".$username."' AND user_password = '".md5($password)."'
		 // ");
         $CI->session->set_userdata("user_id", $query->row()->user_id);
         $CI->session->set_userdata("username", $query->row()->user_username);
         $CI->session->set_userdata("fullname", $query->row()->user_full_name);		 
         $CI->session->set_userdata("photo", $query->row()->user_photo_name);
		 
		 $query_level = $CI->db->get_where("dev_level", array('level_id'=>$query->row()->user_level_id));
         $CI->session->set_userdata("level", $query->row()->user_level_id);
         $CI->session->set_userdata("level_name", $query_level->row()->level_name);
         return true;
     }
 }

 function logout()
 {
     $CI =& get_instance();
     $CI->session->unset_userdata();
 }

 function register($username, $password)
 {
     $CI =& get_instance();

     //ensure the username is unique
     if($this->can_register($username))
     {
         $data = array(
             "username" => $username,
             "password" => sha1($password)
         );

         $CI->db->insert("dev_custommer", $data);

         return true;
     }

     return false;
 }

 function can_register($username)
 {
     $CI =& get_instance();

     $query = $CI->db->get_where("dev_custommer", array("username" => $username));

     return ($query->num_rows() < 1) ? true : false;
 }
}