<?php

	class Reviewers extends CI_Model{
		
		/**
			* Creates a new Attendee
		*/
		
		public function insert($data){
			$this->db->insert("reviewers", $data);
		}
		
		
	}

?>
