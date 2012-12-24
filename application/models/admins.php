<?php 
	
	class Admins extends CI_Model{
		
		/**
			* Returns a specific attendee subjected to a where clause.
		**/
		
		public function view_where($data){
			return $this->db->get_where("admins", $data);
		}
		
	}
	
?>
