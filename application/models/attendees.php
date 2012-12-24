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
		
		
		/**
			* Returns specific column fields subjected to a where clause.
		*/
		
		public function select_where($data, $where){
			$this->db->select($data);
			return $this->db->get_where("attendees", $where);
		}
		
		
		/**
			* Updates values of a particular attendee.
		*/
		
		public function update($data, $where){
			$this->db->where($where);
			$this->db->update("attendees", $data);
		}
		
		
		/**
			* Removes a particular attendee.
		*/
		
		public function delete($data){
			$this->db->delete("attendees", $data);
		}
		
	}

?>
