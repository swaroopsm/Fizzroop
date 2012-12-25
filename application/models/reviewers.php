<?php

	class Reviewers extends CI_Model{
		
		/**
			* Creates a new Reviewer.
		*/
		
		public function insert($data){
			$this->db->insert("reviewers", $data);
		}
		
		
		/**
			* Returns all Reviewers.
		*/
		
		public function view(){
			return $this->db->get("reviewers");
		}
		
	}

?>
