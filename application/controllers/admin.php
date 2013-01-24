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
				$this->load->model("abstracts");
				$this->load->model("reviewers");
				$this->load->model("attendees");
				$this->load->model("scores");
				$this->load->model("comments");
				$a = $this->abstracts->select_where(array("abstractID"), array("conferenceID" => $this->session->userdata("conferenceID")));
				$approved = $this->abstracts->select_where_plain(array("abstractID"), array("approved" => 1, "conferenceID" => $this->session->userdata("conferenceID")));
				$r = $this->reviewers->select(array("reviewerID"));
				$s = $this->scores->select(array("scoreID"))->num_rows() - $this->scores->view_where(array("recommendation" => NULL))->num_rows();
				$c = $this->comments->view_where(array());
				$ca = ($this->comments->abs_with_comments_count());
				$data['page_title'] = "Welcome Admin!";
				$data['total_abstracts'] = $a->num_rows;
				$data['approved_abstracts'] = $approved->num_rows();
				$data['total_reviewers'] = $r->num_rows();
				$data['registered_attendees'] = "";//@TODO Need to pull data from doAttend.
				$data['recommendations'] = $s;
				$data['abstract_comments_count'] = $ca->num_rows();
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
					require_once(APPPATH."controllers/conference.php");
					$c = new Conference();
					$q = $c->get_order_limit();
					$conferenceID = $q[0]->conferenceID;
					$this->session->set_userdata(array(
						"adminLoggedin" => true,
						"email" => $this->input->post("inputLoginEmail"),
						"conferenceID" => $conferenceID
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
	 		if($this->session->userdata("adminLoggedin") == true){
	 			$data = array(
				"adminID" => $this->uri->segment(2)
				);
				$q = $this->admins->view_where($data);
				echo json_encode($q->result());
	 		}
	 		else{
	 			show_404();
	 		}
	 }
	 
	}

?>
