<?php

	class Comments extends CI_Model{
		
		/**
			* Creates a new Comment.
		*/
		
		public function insert($data){
			$this->db->insert("comments", $data);
		}
		
	}

?>
