<?php

	class Attendees extends CI_Model{
	
		public function insert($data){
			if($this->db->insert("attendees", $data))
				return true;
			else
				return false;
		}
		
		public function login($data){
			return $this->db->get_where("attendees", $data);
		}
		
		public function view(){
			return $this->db->get("attendees");
		}
		
	}

?>
