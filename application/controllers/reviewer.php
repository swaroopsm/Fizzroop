<?php

	class Reviewer extends CI_Controller{
	
		/**
			* Constructor function
		**/
		
		public function __construct(){
			parent::__construct();
			$this->load->library("session");
			$this->load->library("encrypt");
			$this->load->model("reviewers");
			$this->load->library("uri");
		}
		
	}

?>
