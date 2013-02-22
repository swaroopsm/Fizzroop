<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Doattend extends CI_Controller{
		
		/**
	 	 * Constructor function
	 **/
	 
		public function __construct(){
			parent::__construct();
			$this->load->library("session");
			$this->load->library("encrypt");
			$this->load->model("doattends");
			$this->load->library("uri");
		}
		
		
		/**
			*	Handles creation of a new doAttend entry.
		**/
		
		public function create($data){
			$this->doattends->insert($data);
			return $this->db->insert_id();
		}
		
		
		/**
			*	Handles checking for a doAttend ticket.
		**/
		
		public function check_ticket(){
			$my_ticket = $this->uri->segment(3);
			$flag = 0;
			$url = "http://doattend.com/api/events/".$this->config->item('doAttend_event')."/participants_list.json?api_key=".$this->config->item('doAttend_key');
			$jsonObject = json_decode(file_get_contents($url), true);
			$participants = $jsonObject['participants'];
			foreach($participants as $p){
				$ticket = $p['Ticket_Number'];
				if($ticket == $my_ticket){
					$flag = 1;
					break;
				}
			}
			if($flag>0){
				echo json_encode(array("verified" => true));
			}
			else{
				echo json_encode(array("verified" => false));
			}
		}
		
	}

?>
