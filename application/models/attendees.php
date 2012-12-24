<?php

	class Attendees extends CI_Model{
	
		/**
			* Creates a new Attendee
		*/
		
		public function insert($data){
			if($this->db->insert("attendees", $data))
				return true;
			else
				return false;
		}
		
		
		/**
			* Log in an Attendee
		*/
		
		public function login($data){
			return $this->db->get_where("attendees", $data);
		}
		
		
		/**
			* Returns all attendees
		*/
		
		public function view(){
			return $this->db->get("attendees");
		}
		
	}

?>
