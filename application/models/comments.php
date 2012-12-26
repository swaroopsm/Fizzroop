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
		
	}

?>
