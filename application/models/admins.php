<?php 
	
	class Admins extends CI_Model{
		
		/**
			* Returns a specific attendee subjected to a where clause.
		**/
		
		public function view_where($data){
			return $this->db->get_where("admins", $data);
		}
		
		/**
			* Updates values of a particular Admin.
		*/
		
		public function update($data, $where){
			$this->db->where($where);
			$this->db->update("admins", $data);
		}
		
	}
	
?>
