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
			* Index Function.
		**/
		
		public function index(){
			if($this->session->userdata("reviewerLoggedin")){
				$q = $this->reviewers->select_where(
					array(
						"reviewerFirstName",
						"reviewerLastName"
					),
					array(
						"reviewerID" => $this->session->userdata("id")
					)
				);
				$r = $q->result();
				$data['reviewerName'] = $r[0]->reviewerFirstName." ".$r[0]->reviewerLastName;
				$this->load->view("reviewerDashboard", $data);
			}
			else{
				$this->session->set_flashdata("message", "<span class='span3 alert alert-danger'><center>You are not logged in!</center></span>");
				redirect(base_url()."reviewersignin");
			}
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
					require_once(APPPATH."controllers/conference.php");
					$c = new Conference();
					$q = $c->get_order_limit(array("conferenceID"), "conferenceID", "DESC", "1");
					$conferenceID = $q[0]->conferenceID;
					$this->session->set_userdata(array(
						"reviewerLoggedin" => true,
						"email" => $this->input->post("inputLoginEmail"),
						"id" => $this->reviewers->view_where($data)->row()->reviewerID,
						"conferenceID" => $conferenceID
					));
					redirect(base_url()."reviewer");
				}
				else{
					 $this->session->set_flashdata("message", "<span class='span3 alert alert-danger'><center>Login failed!</center></span>");
           redirect(base_url()."reviewersignin");
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
			* Handles viewing of a particular Reviewer.
		**/
		
		public function view_where(){
			if($this->session->userdata("adminLoggedin") == true || $this->uri->segment(2) == $this->session->userdata("id")){
				$data = array(
					"reviewerID" => $this->uri->segment(2)
				);
				$q = $this->reviewers->view_where($data);
				if($q->num_rows > 0){
						$qres = $q->result();
					$rid = $qres[0]->reviewerID;
					require_once(APPPATH."controllers/abstractc.php");
					$a = new Abstractc();
					$ares = $a->select_where(array("abstractID", "abstractTitle", "abstractImageFolder", "attendeeID"), "reviewer1 = $rid OR reviewer2 = $rid OR reviewer3 = $rid", 1);
					if($ares->num_rows() > 0){
						foreach($ares->result() as $abstract){
							if($abstract->attendeeID == NULL){
								$abstracts = array();
							}
							else{
								$abstracts[] = array(
									"abstractID" => $abstract->abstractID,
									"abstractTitle" => $abstract->abstractTitle,
									"abstractImageFolder" => $abstract->abstractImageFolder
								);
							}
						}
					}
					else{
						$abstracts = array();
					}
					$reviewer = array(
						"reviewerID" => $rid,
						"reviewerFirstName" => $qres[0]->reviewerFirstName,
						"reviewerLastName" => $qres[0]->reviewerLastName,
						"reviewerEmail" => $qres[0]->reviewerEmail,
						"abstracts" => $abstracts
					);
					echo json_encode($reviewer);
				}
				else{
					echo json_encode(array());
				}
			}
			else{
				show_404();
			}
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
				if($ares->num_rows() > 0){
					$abstracts = array();
					foreach($ares->result() as $abstractRow){
						$abstracts[] = $abstractRow->abstractID;
					}
				}
				else{
					$abstracts = array();
				}
				$reviewers[] = array(
					"reviewerID" => $rid,
					"reviewerFirstName" => $r->reviewerFirstName,
					"reviewerLastName" => $r->reviewerLastName,
					"reviewerEmail" => $r->reviewerEmail,
					"workingAbstracts" => $ares->num_rows(),
					"abstracts" => $abstracts
				);
			}
			echo json_encode($reviewers);
		}
		
		
		
		/**
			*	Handles Reviewers table that conssts of assigned Abstracts.
		**/
		
		public function reviewer_abstracts(){
			$reviewerID = $this->uri->segment(3);
			$conferenceID = $this->session->userdata("conferenceID");
			require_once(APPPATH."controllers/abstractc.php");
			$a = new Abstractc();
			$q = $a->select_where(
				array(
					"abstractID",
					"abstractTitle",
					"active",
					"approved"
				),
				"reviewer1 = $reviewerID OR reviewer2 = $reviewerID OR reviewer3 = $reviewerID AND (conferenceID = $conferenceID)",
				1
			);
			if($q->num_rows() > 0){
				require_once(APPPATH."controllers/score.php");
				$s = new Score();
				foreach($q->result() as $abstract){
					$abstractID = $abstract->abstractID;
					$score = $s->select_where(
						array(
							"score",
							"recommendation"
						),
						array(
							"abstractID" => $abstractID,
							"reviewerID" => $reviewerID
						)
					);
					$count = 0;
					$ab_score = null;
					$ab_recommendation = null;
					foreach($score as $s_count){
						if($s_count->score){
							$ab_score = $s_count->score;
						}
						if($s_count->recommendation){
							$ab_recommendation = $s_count->recommendation;
						}
					}	
					$result[] = array(
						"abstractID" => $abstractID,
						"abstractTitle" => $abstract->abstractTitle,
						"active" => $abstract->active,
						"approved" => $abstract->approved,
						"score" => $ab_score,
						"recommendation" => $ab_recommendation
					);
				}
				echo json_encode($result);
			}
			else{
				echo json_encode(array());
			}
		}
		
		
		/**
			*	Handles viewing of a single Abstract assigned to a Reviewer.
		**/
		
		public function reviewer_abstracts_by_id(){
			if($this->session->userdata("reviewerLoggedin") == true){
				$abstractID = $this->uri->segment(4);
				$reviewerID = $this->session->userdata("id");
				$conferenceID = $this->session->userdata("conferenceID");
				require_once(APPPATH."controllers/abstractc.php");
				$a = new Abstractc();
				$q = $a->select_where(
					array(
						"abstractID",
						"abstractTitle",
						"abstractContent",
						"abstractImageFolder",
						"active",
						"approved"
					),
					"abstractID = $abstractID AND conferenceID = $conferenceID AND (reviewer1 = $reviewerID OR reviewer2 = $reviewerID OR reviewer3 = $reviewerID)",
					1
				);
				if($q->num_rows() > 0){
					$aq = $q->result();
					$rq = $this->reviewers->select_where(array("reviewerFirstName", "reviewerLastName"), array("reviewerID" => $reviewerID));
					$reviewer = $rq->result();
					require_once(APPPATH."controllers/comment.php");
					$c = new comment();
					require_once(APPPATH."controllers/score.php");
					$s = new score();
					$cq = $c->select_where_reviewer(array("commentID","commentContent", "commentType", "reviewerID"), array("abstractID" => $abstractID, "reviewerID" => $reviewerID));
						if(count($cq > 0)){
							$comments = $cq;
						}
						else{
							$comments = array();
						}
					$sq = $s->select_where(array("scoreID", "score", "recommendation"), array("abstractID" => $abstractID, "reviewerID" => $reviewerID));
					if(count($sq) > 0){
						$scores = $sq;
					}
					else{
						$scores = array();
					}
					$result[] = array(
						"abstractID" => $abstractID,
						"abstractTitle" => $aq[0]->abstractTitle,
						"abstractContent" => $aq[0]->abstractContent,
						"abstractImageFolder" => base_url().$this->config->item("upload_path").$aq[0]->abstractImageFolder,
						"reviewerFirstName" => $reviewer[0]->reviewerFirstName,
						"reviewerLastName" => $reviewer[0]->reviewerLastName,
						"comments" => $comments,
						"scores" => $scores
					);
					echo json_encode($result);
				}
				else{
					echo json_encode(array());
				}
			}
		}
		
		
		/**
			* Handles updating of comments and scores done by a Reviewer for a particular Abstract.
		**/
		
		public function reviewer_abstract_submit(){
		if($this->session->userdata("reviewerLoggedin") == true && $_SERVER['REQUEST_METHOD'] == "POST"){
			require_once(APPPATH."controllers/comment.php");
			require_once(APPPATH."controllers/score.php");
			$c = new Comment();
			$s = new Score();
			$abstractID = $this->input->post("abstractID");
			$reviewerID = $this->input->post("reviewerID");
			$comment_reviewer = $this->input->post("comment_reviewer");
			$comment_admin = $this->input->post("comment_admin");
			$comment_reviewer_id = $this->input->post("comment_reviewer_id");
			$comment_admin_id = $this->input->post("comment_admin_id");
			$score = $this->input->post("score");
			$recommendation = $this->input->post("recommendation");
			$scoreID = $this->input->post("scoreID");
			if($comment_reviewer_id == ""){
				$c->create(
					array(
						"commentContent" => $comment_reviewer,
						"commentType" => 1,
						"abstractID" => $abstractID,
						"reviewerID" => $reviewerID
					)
				);
			}
			else{
				$c->update(
					array(
						"commentContent" => $comment_reviewer,
						"commentType" => 1,
						"abstractID" => $abstractID,
						"reviewerID" => $reviewerID
					),
					array(
						"commentID" => $comment_reviewer_id
					)
				);
			}
			if($comment_admin_id == ""){
				$c->create(
					array(
						"commentContent" => $comment_admin,
						"commentType" => 2,
						"abstractID" => $abstractID,
						"reviewerID" => $reviewerID
					)
				);
			}
			else{
				$c->update(
					array(
						"commentContent" => $comment_admin,
						"commentType" => 2,
						"abstractID" => $abstractID,
						"reviewerID" => $reviewerID
					),
					array(
						"commentID" => $comment_admin_id
					)
				);
			}
			if($scoreID == ""){
				$s->create(
					array(
						"abstractID" => $abstractID,
						"reviewerID" => $reviewerID,
						"score" => $score,
						"recommendation" => $recommendation
					)
				);
			}
			else{
				$s->update(
					array(
						"abstractID" => $abstractID,
						"reviewerID" => $reviewerID,
						"score" => $score,
						"recommendation" => $recommendation
					),
					array(
						"scoreID" => $scoreID
					)
				);
			}
		}
		else{
			show_404();
		}
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
			*	Handles rendering of Abstract View for Reviewer.
		**/
		
		public function abstract_view(){
			if($this->session->userdata("reviewerLoggedin")){
				$q = $this->reviewers->select_where(
					array(
						"reviewerFirstName",
						"reviewerLastName"
					),
					array(
						"reviewerID" => $this->session->userdata("id")
					)
				);
				$r = $q->result();
				$data['reviewerName'] = $r[0]->reviewerFirstName." ".$r[0]->reviewerLastName;
				$this->load->view("abstractView", $data);
			}
			else{
				$this->session->set_flashdata("message", "<span class='span3 alert alert-danger'><center>You are not logged in!</center></span>");
				redirect(base_url()."reviewersignin");
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
