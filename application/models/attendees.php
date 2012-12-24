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
		
		
		
		/**
			* Returns a specific attendee subjected to a where clause. 
		*/
		
		public function view_where($data){
			return $this->db->get_where("attendees", $data);
		}
		
		
		/**
			* Returns specific column fields of all attendees.
		*/
		
		public function select($data){
			$this->db->select($data);
			return $this->db->get("attendees");
		}
		
	}

?>
