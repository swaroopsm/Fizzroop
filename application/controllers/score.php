<?php

	class Score extends CI_Controller{
	
		/**
			* Constructor function
		**/
		
		public function __construct(){
			parent::__construct();
			$this->load->library("session");
			$this->load->model("scores");
			$this->load->library("uri");
		}
	 
	 
	 /**
		 * Handles creation of a Score.
		 * @TODO Need to implement Foreign Key checks.
		**/
		
		public function create(){
			if($_SERVER['REQUEST_METHOD'] == "POST"){
				if($this->session->userdata("reviewerLoggedin") == true){
					$data = array(
						"abstractID" => $this->input->post("inputAbstractID"),
						"reviewerID" => $this->input->post("inputReviewerID"),
						"score" => $this->input->post("inputScore"),
						"recommendation" => $this->input->post("inputRecommendation")
					);
					$this->scores->insert($data);
					echo json_encode(
						array(
							"success" => true,
							"scoreID" => $this->db->insert_id()
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
			 
	}

?>
