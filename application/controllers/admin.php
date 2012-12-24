<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Admin extends CI_Controller{
		
		public function __construct(){
			parent::__construct();
			$this->load->library("session");
			$this->load->library("encrypt");
			$this->load->model("admins");
		}
		
		public function index(){
			if($this->session->userdata("adminLoggedin")){
				$data['page_title'] = "Welcome Admin!";
				$this->load->view("adminDashboard", $data);
			}
			else{
				$this->session->set_flashdata("message", "<span class='span3 alert alert-danger'><center>You are not logged in!</center></span>");
				redirect(base_url()."signin");
			}
		}
	 
	 public function login(){
	 	if($_SERVER['REQUEST_METHOD'] == "POST"){
				$data = array(
					"adminEmail" => $this->input->post("inputLoginEmail"),
					"adminPassword" => $this->encrypt->sha1($this->input->post("inputLoginPwd").$this->encrypt->sha1($this->config->item("password_salt")))
				);
				
				if($this->admins->view_where($data)->num_rows() > 0){
					$this->session->set_userdata(array(
						"adminLoggedin" => true,
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
	 
	 public function update(){
				if($_SERVER['REQUEST_METHOD'] == "POST"){
					if($this->session->userdata("adminLoggedin") == true){
						$data = array(
						"adminEmail" => $this->input->post("inputEmail"),
						"adminPassword" => $this->encrypt->sha1($this->input->post("inputPassword").$this->encrypt->sha1($this->config->item("password_salt")))
					);
						$where = array(
							"adminID" => $this->input->post("inputAdminID")
						);
						$this->admins->update($data, $where);
						echo json_encode(array(
								"success" => true,
								"adminID" => $this->input->post("inputAdminID")
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
	 
	 public function view_where(){
	 		$data = array(
				"adminID" => $this->uri->segment(2)
			);
			$q = $this->admins->view_where($data);
			echo json_encode($q->result());
	 }
	 
	}

?>
