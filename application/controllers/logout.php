<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Logout extends CI_Controller{
	
		public function index(){
			$this->load->library("session");
			$l = $this->session->userdata("loggedin");
			$al = $this->session->userdata("adminLoggedin");
			$rl = $this->session->userdata("reviewerLoggedin");
			if($l == true)
				$logout = "login";
			if($al == true)
				$logout = "signin";
			if($rl == true)
				$logout = "reviewersignin";
			$this->session->unset_userdata(array(
				"loggedin" => false,
				"adminLoggedin" => false,
				"reviewerLoggedin" => false,
				"email" => "",
				"id" => "",
				"conferenceID" => ""
			));
			redirect(base_url().$logout);
		}
	
	}

?>
