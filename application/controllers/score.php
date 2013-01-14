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
		
		public function create($data){
				if($this->session->userdata("reviewerLoggedin") == true){
					$this->scores->insert($data);
				}
				else{
					show_404();
				}
		}
		
	 /**
		 * Handles edit/update of a Score.
		**/
	
		public function update($data, $where){
					if($this->session->userdata("reviewerLoggedin")){
						$this->scores->update($data, $where);
					}
			}	
		
		
	  /**
			* Handles viewing of Avg. Score of a particular Abstract.
			* @TODO: Need to perform join, returning the abstract title, reviewer's name instead of their respective ID's
		**/
		
		public function view_avg($id=0){
			if($this->session->userdata("adminLoggedin") == true){
				if($id==0){
					$data = array(
						"abstractID" => $this->uri->segment(3)
					);
					$q = $this->scores->view_avg($data);
				}
				else{
					$data = array(
						"abstractID" => $id
					);
					$q = $this->scores->view_where($data);
					if($q->num_rows() > 0){
						$total_score = 0;
						$result = $q->result();
						foreach($result as $row){
							if($row->score == NULL){
								$score_stripped = 0;
								$total_score = $total_score + $score_stripped;
							}
							else{
								$score_arr = (json_decode($row->score, true));
								$conservation_score = $score_arr['conservation'];
								$science_score = $score_arr['science'];
								$total_score = $total_score + $conservation_score + $science_score;
							}
						}
						return $total_score/$q->num_rows();
					}
					else{
						return 0;
					}
				}
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
			* Handles select_where of a Score.
		**/
		
		public function select_where($data, $where){
			$q = $this->scores->select_where($data, $where);
			return $q->result();
		}
		
			
	 /**
		 * Handles deletion of a Score.
		**/
		
		public function delete($data){
				if($this->session->userdata("reviewerLoggedin") ==true || $this->session->userdata("adminLoggedin") == true){
					$q = $this->scores->view_where($data);
					if($q->num_rows() > 0){
						$this->scores->delete($data);
					}
				}
				else{
					show_404();
				}
		}
	}

?>
