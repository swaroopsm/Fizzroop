<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Page_Attendee extends CI_Controller{
		
		/**
			* Constructor function
		**/
		
		public function __construct(){
			parent::__construct();
			$this->load->library("session");
			$this->load->model("page_attendees");
			$this->load->library("uri");
		}
		
	}

?>
