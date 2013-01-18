<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Page  extends CI_Controller{
	
		/**
			*	Constructor function.
		*/
	
		public function __construct(){
			parent::__construct();
			$this->load->library("session");
			$this->load->model("pages");
			$this->load->library("uri");
		}
		
		
		/**
			*	Handles creation of a new Page.
		*/
		
		public function create(){
			if($this->session->userdata("adminLoggedin") == true && $_SERVER['REQUEST_METHOD'] == "GET"){
				#@TODO Think of a way to handle Page Images.
				$data = array(
					"pageTitle" => $this->input->post("inputPageTitle"),
					"pageContent" => $this->input->post("inputPageContent"),
					"pageType" => $this->input->post("inputPageType"),
					"conferenceID" => $this->session->userdata("conferenceID")
				);
				$this->pages->insert($data);
				echo json_encode(array("success" => true, "pageID" => $this->db->insert_id()));
			}
			else{
				show_404();
			}
		}
		
		
	}

?>
