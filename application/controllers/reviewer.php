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
		
		
		/*
			*	Handles login of Reviewer.
		**/
		
		public function login(){
			if($_SERVER['REQUEST_METHOD'] == "POST"){
				$data = array(
					"reviewerEmail" => $this->input->post("inputLoginEmail"),
					"reviewerPassword" => $this->encrypt->sha1($this->input->post("inputLoginPwd").$this->encrypt->sha1($this->config->item("password_salt")))
				);
				
				if($this->reviewers->view_where($data)->num_rows() > 0){
					$this->session->set_userdata(array(
						"reviewerLoggedin" => true,
						"email" => $this->input->post("inputLoginEmail")
					));
					redirect(base_url()."reviewer");
				}
				else{
					 $this->session->set_flashdata("message", "<span class='span3 alert alert-danger'><center>Login failed!</center></span>");
           redirect(base_url()."signin");
				}
			}
			else{
				show_404();
			}
		}
		
		
		/**
			*	Handles edit/update of Reviewer.
		**/
	
		public function update(){
				if($_SERVER['REQUEST_METHOD'] == "POST"){
					if($this->session->userdata("reviewerLoggedin") == true || $this->session->userdata("adminLoggedin") == true){
						$data = array(
						"reviewerFirstName" => $this->input->post("inputFirstName"),
						"reviewerLastName" => $this->input->post("inputLastName"),
						"reviewerEmail" => $this->input->post("inputEmail")
					);
						$where = array(
							"reviewerID" => $this->input->post("inputReviewerID")
						);
						$this->reviewers->update($data, $where);
						echo json_encode(array(
								"success" => true,
								"reviewerID" => $this->input->post("inputReviewerID")
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
		
		
		/**
			*	Handles assignment of an Abstract.
		**/
		
		public function assign(){
			if($_SERVER['REQUEST_METHOD'] == "POST"){
				if($this->session->userdata("adminLoggedin") == true){
					$data = array(
						"abstractID" => $this->input->post("inputAbstractID"),
					);
						$where = array(
							"reviewerID" => $this->input->post("inputReviewerID")
						);
						$this->reviewers->update($data, $where);
						echo json_encode(array(
								"success" => true,
								"reviewerID" => $this->input->post("inputReviewerID")
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
		
		
		/**
			* Handles viewing of a particular Reviewer.
		**/
		
		public function view_where(){
			$data = array(
				"reviewerID" => $this->uri->segment(2)
			);
			$q = $this->reviewers->view_where($data);
			echo json_encode($q->result());
		}
		
		
		
	}

?>
