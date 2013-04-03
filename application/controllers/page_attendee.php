<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Page_Attendee extends CI_Controller{
		
		/**
			* Constructor function.
		**/
		
		public function __construct(){
			parent::__construct();
			$this->load->library("session");
			$this->load->model("page_attendees");
			$this->load->model("pages");
			$this->load->library("uri");
		}
		
		
		/**
			*	Handles creation of new entry.
		**/
		
		public function create(){
			if($_SERVER['REQUEST_METHOD'] == "POST"){
				$pq = $this->pages->select_where(array("pageType"), array("pageID" => $this->input->post("inputPageID")));
				$pr = $pq->result();
				if($pr[0]->pageType == "3"){
					if($this->session->userdata("adminLoggedin") == true){
						$this->page_attendees->insert(
						array(
							"pageID" => $this->input->post("inputPageID"),
							"attendeeID" => $this->input->post("attendeeID")
						)
					);
					echo json_encode(array("success" => true));
					}
					elseif($this->session->userdata("loggedin") == true){
						$q = $this->page_attendees->select_where(array("page_attendeesID"), array("pageID" => $this->input->post("inputPageID"), "attendeeID" => $this->session->userdata("id")));
						if($q->num_rows < 1){
							$this->page_attendees->insert(
								array(
									"pageID" => $this->input->post("inputPageID"),
									"attendeeID" => $this->session->userdata("id")
								)
							);
							echo json_encode(array("success" => true));
						}
						else{
							echo json_encode(array("success" => false, "message" => "Attendee has already registered for attending this workshop"));
						}
					}
					else{
						show_404();
					}
				}
				else{
					echo json_encode(array("success" => false, "message" => "You can only attend Workshops"));
				}
			}
			else{
				show_404();
			}
		}
			
	}

?>
