<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	/**
		* Controller pertaining for Admins and Reviewers!!
	**/
	
	class Reviewersignin extends CI_Controller{
	
		public function index(){
			$this->load->library("session");
			$data['page_title'] = "Login to your account";
			$data['message'] = $this->session->flashdata('message');
			$this->load->view("reviewersignin", $data);
		}
	
	}

?>