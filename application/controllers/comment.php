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
		**/
		
		public function create(){
			if($_SERVER['REQUEST_METHOD'] == "POST"){
				$data = array(
					"commentContent" => $this->input->post("inputComment"),
					"abstractID" => $this->input->post("inputAbstractID"),
					"reviewerID" => $this->input->post("inputReviewerID"),
					"commentType" => $this->input->post("inputCommentType")
				);
				$this->comments->insert($data);
				echo json_encode(
					array(
						"success" => true,
						"commentType" => $this->db->insert_id()
					)
				);
			}
			else{
				show_404();
			}
		}
	 
	 
	 /**
			*	Handles edit/update of a Comment.
		**/
	
		public function update(){
				if($_SERVER['REQUEST_METHOD'] == "POST"){
					if($this->session->userdata("reviewerLoggedin") == true || $this->session->userdata("adminLoggedin") == true){
						$data = array(
						"commentContent" => $this->input->post("inputComment")
					);
						$where = array(
							"commentID" => $this->input->post("inputCommentID")
						);
						$this->comments->update($data, $where);
						echo json_encode(array(
								"success" => true,
								"commentID" => $this->input->post("inputCommentID")
							)
						);
					}
				}
				else{
					show_404();
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
			*	Handles viewing of all Comments.
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
