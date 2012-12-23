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
					echo "Login failed!";
				}
			}
			else{
				show_404();
			}
		}
		
	}

?>
