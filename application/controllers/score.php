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
		
	 /**
		 * Handles edit/update of a Score.
		**/
	
		public function update(){
				if($_SERVER['REQUEST_METHOD'] == "POST"){
					if($this->session->userdata("reviewerLoggedin")){
						$data = array(
						"score" => $this->input->post("inputScore")
					);
						$where = array(
							"abstractID" => $this->input->post("inputAbstractID"),
							"reviewerID" => $this->input->post("inputReviewerID")
						);
						$this->scores->update($data, $where);
						echo json_encode(array(
								"success" => true
							)
						);
					}
				}
				else{
					show_404();
				}
			}	
		
		
	  /**
			* Handles viewing of Avg. Score of a particular Abstract.
			* @TODO: Need to perform join, returning the abstract title, reviewer's name instead of their respective ID's
		**/
		
		public function view_avg(){
			$data = array(
				"abstractID" => $this->uri->segment(3)
			);
			$q = $this->scores->view_avg($data);
			echo json_encode($q->result());
		}
	  	
	}

?>
