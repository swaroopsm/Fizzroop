<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Image extends CI_Controller{
		
		/**
			*	Constructor function.
		*/
		
		public function __construct(){
			parent::__construct();
			$this->load->library("session");
			$this->load->model("images");
		}
		
		
	}

?>
