<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Signup extends CI_Controller{
	
		public function index(){
			$data['page_title'] = "Register your account";
			$this->load->view("signup", $data);
		}
	
	}

?>
