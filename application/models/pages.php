<?php

	class Pages extends CI_Model{
	
		/**
			* Creates a new Page.
		*/
		
		public function insert($data){
			$this->db->insert("pages", $data);
		}
	
	}

?>
