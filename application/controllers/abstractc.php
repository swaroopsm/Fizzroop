<?php

	class Abstractc extends CI_Controller{
	
	 /**
	 	 * Constructor function
	 **/
	 
		public function __construct(){
			parent::__construct();
			$this->load->library("session");
			$this->load->library("encrypt");
			$this->load->model("abstracts");
			$this->load->library("uri");
		}
		
	 /**
		 * Handles creation of an Abstract.
		 * @TODO Need to implement Foreign Key checks.
		**/
		
		public function create(){
			if($_SERVER['REQUEST_METHOD'] == "POST"){
				if($this->session->userdata("loggedin") == true){
					$data = array(
						"abstractTitle" => $this->input->post("inputAbstractTitle"),
						"abstractContent" => $this->input->post("inputAbstractContent"),
						"conferenceID" => $this->input->post("inputConferenceID"),
						"attendeeID" => $this->input->post("inputAttendeeID")
					);
					$this->abstracts->insert($data);
					echo json_encode(
						array(
							"success" => true,
							"attendeeID" => $this->db->insert_id()
						)
					);
				}
			}
			else{
				show_404();
			}
		}
	 
	}

?>
