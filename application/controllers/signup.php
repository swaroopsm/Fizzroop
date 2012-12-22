<?php

	class Signup extends CI_Controller{
	
		public function index(){
			$data['page_title'] = "Register your account";
			$this->load->view("signup", $data);
		}
	
	}

?>
