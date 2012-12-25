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
		
		
		/**
			* Returns a specific Reviewer subjected to a where clause. 
		*/
		
		public function view_where($data){
			return $this->db->get_where("reviewers", $data);
		}
		
		
		/**
			* Returns specific column fields of all Reviewers.
		*/
		
		public function select($data){
			$this->db->select($data);
			return $this->db->get("reviewers");
		}
		
		
		/**
			* Returns specific column fields of a Reviewer subjected to a where clause.
		*/
		
		public function select_where($data, $where){
			$this->db->select($data);
			return $this->db->get_where("reviewers", $where);
		}
		
	}

?>
