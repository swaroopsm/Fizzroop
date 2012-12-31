<?php

	class Abstracts extends CI_Model{
		
		/**
			* Creates a new Abstract.
		*/
		
		public function insert($data){
			$this->db->insert("abstracts", $data);
		}
		
		
		/**
			* Returns all Abstracts needed for the BIG ABSTRACTS table.
		*/
		
		public function view(){
			$this->db->select(array("abstracts.abstractID", "abstracts.abstractTitle", "abstracts.abstractImageFolder", "abstracts.attendeeID", "attendees.attendeeFirstName", "attendees.attendeeLastName"))->from("abstracts");
			$this->db->join("attendees", "attendees.attendeeID=abstracts.attendeeID");
			$q = $this->db->get();
			return $q->result();
		}
		
		
	 /**
			* Removes a particular Abstract.
		*/
		
		public function delete($data){
			$this->db->delete("abstracts", $data);
		}
		
	}

?>
