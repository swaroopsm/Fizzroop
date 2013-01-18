<?php

	class Images extends CI_Model{
		
		/**
			*	Creates a new Image entry.
		**/
		
		public function insert($data){
			$this->db->insert("images", $data);
		}
		
		
		/**
			* Returns all Images.
		*/
		
		public function view(){
			return $this->db->get("images");
		}
		
		
		/**
			* Returns a specific Image(s) subjected to a where clause. 
		*/
		
		public function view_where($data){
			return $this->db->get_where("images", $data);
		}
		
		
		/**
			* Updates values of a particular Image entry.
		*/
		
		public function update($data, $where){
			$this->db->where($where);
			$this->db->update("images", $data);
		}
		
		
	}

?>
