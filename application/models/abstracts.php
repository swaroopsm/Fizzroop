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
			$this->db->select(array("abstracts.abstractID", "abstracts.abstractTitle", "abstracts.abstractImageFolder", "abstracts.attendeeID", "abstracts.reviewer1", "abstracts.reviewer2", "abstracts.reviewer3", "attendees.attendeeFirstName", "attendees.attendeeLastName"))->from("abstracts");
			$this->db->join("attendees", "attendees.attendeeID=abstracts.attendeeID AND abstracts.conferenceID=$conferenceID");
			$q = $this->db->get();
			return $q;
		}
		
	 
	 	
	 /**
			* Returns a specific Abstract subjected to a where clause. 
		*/
		
		public function view_where($abstractID, $conferenceID){
			$this->db->select(array("abstracts.abstractID", "abstracts.abstractTitle", "abstracts.abstractContent", "abstracts.abstractImageFolder", "abstracts.attendeeID", "abstracts.reviewer1", "abstracts.reviewer2", "abstracts.reviewer3", "attendees.attendeeFirstName", "attendees.attendeeLastName"))->from("abstracts");
			$this->db->join("attendees", "attendees.attendeeID=abstracts.attendeeID AND abstracts.abstractID=$abstractID AND abstracts.conferenceID=$conferenceID");
			$q = $this->db->get();
			return $q;
		}	
		
		
		/**
			*	Handles select of all Abstracts.
		**/
		public function select($data){
			$this->db->select($data);
			return $this->db->get("abstracts");
		}
		
		
		/**
			* Handles select_where of an Abstract.
		**/
		
		public function select_where($data, $where){
			$this->db->select($data);
			$q = $this->db->get_where("abstracts", $where);
			return $q;
		}
		
	 
	 /**
	 	 * Select using where. This is straight-forward!!
	 **/
	 public function select_where_plain($data, $where){
	 	$this->db->select($data);
	 	$this->db->from("abstracts");
	 	$this->db->where($where);
	 	return $this->db->get();
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
