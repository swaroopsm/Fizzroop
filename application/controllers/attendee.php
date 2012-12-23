<?php

	class Attendee extends CI_Controller{
	
		public function create(){
			if($_SERVER['REQUEST_METHOD'] == "POST"){
				$this->load->library("encrypt");
				$this->load->library("session");
				$this->load->model("attendees");
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
		
		public function login(){
			if($_SERVER['REQUEST_METHOD'] == "POST"){
				$this->load->library("encrypt");
				$this->load->library("session");
				$this->load->model("attendees");
				$data = array(
					"attendeeEmail" => $this->input->post("inputLoginEmail"),
					"attendeePassword" => $this->encrypt->sha1($this->input->post("inputLoginPwd").$this->encrypt->sha1($this->config->item("password_salt")))
				);
				
				if($this->attendees->login($data)->num_rows() > 0){
					echo "login success";
				}
				else{
					 $this->session->set_flashdata('message', '<span class="span3 alert alert-danger"><a class="close" data-dismiss="alert">&times</a>Login failed!</span>');
           redirect(base_url()."index.php/login");
				}
			}
			else{
				show_404();
			}
		}
		
	}

?>
