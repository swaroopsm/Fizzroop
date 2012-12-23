<?php

	class Attendees extends CI_Model{
	
		public function insert($data){
			if($this->db->insert("attendees", $data))
				return true;
			else
				return false;
		}
	
	}

?>
