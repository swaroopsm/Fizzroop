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
				
				if($this->attendees->login($data)->num_rows() > 0){
					$this->session->set_userdata(array(
						"loggedin" => true,
						"email" => $this->input->post("inputLoginEmail")
					));
					redirect(base_url()."attendee");
				}
				else{
					 $this->session->set_flashdata("message", "<span class='span3 alert alert-danger'><center>Login failed!</center></span>");
           redirect(base_url()."index.php/login");
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
					$data = array(
						"attendeeFirstName" => $this->input->post("inputFirstName"),
						"attendeeLastName" => $this->input->post("inputLastName"),
						"attendeeEmail" => $this->input->post("inputEmail"),
						"attendeePassword" => $this->encrypt->sha1($this->input->post("inputPassword").$this->encrypt->sha1($this->config->item("password_salt")))
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
				else{
					show_404();
				}
			}
		
		
		/**
			*	Handles registration of an Attendee
		**/
		
		public function register(){
			if($_SERVER['REQUEST_METHOD'] == "POST"){
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
				else{
					show_404();
				}
		}
		
	}

?>
