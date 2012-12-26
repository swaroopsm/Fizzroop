<?php

	class Comment extends CI_Controller{
	
		/**
			* Constructor function
		**/
		
		public function __construct(){
			parent::__construct();
			$this->load->library("session");
			$this->load->model("comments");
			$this->load->library("uri");
		}
	
	}

?>
