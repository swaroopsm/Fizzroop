<?php

	class Conferences extends CI_Model{
		
		public function insert($data){
			if($this->db->insert("conferences", $data))
				return true;
			else
				return false;
		}
	
	}

?>
