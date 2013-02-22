<?php

	class Doattends extends CI_Model{
		
		/**
			* Creates a new DoAttend entry.
		*/
		
		public function insert($data){
			$this->db->insert("doAttend", $data);
		}
		
	}

?>
