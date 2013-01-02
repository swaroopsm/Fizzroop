<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Session extends CI_Controller{
		
		public function __construct(){
			parent::__construct();
			$this->load->library("session");
		}
		
		public function index(){
			echo json_encode($this->session->userdata);
		}
		
	}

?>
