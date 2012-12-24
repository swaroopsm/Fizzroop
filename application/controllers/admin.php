<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Admin extends CI_Controller{
		
		public function __construct(){
			parent::__construct();
			$this->load->library("session");
			$this->load->library("encrypt");
			$this->load->model("admins");
		}
		
		public function index(){
			$data['page_title'] = "Welcome Admin!";
			$this->load->view("adminDashboard", $data);
		}
	
	}

?>
