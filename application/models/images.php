<?php

	class Images extends CI_Model{
		
		/**
			*	Creates a new Image entry.
		**/
		
		public function insert($data){
			$this->db->insert("images", $data);
		}
		
		
	}

?>
