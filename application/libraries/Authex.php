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
          $query = $CI->db->get_where("user", array("id_user" => $CI->session->userdata("id_user")));
          return $query->row();
     }
 }

 function logged_in()
 {
     $CI =& get_instance();
	 // var_dump(($CI->session->userdata('id_user')) ? true : false);die;
	 
     return ($CI->session->userdata('id_user')) ? true : false;
 }

 function login($username, $password)
 {
     $CI =& get_instance();

     $data = array(
         "nama_user" => $username,
         "password" => md5($password)
     );
	
     $query = $CI->db->get_where("user", $data);
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
         $CI->session->set_userdata("id_user", $query->row()->id_user);
         $CI->session->set_userdata("nama_user", $query->row()->nama_user);
         $CI->session->set_userdata("fullname", $query->row()->nama_user);		 
         $CI->session->set_userdata("photo", $query->row()->photo);
         $CI->session->set_userdata("level", $query->row()->level);
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

         $CI->db->insert("user", $data);

         return true;
     }

     return false;
 }

 function can_register($username)
 {
     $CI =& get_instance();

     $query = $CI->db->get_where("user", array("username" => $username));

     return ($query->num_rows() < 1) ? true : false;
 }
}