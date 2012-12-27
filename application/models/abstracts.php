<?php

	class Abstracts extends CI_Model{
		
		/**
			* Creates a new Abstract.
		*/
		
		public function insert($data){
			$this->db->insert("abstracts", $data);
		}
		
	}

?>
