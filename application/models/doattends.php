<?php

	class Doattends extends CI_Model{
		
		/**
			* Creates a new DoAttend entry.
		*/
		
		public function insert($data){
			$this->db->insert("doAttend", $data);
		}
		
		
		/**
			* Returns all doAttend entries needed for the BIG ABSTRACTS table.
		*/
		
		public function view(){
			return $this->db->get("doAttend");
		}
		
		
		/**
			* Returns a specific doAttend entry subjected to a where clause. 
		*/
		
		public function view_where($data){
			return $this->db->get_where("doAttend", $data);
		}
		
		
		/**
			* Returns specific column fields of all doAttend entries.
		*/
		
		public function select($data){
			$this->db->select($data);
			return $this->db->get("doAttend");
		}
		
		
		/**
			* Returns specific column fields subjected to a where clause.
		*/
		
		public function select_where($data, $where){
			$this->db->select($data);
			return $this->db->get_where("conferences", $where);
		}
		
		
		/**
			* Updates values of a particular doAttend entry.
		*/
		
		public function update($data, $where){
			$this->db->where($where);
			$this->db->update("doAttend", $data);
		}
		
		
		/**
			* Removes a particular doAttend entry.
		*/
		
		public function delete($data){
			$this->db->delete("doAttend", $data);
		}
		
	}

?>
