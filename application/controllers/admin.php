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
				require_once(APPPATH."controllers/conference.php");
				$conf = new Conference();
				$cur_conf_q = $conf->get_current_conf();
				$cur_conf = $cur_conf_q[0]->conferenceID;
				$conf_last = $conf->get_order_limit(array("conferenceID","year"), "conferenceID", "DESC", "3");
				$conference_archive = "<p>Manage: ";
				foreach($conf_last as $conf_arch){
					if($conf_arch->conferenceID!=$cur_conf){
						$conference_archive .= "<a href='".base_url()."admin/conference/".$conf_arch->conferenceID."'>".$conf_arch->year."</a> | ";
					}
				}
				$conference_archive = substr($conference_archive, 0, strlen($conference_archive) - 2);
				$a = $this->abstracts->select_where_not_null(array("abstractID"), array("conferenceID" => $this->session->userdata("conferenceID")));
				$approved = $this->abstracts->select_where_not_null(array("abstractID"), array("approved >" => 0, "conferenceID" => $this->session->userdata("conferenceID")));
				$r = $this->reviewers->select(array("reviewerID"));
				//$s = $this->scores->select(array("scoreID"))->num_rows() - $this->scores->view_where(array("recommendation" => NULL))->num_rows();
				$s = $this->scores->select(array("abstractID"));
				$r_approved = 0;
				if($s->num_rows > 0){
					foreach($s->result() as $sapp){
						$sc_abs_id = $sapp->abstractID;
						$cur_abs_q = $this->abstracts->select_where_not_null(array("conferenceID"), array("abstractID" => $sc_abs_id));
						if($cur_abs_q->num_rows > 0){
							$cur_abs_r = $cur_abs_q->result();
							if($cur_abs_r[0]->conferenceID == $this->session->userdata("conferenceID")){
								$r_approved++;
							}
						}
					}
				}
				$c = $this->comments->view_where(array());
				$ca = ($this->comments->abs_with_comments_count());
				$com_count_for_cur_conf = 0;
				if($ca->num_rows > 0){
					foreach($ca->result() as $cur_conf_com){
						$abs_id = $cur_conf_com->abstractID;
						$cur_abs_q = $this->abstracts->select_where_not_null(array("conferenceID"), array("abstractID" => $abs_id));
						if($cur_abs_q->num_rows > 0){
							$cur_abs_r = $cur_abs_q->result();
							if($cur_abs_r[0]->conferenceID == $this->session->userdata("conferenceID")){
								$com_count_for_cur_conf++;
							}
						}
					}
				}
				$data['page_title'] = "Welcome Admin!";
				$data['total_abstracts'] = $a->num_rows;
				$data['approved_abstracts'] = $approved->num_rows();
				$data['total_reviewers'] = $r->num_rows();
				$data['registered_attendees'] = "";//@TODO Need to pull data from doAttend.
				$data['recommendations'] = $r_approved;
				$data['abstract_comments_count'] = $com_count_for_cur_conf;
				$data['archived_conferences'] = $conference_archive;
				$data['current_conf'] = $cur_conf;
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
					$q = $c->get_order_limit(array("conferenceID"), "conferenceID", "DESC", "1");
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
	 
	 /**
	 	*	Handles changing of a conference.
	 **/
	 
	 public function change_conference(){
	 	if($this->session->userdata("adminLoggedin") == true){
	 		$conferenceID = $this->uri->segment(3);
	 		$this->session->set_userdata(array("conferenceID" => $conferenceID));
	 		redirect(base_url()."admin");
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
