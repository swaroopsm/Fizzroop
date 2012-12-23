<?php

	class Login extends CI_Controller{
	
		public function index(){
			$this->load->library("session");
			$data['page_title'] = "Login to your account";
			$data['message'] = $this->session->flashdata('message');
			$this->load->view("login", $data);
		}
	
	}

?>
