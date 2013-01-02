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
		
		public function view($conferenceID){
			$this->db->select(array("abstracts.abstractID", "abstracts.abstractTitle", "abstracts.abstractImageFolder", "abstracts.attendeeID", "attendees.attendeeFirstName", "attendees.attendeeLastName"))->from("abstracts");
			$this->db->join("attendees", "attendees.attendeeID=abstracts.attendeeID AND abstracts.conferenceID=$conferenceID");
			$q = $this->db->get();
			return $q;
		}
		
	 
	 	
	 /**
			* Returns a specific Abstract subjected to a where clause. 
		*/
		
		public function view_where($data){
			return $this->db->get_where("abstracts", $data);
		}	
		
		
		
		/**
			* Handles select_where of an Abstract.
		**/
		
		public function select_where($data, $where){
			$this->db->select($data);
			$q = $this->db->get_where("abstracts", $where);
			return $q->result();
		}
		
		
	 /**
			* Updates values of a particular Abstract.
		*/
		
		public function update($data, $where){
			$this->db->where($where);
			$this->db->update("abstracts", $data);
		}
		
		
	 /**
			* Removes a particular Abstract.
		*/
		
		public function delete($data){
			$this->db->delete("abstracts", $data);
		}
		
	}

?>
