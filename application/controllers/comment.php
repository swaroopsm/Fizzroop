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
	
	}

?>
