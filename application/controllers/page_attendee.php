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
				$pq = $this->pages->select_where(array("pageType", "seats"), array("pageID" => $this->input->post("inputPageID")));
				$pr = $pq->result();
				if($pr[0]->pageType == "3"){
					$flag = 0;
					if($this->session->userdata("adminLoggedin") == true){
						$this->page_attendees->insert(
							array(
								"pageID" => $this->input->post("inputPageID"),
								"attendeeID" => $this->input->post("inputAttendeeID")
							)
						);
						$flag = 1;
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
						$flag = 1;
					}
					else{
						show_404();
					}
					if($flag == 1){
						$this->pages->update(
							array(
								"seats" => ($pr[0]->seats - 1)
							),
							array(
								"pageID" => $this->input->post("inputPageID")
							)
						);
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
		
		
		/**
			*	Handles deletion of an entry.
		**/
		
		public function delete(){
			if($_SERVER['REQUEST_METHOD'] == "POST"){
					$pq = $this->pages->select_where(array("pageType", "seats"), array("pageID" => $this->input->post("inputPageID")));
					$pr = $pq->result();
					$flag = 0;
					if($pr[0]->pageType == "3"){
						if($this->session->userdata("adminLoggedin") == true && $this->page_attendees->select_where(array("page_attendeesID"), array("attendeeID" => $this->input->post("inputAttendeeID"), "pageID" => $this->input->post("inputPageID")))->num_rows()>0){
							$this->page_attendees->delete(
								array(
									"pageID" => $this->input->post("inputPageID"),
									"attendeeID" => $this->input->post("inputAttendeeID")
								)
							);
							$flag = 1;
						}
						elseif($this->session->userdata("loggedin") == true && $this->page_attendees->select_where(array("page_attendeesID"), array("attendeeID" => $this->session->userdata("id"), "pageID" => $this->input->post("inputPageID")))->num_rows()>0){
							$this->page_attendees->delete(
								array(
									"pageID" => $this->input->post("inputPageID"),
									"attendeeID" => $this->session->userdata("id")
								)
							);
							$flag = 1;
						}
						else{
							show_404();
						}
						
						if($flag = 1){
							$this->pages->update(
								array(
									"seats" => ($pr[0]->seats + 1)
								),
								array(
									"pageID" => $this->input->post("inputPageID")
								)
							);
						}
						
					}
					else{
						show_404();
					}
				}
		}
		
	}

?>
