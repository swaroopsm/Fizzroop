<?php

	class Pages extends CI_Model{
	
		/**
			* Creates a new Page.
		*/
		
		public function insert($data){
			$this->db->insert("pages", $data);
		}
		
		
		/**
			* Returns all Pages.
			*	TODO Also need to Return Images, instead of the pageImageIDs.
		*/
		
		public function view(){
			return $this->db->get("pages");
		}
		
		
		/**
			* Returns a specific Page subjected to a where clause. 
			*	TODO Also need to Return Images, instead of the pageImageID.
		*/
		
		public function view_where($data){
			return $this->db->get_where("pages", $data);
		}
		
		
		/**
			* Returns specific column fields of all Pages.
		*/
		
		public function select($data){
			$this->db->select($data);
			return $this->db->get("pages");
		}
		
		
		/**
			* Returns specific column fields subjected to a where clause.
		*/
		
		public function select_where($data, $where){
			$this->db->select($data);
			return $this->db->get_where("pages", $where);
		}
		
		
		/**
			* Updates values of a particular Page.
		*/
		
		public function update($data, $where){
			$this->db->where($where);
			$this->db->update("pages", $data);
		}
		
		
		/**
			* Removes a particular Page.
		*/
		
		public function delete($data){
			$this->db->delete("pages", $data);
		}
		
	}

?>
