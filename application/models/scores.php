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
		
	}

?>
