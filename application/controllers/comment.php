<?php

	class Comment extends CI_Controller{
	
		/**
			* Constructor function
		**/
		
		public function __construct(){
			parent::__construct();
			$this->load->library("session");
			$this->load->model("comments");
			$this->load->library("uri");
		}
	
	 /**
		 * Handles creation of a Comment.
		 * @TODO Need to implement Foreign Key checks.
		**/
		
		public function create($data){
				if($this->session->userdata("reviewerLoggedin") == true){
					$this->comments->insert($data);
				}
		}
	 
	 
	 /**
		 * Handles edit/update of a Comment.
		**/
	
		public function update($data, $where){
					if($this->session->userdata("reviewerLoggedin") == true || $this->session->userdata("adminLoggedin") == true){
						$this->comments->update($data, $where);
					}
			}
			
		
		/**
			* Handles viewing of a particular Comment.
			* @TODO: Need to perform join, returning the abstract title, reviewer's name instead of their respective ID's
		**/
		
		public function view_where(){
			$data = array(
				"commentID" => $this->uri->segment(2)
			);
			$q = $this->comments->view_where($data);
			echo json_encode($q->result());
		}
	 
	 
	 /**
		 * Handles viewing of all Comments.
		**/
		
		public function view(){
			$data = array(
				"commentID",
				"commentContent",
				"abstractID",
				"reviewerID",
				"commentType"
			);
			$q = $this->comments->select($data);
			echo json_encode($q->result());
		}
		
		
		/**
			* Handles select_where of a Comment with Reviewer name.
		**/
		
		public function select_where_reviewer($data, $where){
			require_once(APPPATH."controllers/reviewer.php");
			$r = new Reviewer();
			$q = $this->comments->select_where($data, $where);
			if($q->num_rows > 0){
				$row = $q->result();
					foreach($row as $comment){
						$rid = $comment->reviewerID;
						$rev = $r->select_where(array("reviewerFirstName", "reviewerLastName"), array("reviewerID" => $rid));
						$rev_res = $rev->result();
						$result[] = array(
							"commentID" => $comment->commentID,
							"commentContent" => $comment->commentContent,
							"commentType" => $comment->commentType,
							"reviewerFirstName" => $rev_res[0]->reviewerFirstName,
							"reviewerLastName" => $rev_res[0]->reviewerLastName
						);
					}
				return $result;
			}
			else{
			 return array();
			}
		}
		
		
	 /**
		 * Handles deletion of a Comment.
		**/
		
		public function delete(){
			if($_SERVER['REQUEST_METHOD'] == "POST"){
				if($this->session->userdata("adminLoggedin") == true || $this->session->userdata("reviewerLoggedin") ==true){
					if($this->comments->view_where(array("commentID" => $this->input->post("inputCommentID")))->num_rows()>0){
						$data = array(
						"commentID" => $this->input->post("inputCommentID")
						);
						$this->comments->delete($data);
						echo json_encode(array(
								"success" => true,
								"responseMsg" => "Comment has been removed!"
							)
						);
				}
				else{
						echo json_encode(array(
								"success" => false,
								"responseMsg" => "No such Comment exists!"
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
