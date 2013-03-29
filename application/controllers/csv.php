<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Csv extends CI_Controller{
		
		/**
			*	Constructor function.
		**/
		
		public function __construct(){
			parent::__construct();
			$this->load->library("session");
			$this->load->library("uri");
			$this->load->model("attendees");
		}
		
		
	}

?>
