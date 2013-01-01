<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Logout extends CI_Controller{
	
		public function index(){
			$this->load->library("session");
			$l = $this->session->userdata("loggedin");
			$al = $this->session->userdata("adminLoggedin");
			if($l == true)
				$logout = "login";
			else
				$logout = "signin";
			$this->session->unset_userdata(array(
				"loggedin" => false,
				"adminLoggedin" => false,
				"email" => "",
				"id" => "",
				"conferenceID" => ""
			));
			redirect(base_url().$logout);
		}
	
	}

?>
