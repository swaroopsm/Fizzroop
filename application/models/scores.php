<?php

	class Scores extends CI_Model{
	
		/**
			* Creates a new Score.
		*/
		
		public function insert($data){
			$this->db->insert("scores", $data);
		}
	
	}

?>
