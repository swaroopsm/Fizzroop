<?php

	class Attendees extends CI_Model{
	
		/**
			* Creates a new Attendee
		*/
		
		public function insert($data){
			$this->db->insert("attendees", $data);
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
	   * Select using where. This is straight-forward!!
	 **/
	  
	 public function select_where_plain($data, $where){
	 	 $this->db->select($data);
	 	 $this->db->from("attendees");
	 	 $this->db->where($where);
	 	 return $this->db->get();
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
		
		
		/**
			* Retrieve latest attendee.
		**/
		
		public function get_order_limit($data, $order, $ordering, $limit){
			$this->db->select($data);
			$this->db->from("attendees");
			$this->db->where("attendeeTicket IS NOT NULL");
			$this->db->order_by($order, $ordering);
			$this->db->limit($limit);
			$q = $this->db->get();
			return $q->result();
		}
		
		
		/**
			*	Count all Attendees registered via doAttend.
		**/
		
		public function get_doattend_count(){
			#$this->db->from("attendees");
			$this->db->where("attendeeTicket IS NOT NULL");
			return $this->db->count_all_results("attendees");
		}
		
		
		/**
			*	Return some rows for CSV export.
		**/
		
		public function export_csv($where){
			$this->db->select(array(
				"attendeeTicket AS Ticket",
				"attendeeFirstName AS FirstName",
				"attendeeLastName AS LastName",
				"attendeeEmail AS Email",
				"attendeeGender AS Gender",
				"attendeeDOB AS DateOfBirth",
				"attendeeAcademic AS AcademicStatus",
				"attendeeInstAffiliation AS InstitutionAffiliated",
				"attendeeAddress AS Address",
				"attendeePhone AS Phone",
				"attendeeNationality AS Nationality",
				"attendeePassport AS Passport"
			));
			$this->db->from("attendees");
			$this->db->where($where);
			return $this->db->get();
		}
		
	}

?>
