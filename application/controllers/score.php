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
					$this->scores->delete($data);
				}
				else{
					show_404();
				}
		}
	}

?>
