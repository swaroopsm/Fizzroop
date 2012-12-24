<?php

	class Conferences extends CI_Model{
		
		public function insert($data){
			if($this->db->insert("conferences", $data))
				return true;
			else
				return false;
		}
		
		/**
			* Returns all conferences.
		*/
		
		public function view(){
			return $this->db->get("conferences");
		}
		
		
		/**
			* Returns all conferences subjected to a where clause. 
		*/
		
		public function view_where($data){
			return $this->db->get_where("conferences", $data);
		}
		
		
		/**
			* Returns specific column fields of all conferences.
		*/
		
		public function select($data){
			$this->db->select($data);
			return $this->db->get("conferences");
		}
		
		
		/**
			* Returns specific column fields subjected to a where clause.
		*/
		
		public function select_where($data, $where){
			$this->db->select($data);
			return $this->db->get_where("conferences", $where);
		}
		
	}

?>
