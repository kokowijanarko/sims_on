<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
		$this->load->library('authex');
    }
	
	public function index(){
		if($this->session->userdata('level') == 1 || $this->session->userdata('level') == 2 || $this->session->userdata('level') == 3){
			redirect('dashboard1');
		}else{
			$this->load->view('login');
		}		
	}
        
	public function login(){
		$auth = $this->authex->login($_POST['key'], $_POST['password']);
		if($auth){
			redirect('dashboard1');			
		}else{
			redirect(site_url(''));
		}
	}
	
	public function logout(){
		session_destroy();
		redirect(site_url(''));
	}
}
