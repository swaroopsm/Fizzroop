<?php

	class Admin extends CI_Controller{
	
		public function index(){
			$data['page_title'] = "Welcome Admin!";
			$this->load->view("adminDashboard", $data);
		}
	
	}

?>
