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
						"email" => $this->input->post("inputLoginEmail"),
						"id" => $this->reviewers->view_where($data)->row()->reviewerID
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
			* @TODO: Need to implement Foreign Key checks.
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
		
		
		/**
			*	Handles viewing of all Reviewers.
		**/
		
		public function view(){
			$data = array(
				"reviewerID",
				"reviewerFirstName",
				"reviewerLastName",
				"reviewerEmail",
			);
			require_once(APPPATH."controllers/abstractc.php");
			$a = new Abstractc();
			$q = $this->reviewers->select($data);
			foreach($q->result() as $r){
				$rid = $r->reviewerID;
				$ares = $a->select_where(array("abstractID"), "reviewer1 = $rid OR reviewer2 = $rid OR reviewer3 = $rid", 1);
				$reviewers[] = array(
					"reviewerID" => $rid,
					"reviewerFirstName" => $r->reviewerFirstName,
					"reviewerLastName" => $r->reviewerLastName,
					"reviewerEmail" => $r->reviewerEmail,
					"workingAbstracts" => $ares->num_rows()
				);
			}
			echo json_encode($reviewers);
		}
		
		
		/**
			* Handles password reset for a Reviewer.
		**/
		
		public function reset(){
			if($_SERVER['REQUEST_METHOD'] == "POST"){
				if($this->session->userdata("reviewerLoggedin") == true || $this->session->userdata("adminLoggedin") == true){
					$oldData = array(
					"reviewerPassword",
					"reviewerEmail"
				);
					$where = array(
						"reviewerID" => $this->input->post("inputReviewerID")
					);
					$confirmPwd = $this->encrypt->sha1($this->input->post("inputConfPassword").$this->encrypt->sha1($this->config->item("password_salt")));
					$q = $this->reviewers->select_where($oldData, $where);
					$r = $q->result();
					$oldPwd = $r[0]->reviewerPassword;
					$myEmail = $r[0]->reviewerEmail;
					$sessionEmail = $this->session->userdata("email");
					if($myEmail == $sessionEmail){
						if($oldPwd == $confirmPwd){
					$newPwd = $this->encrypt->sha1($this->input->post("inputNewPassword").$this->encrypt->sha1($this->config->item("password_salt")));
						$data = array(
						"reviewerPassword" => $newPwd
					);
					$this->reviewers->update($data, $where);
					echo json_encode(array(
							"success" => true,
							"reviewerID" => $this->input->post("inputReviewerID"),
							"responseMsg" => "Passwords updated successfully!"
						)
					);
					}
					else{
						echo json_encode(array(
								"success" => false,
								"reviewerID" => $this->input->post("inputReviewerID"),
								"responseMsg" => "Passwords do not match!"
							)
						);
					}
					}
					else{
						echo json_encode(array(
								"success" => false,
								"reviewerID" => $this->input->post("inputReviewerID"),
								"responseMsg" => "Authorization failed!"
							)
						);
					}
				}
				
			}
			else{
				show_404();
			}
			
		}
		
		
		/**
			* Handles select_where of a Reviewer
		**/
		
		public function select_where($data, $where){
			return $this->reviewers->select_where($data, $where);
		}
		
		
		/**
			* Handles deletion of a Reviewer.
		**/
		
		public function delete(){
			if($_SERVER['REQUEST_METHOD'] == "POST"){
				if($this->session->userdata("adminLoggedin") == true){
					if($this->reviewers->view_where(array("reviewerID" => $this->input->post("inputReviewerID")))->num_rows()>0){
						$data = array(
						"reviewerID" => $this->input->post("inputReviewerID")
						);
						$this->reviewers->delete($data);
						echo json_encode(array(
								"success" => true,
								"responseMsg" => "Reviewer has been removed!"
							)
						);
				}
				else{
						echo json_encode(array(
								"success" => false,
								"responseMsg" => "No such Reviewer exists!"
							)
						);
					}
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
