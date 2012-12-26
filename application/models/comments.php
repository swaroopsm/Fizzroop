<?php

	class Comments extends CI_Model{
		
		/**
			* Creates a new Comment.
		*/
		
		public function insert($data){
			$this->db->insert("comments", $data);
		}
		
		
		/**
			* Returns all Comments.
		*/
		
		public function view(){
			return $this->db->get("comments");
		}
		
		
		/**
			* Returns a specific Comment subjected to a where clause. 
		*/
		
		public function view_where($data){
			return $this->db->get_where("comments", $data);
		}
		
	}

?>
