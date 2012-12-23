<?php

	class Logout extends CI_Controller{
	
		public function index(){
			$this->load->library("session");
			$this->session->unset_userdata(array(
				"loggedin" => false,
				"email" => ""
			));
			redirect(base_url()."index.php/login");
		}
	
	}

?>
