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
		
		public function view_avg($id=0){
			if($id==0){
				$data = array(
					"abstractID" => $this->uri->segment(3)
				);
				$q = $this->scores->view_avg($data);
				echo json_encode($q->result());
			}
			else{
				$data = array(
					"abstractID" => $id
				);
				$q = $this->scores->view_avg($data);
				return $q->result();
			}
		}
	 
	 
	 /**
		 * Handles viewing of all Scores.
		 * TODO Retreive Abstract Title, Reviewer Name by using JOIN.
		**/
		
		public function view(){
			$data = array(
				"scoreID",
				"score",
				"abstractID",
				"reviewerID",
				"recommendation"
			);
			$q = $this->scores->select($data);
			echo json_encode($q->result());
		}
		
		
	 /**
			*	Handles get_recommendation score for a given abstractID.
		**/
		
		public function get_recommendation($id){
			$where = array(
				"abstractID" => $id
			);
			return $this->scores->get_recommendation($where);
		}
		
			
	 /**
		 * Handles deletion of a Score.
		**/
		
		public function delete(){
			if($_SERVER['REQUEST_METHOD'] == "POST"){
				if($this->session->userdata("reviewerLoggedin") ==true){
					if($this->scores->view_where(array("scoreID" => $this->input->post("inputScoreID")))->num_rows()>0){
						$data = array(
						"scoreID" => $this->input->post("inputScoreID")
						);
						$this->scores->delete($data);
						echo json_encode(array(
								"success" => true,
								"responseMsg" => "Score has been removed!"
							)
						);
				}
				else{
						echo json_encode(array(
								"success" => false,
								"responseMsg" => "No such Score exists!"
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
