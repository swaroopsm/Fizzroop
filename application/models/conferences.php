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
			* Returns a specific conference subjected to a where clause. 
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
		
		
		/**
			* Updates values of a particular conference
		*/
		
		public function update($data, $where){
			$this->db->where($where);
			$this->db->update("conferences", $data);
		}
		
		
		/**
			* Retrieve latest conference
		**/
		
		public function get_order_limit($data, $order, $ordering, $limit){
			$this->db->select($data);
			$this->db->from("conferences");
			$this->db->order_by($order, $ordering);
			$this->db->limit($limit);
			$q = $this->db->get();
			return $q->result();
		}
		
	}

?>
