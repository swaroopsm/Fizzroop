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
		
		
		/**
			* Returns specific column fields of all Comment.
		*/
		
		public function select($data){
			$this->db->select($data);
			return $this->db->get("comments");
		}
		
		
		/**
			* Returns specific column fields of a Comment subjected to a where clause.
		*/
		
		public function select_where($data, $where){
			$this->db->select($data);
			return $this->db->get_where("comments", $where);
		}
		
		
		/**
			*	Returns count of Abstracts that have comments.
		**/
		
		public function abs_with_comments_count(){
			$this->db->select("abstractID, COUNT(*) AS count");
			$this->db->from("comments");
			$this->db->group_by("abstractID");
			return $this->db->get();
		}
		
		/**
			* Updates values of a particular Comment.
		*/
		
		public function update($data, $where){
			$this->db->where($where);
			$this->db->update("comments", $data);
		}
		
		
		/**
			* Removes a particular Comment.
		*/
		
		public function delete($data){
			$this->db->delete("comments", $data);
		}
		
	}

?>
