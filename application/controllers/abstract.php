<?php

	class Abstract extends CI_Controller{
	
		public function __construct(){
			parent::__construct();
			$this->load->library("session");
			$this->load->model("abstracts");
			$this->load->library("uri");
		}
	
	}

?>
