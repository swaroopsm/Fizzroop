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
		
		
		/**
			* Handles creation of a Reviewer.
		**/
		
		public function create(){
			if($_SERVER['REQUEST_METHOD'] == "POST"){
				if($this->session->userdata("adminLoggedin") == true){
					$data = array(
						"reviewerFirstName" => $this->input->post("inputFirstName"),
						"reviewerLastName" => $this->input->post("inputLastName"),
						"reviewerEmail" => $this->input->post("inputEmail"),
						"reviewerPassword" => $this->encrypt->sha1($this->input->post("inputPassword").$this->encrypt->sha1($this->config->item("password_salt")))
					);
					$this->reviewers->insert($data);
					echo json_encode(
						array(
							"success" => true,
							"reviewerID" => $this->db->insert_id()
						)
					);
				}
				else{
					show_404();
				}
			}
			else{
				show_404();
			}
		}
		
	}

?>
