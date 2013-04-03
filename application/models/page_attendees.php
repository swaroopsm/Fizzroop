<?php

	class Page_Attendees extends CI_Model{
		
		/**
			* Creates a new entry in the page_attendees.
		*/
		
		public function insert($data){
			$this->db->insert("page_attendees", $data);
		}
		
		
		/**
			* Handles select_where of an page_attendee.
		**/
		
		public function select_where($data, $where){
			$this->db->select($data);
			$q = $this->db->get_where("page_attendees", $where);
			return $q;
		}
		
	}

?>
