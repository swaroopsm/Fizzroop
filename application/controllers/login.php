<?php

	class Login extends CI_Controller{
	
		public function index(){
			$data['page_title'] = "Login to your account";
			$this->load->view("login", $data);
		}
	
	}

?>
