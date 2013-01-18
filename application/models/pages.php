<?php

	class Pages extends CI_Model{
	
		/**
			* Creates a new Page.
		*/
		
		public function insert($data){
			$this->db->insert("pages", $data);
		}
		
		
		/**
			* Returns all Pages.
		*/
		
		public function view(){
			return $this->db->get("pages");
		}
		
		
	}

?>
