<?php

	class Scores extends CI_Model{
	
		/**
			* Creates a new Score.
		*/
		
		public function insert($data){
			$this->db->insert("scores", $data);
		}
		
		
	 /**
			* Returns a specific Score subjected to a where clause. 
		*/
		
		public function view_where($data){
			return $this->db->get_where("scores", $data);
		}
		
		
	 /**
			* Returns Average score subjected to a where clause. 
		*/
		
		public function view_avg($data){
			$this->db->select_avg("score");
			return $this->db->get_where("scores", $data);
		}
		
	 
	 /**
			* Updates values of a particular Score.
		*/
		
		public function update($data, $where){
			$this->db->where($where);
			$this->db->update("scores", $data);
		}
		
	
	/**
		* Returns specific column fields of all Scores.
		*/
		
		public function select($data){
			$this->db->select($data);
			return $this->db->get("scores");
		}
		
		
	 /**
			* Removes a particular Score.
		*/
		
		public function delete($data){
			$this->db->delete("scores", $data);
		}
		
	}

?>
