<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Page  extends CI_Controller{
	
		/**
			*	Constructor function.
		*/
	
		public function __construct(){
			parent::__construct();
			$this->load->library("session");
			$this->load->model("pages");
			$this->load->model("page_attendees");
			$this->load->library("uri");
		}
		
		
		/**
			*	Handles creation of a new Page.
		*/
		
		public function create(){
			if($this->session->userdata("adminLoggedin") == true && $_SERVER['REQUEST_METHOD'] == "POST"){
				#@TODO Think of a way to handle Page Images.
				$data = array(
					"pageTitle" => $this->input->post("inputPageTitle"),
					"pageContent" => $this->input->post("inputPageContent"),
					"pageType" => $this->input->post("inputPageType"),
					"conferenceID" => $this->session->userdata("conferenceID")
				);
				$this->pages->insert($data);
				echo json_encode(array("success" => true, "pageID" => $this->db->insert_id()));
			}
			else{
				show_404();
			}
		}
	
		
		/**
			*	Handles viewing of all Pages.
		*/
		
		public function view(){
			if($this->session->userdata("adminLoggedin") == true){
				$q = $this->pages->view_where(array("conferenceID" => $this->session->userdata("conferenceID")));
				echo json_encode($q->result());
			}
			else{
				show_404();
			}
		}
		
		
		/**
			*	Handles viewing of a particular Page.
		*/
		
		public function view_where(){
				$id = $this->uri->segment(2);
				$q = $this->pages->view_where(
					array(
						"pageID" => $id
					)
				);
				$page_info = array();
				$attendees = array();
				if($q->num_rows() > 0){
					$r = $q->result();
					require_once(APPPATH."controllers/image.php");
					$img = new Image();
					$i = $img->view_page_images($r[0]->pageID);
					$images = array();
					if($i->num_rows() > 0){
						foreach($i->result() as $page_image){
							$images[] = array(
								"imageID" => $page_image->imageID,
								"image" => $this->config->item("upload_path").$page_image->image
							);
						}
					}
					if($this->session->userdata("adminLoggedin") == true){
						$pq = $this->page_attendees->select_where(array("attendeeID"), array("pageID" => $id));
						if($pq->num_rows() > 0){
								foreach($pq->result() as $pr){
									require_once(APPPATH."controllers/attendee.php");
									$a = new Attendee();
									$aq = $a->attendee_data(array("attendeeFirstName", "attendeeLastName", "attendeeEmail"), array("attendeeID" => $pr->attendeeID));
									if($aq->num_rows > 0){
										foreach($aq->result() as $ar){
											$attendees[] = array(
												"attendeeID" => $pr->attendeeID,
												"attendeeFirstName" => $ar->attendeeFirstName,
												"attendeeLastName" => $ar->attendeeLastName,
												"attendeeEmail" => $ar->attendeeEmail
											);
										}
									}
								}
							}
							$page_info[] = array(
								"pageID" => $r[0]->pageID,
								"pageTitle" => $r[0]->pageTitle,
								"pageContent" => $r[0]->pageContent,
								"conferenceID" => $r[0]->conferenceID,
								"pageType" => $r[0]->pageType,
								"images" => $images,
								"seats" => $r[0]->seats,
								"seats_taken" => $r[0]->seats_taken,
								"attendees" => $attendees
							);
							echo json_encode($page_info);
						}
						else{
							$page_info[] = array(
										"pageID" => $r[0]->pageID,
										"pageTitle" => $r[0]->pageTitle,
										"pageContent" => $r[0]->pageContent,
										"conferenceID" => $r[0]->conferenceID,
										"pageType" => $r[0]->pageType,
										"images" => $images,
										"seats" => $r[0]->seats,
										"seats_taken" => $r[0]->seats_taken
									);
									echo json_encode($page_info);
						}
					}
		}
		
		
		/**
			*	Handles select_where function.
		**/
		
		public function select_where(){
			if($this->session->userdata("adminLoggedin") == true){
				$data = array(
					"pageID",
					"pageTitle"
				);
				$where = array(
					"conferenceID" => $this->session->userdata("conferenceID")
				);
				$q = $this->pages->select_where($data, $where);
				echo json_encode($q->result());
			}
			else{
				show_404();
			}
		}
		
		
		
		/**
			*	Handles updating of a Page.
		*/
		
		public function update(){
			if($this->session->userdata("adminLoggedin") == true && $_SERVER['REQUEST_METHOD'] == "POST"){
				if($this->input->post("inputSeats") < $this->input->post("inputSeatsTaken")){
					echo json_encode(array("success" => false, "message" => "Total seats cannot be less than the number of seats that are taken already."));
				}
				else{
					$data = array(
						"pageTitle" => $this->input->post("inputPageTitle"),
						"pageContent" => $this->input->post("inputPageContent"),
						"conferenceID" => $this->session->userdata("conferenceID"),
						"pageType" => $this->input->post("inputPageType"),
						"seats" => $this->input->post("inputSeats")
					);
					$where = array(
						"pageID" => $this->input->post("inputPageID")
					);
					$this->pages->update($data, $where);
					echo json_encode(
						array(
							"success" => true,
							"pageID" => $this->input->post("inputPageID")
						)
					);
				}
			}
		}
		
		
		/**
			*	Handles Page type view.
		**/
		
		public function view_page_type(){
			$page_type = $this->uri->segment(3);
			$q = $this->pages->view_where(
					array(
						"pageType" => $page_type
					)
				);
				if($q->num_rows() > 0){
					$r = $q->result();
					$result = array();
					foreach($r as $pp){
						require_once(APPPATH."controllers/image.php");
						$img = new Image();
						$i = $img->view_page_images($pp->pageID);
						$images = array();
						if($i->num_rows() > 0){
							foreach($i->result() as $page_image){
								$images[] = array(
									"imageID" => $page_image->imageID,
									"image" => $this->config->item("upload_path").$page_image->image
								);
							}
						}
						$result[] = array(
							"pageID" => $pp->pageID,
							"pageTitle" => $pp->pageTitle,
							"pageContent" => $pp->pageContent,
							"conferenceID" => $pp->conferenceID,
							"pageType" => $pp->pageType,
							"images" => $images,
							"seats" => $pp->seats,
							"seats_taken" => $pp->seats_taken
						);
					}
				}
				echo json_encode($result);
		}
		
		/**
			*	Handles deletion of a Page.
		*/
		
		public function delete(){
			if($this->session->userdata("adminLoggedin") == true && $_SERVER['REQUEST_METHOD'] == "POST"){
				$where = array(
					"pageID" => $this->input->post("inputPageID")
				);
				require_once(APPPATH."controllers/image.php");
				$img = new Image();
				$i = $img->delete_page_images($this->input->post("inputPageID"));
				$this->pages->delete($where);
				echo json_encode(
					array(
						"success" => true,
						"deleted_images" => $i['deleted_images']
					)
				);
			}
		}
		
		
	}

?>
