<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Attendee extends CI_Controller{
		
		/**
			* Constructor function
		**/
		
		public function __construct(){
			parent::__construct();
			$this->load->library("session");
			$this->load->library("encrypt");
			$this->load->model("attendees");
			$this->load->library("uri");
		}
		
		
		/**
			* Index function for the Attendee Dashboard.
		*/
		public function index(){
			if($this->session->userdata("loggedin")){
				$attendeeEmail = array(
					"attendeeEmail" => $this->session->userdata("email")
				);
				$q = $this->attendees->view_where($attendeeEmail);
				foreach($q->result() as $row){
					$data['attendeeFirstName'] = $row->attendeeFirstName;
					$data['attendeeLastName'] = $row->attendeeLastName;
					$data['attendeeRegistered'] = $row->registered;
					$data['page_title'] = "Welcome ".$row->attendeeFirstName." ".$row->attendeeLastName."!";
				}
				$this->load->view("attendeeDashboard", $data);
			}
			else{
				$this->session->set_flashdata("message", "<span class='span3 alert alert-danger'><center>You are not logged in!</center></span>");
				redirect(base_url()."login");
			}
		}

		/**
			* Handles creation of an Attendee.
		**/

		public function create(){
			if($_SERVER['REQUEST_METHOD'] == "POST"){
				$data = array(
					"attendeeFirstName" => $this->input->post("inputFirstName"),
					"attendeeLastName" => $this->input->post("inputLastName"),
					"attendeeEmail" => $this->input->post("inputEmail"),
					"attendeePassword" => $this->encrypt->sha1($this->input->post("inputPassword").$this->encrypt->sha1($this->config->item("password_salt")))
				);
				if($this->attendees->insert($data))
					echo ":)";
				else
					echo ":)";
			}
			else{
				show_404();
			}
		}
		
		
		/*
			*	Handles login of Attendee.
		**/
		
		public function login(){
			if($_SERVER['REQUEST_METHOD'] == "POST"){
				$data = array(
					"attendeeEmail" => $this->input->post("inputLoginEmail"),
					"attendeePassword" => $this->encrypt->sha1($this->input->post("inputLoginPwd").$this->encrypt->sha1($this->config->item("password_salt")))
				);
				
				if($this->attendees->view_where($data)->num_rows() > 0){
					$this->session->set_userdata(array(
						"loggedin" => true,
						"email" => $this->input->post("inputLoginEmail"),
						"id" => $this->attendees->select_where(array("attendeeID"), array("attendeeEmail" => $this->input->post("inputLoginEmail")))->row()->attendeeID
					));
					redirect(base_url()."attendee");
				}
				else{
					 $this->session->set_flashdata("message", "<span class='span3 alert alert-danger'><center>Login failed!</center></span>");
           redirect(base_url()."login");
				}
			}
			else{
				show_404();
			}
		}
		
		/**
			*	Handles edit/update of Attendee.
		**/
	
		public function update(){
				if($_SERVER['REQUEST_METHOD'] == "POST"){
					if($this->session->userdata("loggedin") == true || $this->session->userdata("adminLoggedin") == true){
						$data = array(
						"attendeeFirstName" => $this->input->post("inputFirstName"),
						"attendeeLastName" => $this->input->post("inputLastName"),
						"attendeeEmail" => $this->input->post("inputEmail")
					);
						$where = array(
							"attendeeID" => $this->input->post("inputAttendeeID")
						);
						$this->attendees->update($data, $where);
						echo json_encode(array(
								"success" => true,
								"attendeeID" => $this->input->post("inputAttendeeID")
							)
						);
					}
				}
				else{
					show_404();
				}
			}
		
		
		/**
			*	Handles registration of an Attendee
		**/
		
		public function register(){
			if($_SERVER['REQUEST_METHOD'] == "POST"){
				if($this->session->userdata("loggedin") ==true || $this->session->userdata("adminLoggedin") == true){
						$data = array(
							"registered" => 1
						);
						$where = array(
							"attendeeID" => $this->input->post("inputAttendeeID")
						);
						$this->attendees->update($data, $where);
						echo json_encode(array(
								"success" => true,
								"attendeeID" => $this->input->post("inputAttendeeID")
							)
						);
					}
				}
				else{
					show_404();
				}
		}
		
		/**
			* Handles viewing of a particular Attendee.
		**/
		
		public function view_where(){
			if($this->session->userdata("adminLoggedin") == true || ($this->session->userdata("loggedin") == true && $this->session->userdata("id") == $this->uri->segment(2))){
				$data = array(
				"attendeeID" => $this->uri->segment(2)
			);
			$q = $this->attendees->view_where($data);
			echo json_encode($q->result());
			}
			else{
				show_404();
			}
		}
		
		
		/**
			*	Handles viewing of all Attendees.
		**/
		
		public function view(){
			$data = array(
				"attendeeID",
				"attendeeFirstName",
				"attendeeLastName",
				"attendeeEmail",
				"registered"
			);
			$q = $this->attendees->select($data);
			echo json_encode($q->result());
		}
		
		
		/**
			* Handles password reset for an Attendee.
		**/
		
		public function reset(){
			if($_SERVER['REQUEST_METHOD'] == "POST"){
				if($this->session->userdata("loggedin") == true || $this->session->userdata("adminLoggedin") == true){
					$oldData = array(
					"attendeePassword",
					"attendeeEmail"
				);
					$where = array(
						"attendeeID" => $this->input->post("inputAttendeeID")
					);
					$confirmPwd = $this->encrypt->sha1($this->input->post("inputConfPassword").$this->encrypt->sha1($this->config->item("password_salt")));
					$q = $this->attendees->select_where($oldData, $where);
					$r = $q->result();
					$oldPwd = $r[0]->attendeePassword;
					$myEmail = $r[0]->attendeeEmail;
					$sessionEmail = $this->session->userdata("email");
					if($myEmail == $sessionEmail){
						if($oldPwd == $confirmPwd){
					$newPwd = $this->encrypt->sha1($this->input->post("inputNewPassword").$this->encrypt->sha1($this->config->item("password_salt")));
						$data = array(
						"attendeePassword" => $newPwd
					);
					$this->attendees->update($data, $where);
					echo json_encode(array(
							"success" => true,
							"attendeeID" => $this->input->post("inputAttendeeID"),
							"responseMsg" => "Passwords updated successfully!"
						)
					);
					}
					else{
						echo json_encode(array(
								"success" => false,
								"attendeeID" => $this->input->post("inputAttendeeID"),
								"responseMsg" => "Passwords do not match!"
							)
						);
					}
					}
					else{
						echo json_encode(array(
								"success" => false,
								"attendeeID" => $this->input->post("inputAttendeeID"),
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
			* Handles deletion of an Attendee.
		**/
		
		public function delete(){
			if($_SERVER['REQUEST_METHOD'] == "POST"){
				if($this->session->userdata("adminLoggedin") == true){
					if($this->attendees->view_where(array("attendeeID" => $this->input->post("inputAttendeeID")))->num_rows()>0){
						$data = array(
						"attendeeID" => $this->input->post("inputAttendeeID")
						);
						$this->attendees->delete($data);
						echo json_encode(array(
								"success" => true,
								"responseMsg" => "Attendee has been removed!"
							)
						);
				}
				else{
						echo json_encode(array(
								"success" => false,
								"responseMsg" => "No such Attendee exists!"
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
