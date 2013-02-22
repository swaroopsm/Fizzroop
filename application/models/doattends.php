<?php

	class Doattends extends CI_Model{
		
		/**
			* Creates a new DoAttend entry.
		*/
		
		public function insert($data){
			$this->db->insert("doAttend", $data);
		}
		
		
		/**
			* Returns all Abstracts needed for the BIG ABSTRACTS table.
		*/
		
		public function view(){
			return $this->db->get("doAttend");
		}
		
	}

?>
