<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Admin extends CI_Controller{
	
		public function index(){
			$data['page_title'] = "Welcome Admin!";
			$this->load->view("adminDashboard", $data);
		}
	
	}

?>
