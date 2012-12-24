<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Admin extends CI_Controller{
		
		public function __construct(){
			parent::__construct();
			$this->load->library("session");
			$this->load->library("encrypt");
			$this->load->model("admins");
		}
		
		public function index(){
			$data['page_title'] = "Welcome Admin!";
			$this->load->view("adminDashboard", $data);
		}
	 
	 public function login(){
	 	if($_SERVER['REQUEST_METHOD'] == "POST"){
				$data = array(
					"adminEmail" => $this->input->post("inputLoginEmail"),
					"adminPassword" => $this->encrypt->sha1($this->input->post("inputLoginPwd").$this->encrypt->sha1($this->config->item("password_salt")))
				);
				
				if($this->admins->view_where($data)->num_rows() > 0){
					$this->session->set_userdata(array(
						"loggedin" => true,
						"email" => $this->input->post("inputLoginEmail")
					));
					redirect(base_url()."admin");
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
	 
	}

?>
