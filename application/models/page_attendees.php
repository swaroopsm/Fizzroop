<?php

	class Page_Attendees extends CI_Model{
		
		/**
			* Creates a new entry in the page_attendees.
		*/
		
		public function insert($data){
			$this->db->insert("page_attendees", $data);
		}
		
	}

?>
