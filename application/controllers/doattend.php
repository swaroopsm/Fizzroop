<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Doattend extends CI_Controller{
		
		/**
	 	 * Constructor function
	 **/
	 
		public function __construct(){
			parent::__construct();
			$this->load->library("session");
			$this->load->library("encrypt");
			$this->load->model("doattends");
			$this->load->library("uri");
		}
		
	}

?>
