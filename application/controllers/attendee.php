<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Attendee extends CI_Controller{
		
		/**
			* Constructor function
		**/
		
		public function __construct(){
			parent::__construct();
			$this->load->library("session");
			$this->load->library("encrypt");
			$this->load->model("attendees");
			$this->load->library("uri");
		}
		
		
		/**
			* Index function for the Attendee Dashboard.
		*/
		public function index(){
			if($this->session->userdata("loggedin")){
				$attendeeEmail = array(
					"attendeeEmail" => $this->session->userdata("email")
				);
				$q = $this->attendees->view_where($attendeeEmail);
				foreach($q->result() as $row){
					$data['attendeeFirstName'] = $row->attendeeFirstName;
					$data['attendeeLastName'] = $row->attendeeLastName;
					$data['attendeeRegistered'] = $row->registered;
					$data['page_title'] = "Welcome ".$row->attendeeFirstName." ".$row->attendeeLastName."!";
				}
				$this->load->view("attendeeDashboard", $data);
			}
			else{
				$this->session->set_flashdata("message", "<span class='span3 alert alert-danger'><center>You are not logged in!</center></span>");
				redirect(base_url()."login");
			}
		}

		/**
			* Handles creation of an Attendee.
		**/

		public function create(){
			if($_SERVER['REQUEST_METHOD'] == "POST"){
				if($this->session->userdata("adminLoggedin") == true)
					$registered = 1;
				else
					$registered = 0;
				$data = array(
					"attendeeFirstName" => $this->input->post("inputFirstName"),
					"attendeeLastName" => $this->input->post("inputLastName"),
					"attendeeEmail" => $this->input->post("inputEmail"),
					"attendeePassword" => $this->encrypt->sha1($this->input->post("inputPassword").$this->encrypt->sha1($this->config->item("password_salt"))),
					"registered" => $registered,
					"attendeeGender" => $this->input->post("inputGender"),
					"attendeeDOB" => $this->input->post("inputDOB"),
					"attendeeAcademic" => $this->input->post("inputAcademic"),
					"attendeeInstAffiliation" => $this->input->post("inputInstAffiliation"),
					"attendeeAddress" => $this->input->post("inputAddress"),
					"attendeePhone" => $this->input->post("inputPhone"),
					"attendeeNationality" => $this->input->post("inputNationality"),
					"attendeePassport" => $this->input->post("inputPassport")
				);
				$this->attendees->insert($data);
				if($this->session->userdata("adminLoggedin") == true){
					echo json_encode(
						array(
							"success" => true,
							"attendeeID" => $this->db->insert_id()
						)
					);
			 }
			 else{
				#@TODO Do login and redirect to Attendee Dashboard.
			 }
			}
			else{
				show_404();
			}
		}
		
		
		/*
			*	Handles login of Attendee.
		**/
		
		public function login(){
			if($_SERVER['REQUEST_METHOD'] == "POST"){
				$data = array(
					"attendeeEmail" => $this->input->post("inputLoginEmail"),
					"attendeePassword" => $this->encrypt->sha1($this->input->post("inputLoginPwd").$this->encrypt->sha1($this->config->item("password_salt")))
				);
				
				if($this->attendees->view_where($data)->num_rows() > 0){
					require_once(APPPATH."controllers/conference.php");
					$c = new Conference();
					$q = $c->get_order_limit(array("conferenceID"), "conferenceID", "DESC", "1");
					$conferenceID = $q[0]->conferenceID;
					$this->session->set_userdata(array(
						"loggedin" => true,
						"email" => $this->input->post("inputLoginEmail"),
						"conferenceID" => $conferenceID,
						"id" => $this->attendees->select_where(array("attendeeID"), array("attendeeEmail" => $this->input->post("inputLoginEmail")))->row()->attendeeID
					));
					redirect(base_url()."attendee");
				}
				else{
					 $this->session->set_flashdata("message", "<span class='span3 alert alert-danger'><center>Login failed!</center></span>");
           redirect(base_url()."login");
				}
			}
			else{
				show_404();
			}
		}
		
		/**
			*	Handles edit/update of Attendee.
		**/
	
		public function update(){
				if($_SERVER['REQUEST_METHOD'] == "POST"){
					if($this->session->userdata("loggedin") == true || $this->session->userdata("adminLoggedin") == true){
						$data = array(
						"attendeeFirstName" => $this->input->post("inputFirstName"),
						"attendeeLastName" => $this->input->post("inputLastName"),
						"attendeeEmail" => $this->input->post("inputEmail")
					);
						$where = array(
							"attendeeID" => $this->input->post("inputAttendeeID")
						);
						$this->attendees->update($data, $where);
						echo json_encode(array(
								"success" => true,
								"attendeeID" => $this->input->post("inputAttendeeID")
							)
						);
					}
				}
				else{
					show_404();
				}
			}
		
		
		/**
			*	Handles registration of an Attendee that changes the password.
		**/
		
		public function register(){
			if($_SERVER['REQUEST_METHOD'] == "POST"){
				if($this->input->post("inputPassport")){
					$passport = $this->input->post("inputPassport");
				}
				else{
					$passport = "";
				}
				$data = array(
					"attendeePassword" => $this->encrypt->sha1($this->input->post("inputPassword").$this->encrypt->sha1($this->config->item("password_salt"))),
					"attendeePassport" => $passport
				);
				$where = array(
					"attendeeID" => $this->input->post("inputAttendeeID")
				);
				$this->attendees->update($data, $where);
				
				// Email Attendee saying he/she has completed registration.
				$q = $this->attendees->select_where(array("attendeeFirstName", "attendeeLastName", "attendeeEmail"), array("attendeeID" => $this->input->post("inputAttendeeID")));
				$r = $q->result();
				$this->load->library('email');
	 			$this->email->set_mailtype("html");
        $this->email->from($this->config->item('service_email'), 'SCCS Registration is complete!');
	 			$this->email->to($r[0]->attendeeEmail);
	 			$this->email->subject("SCCS Registration is complete!");
	 			$this->email->message("Hello ".$r[0]->attendeeFirstName." ".$r[0]->attendeeLastName." <br><br> Your Registration process with SCCS is complete now. You can login to ypur account, and start submitting an Abstract.");
	 			$this->email->send();
	 			
				echo json_encode(array(
						"success" => true,
						"attendeeID" => $this->input->post("inputAttendeeID")
					)
				);
			}
			else{
				show_404();
			}
		}
		
		/**
			* Handles viewing of a particular Attendee.
		**/
		
		public function view_where(){
			if($this->session->userdata("adminLoggedin") == true || ($this->session->userdata("loggedin") == true && $this->session->userdata("id") == $this->uri->segment(2))){
				$data = array(
				"attendeeID" => $this->uri->segment(2)
			);
			$q = $this->attendees->view_where($data);
			echo json_encode($q->result());
			}
			else{
				show_404();
			}
		}
		
		
		/**
			*	Handles viewing of all Attendees.
		**/
		
		public function view(){
			if($this->session->userdata("adminLoggedin") == true){
				$data = array(
					"attendeeID",
					"attendeeFirstName",
					"attendeeLastName",
					"attendeeEmail",
					"registered",
					"attendeeGender",
					"attendeeDOB",
					"attendeeAcademic",
					"attendeeInstAffiliation",
					"attendeeAddress",
					"attendeePhone",
					"attendeeNationality",
					"attendeePassport"
				);
				$where = array(
					"registered" => 1
				);
				$q = $this->attendees->select_where($data, $where);
				$attendees = array();
				if($q->num_rows() > 0){
					require_once(APPPATH."controllers/abstractc.php");
					$a = new Abstractc();
					foreach($q->result() as $row){
						$attendeeID = $row->attendeeID;
						$aq = $a->select_where(array("abstractID"), array("attendeeID" => $attendeeID, "conferenceID" => $this->session->userdata("conferenceID")));
						if($aq->num_rows() > 0){
							$registered = "1";
						}
						else{
							$registered = "0";
						}
						$attendees[] = array(
							"attendeeID" => $attendeeID,
							"attendeeFirstName" => $row->attendeeFirstName,
							"attendeeLastName" => $row->attendeeLastName,
							"attendeeEmail" => $row->attendeeEmail,
							"registered" => $registered, //This is to determine if an Abstract submitted!
							"attendeeGender" => $row->attendeeGender,
							"attendeeDOB" => $row->attendeeDOB,
							"attendeeAcademic" => $row->attendeeAcademic,
							"attendeeInstAffiliation" => $row->attendeeInstAffiliation,
							"attendeeAddress" => $row->attendeeAddress,
							"attendeePhone" => $row->attendeePhone,
							"attendeeNationality" => $row->attendeeNationality,
							"attendeePassport" => $row->attendeePassport
						);
					}
				}
				echo json_encode($attendees);
			}
			else{
				show_404();
			}
		}
		
		
		/**
			*	Handles rendering of view for Abstract submission.
		**/
		
		public function abstract_view(){
			if($this->session->userdata("loggedin")){
				$attendeeEmail = array(
					"attendeeEmail" => $this->session->userdata("email")
				);
				$q = $this->attendees->view_where($attendeeEmail);
				foreach($q->result() as $row){
					$data['attendeeFirstName'] = $row->attendeeFirstName;
					$data['attendeeLastName'] = $row->attendeeLastName;
					$data['attendeeRegistered'] = $row->registered;
					$data['page_title'] = "Welcome ".$row->attendeeFirstName." ".$row->attendeeLastName."!";
				}
				$this->load->view("abstract_view", $data);
			}
			else{
				$this->session->set_flashdata("message", "<span class='span3 alert alert-danger'><center>You are not logged in!</center></span>");
				redirect(base_url()."login");
			}
		}
		
		
		
		/**
			* Handles password reset for an Attendee.
		**/
		
		public function reset(){
			if($_SERVER['REQUEST_METHOD'] == "POST"){
				if($this->session->userdata("loggedin") == true || $this->session->userdata("adminLoggedin") == true){
					$oldData = array(
					"attendeePassword",
					"attendeeEmail"
				);
					$where = array(
						"attendeeID" => $this->input->post("inputAttendeeID")
					);
					$confirmPwd = $this->encrypt->sha1($this->input->post("inputConfPassword").$this->encrypt->sha1($this->config->item("password_salt")));
					$q = $this->attendees->select_where($oldData, $where);
					$r = $q->result();
					$oldPwd = $r[0]->attendeePassword;
					$myEmail = $r[0]->attendeeEmail;
					$sessionEmail = $this->session->userdata("email");
					if($myEmail == $sessionEmail){
						if($oldPwd == $confirmPwd){
					$newPwd = $this->encrypt->sha1($this->input->post("inputNewPassword").$this->encrypt->sha1($this->config->item("password_salt")));
						$data = array(
						"attendeePassword" => $newPwd
					);
					$this->attendees->update($data, $where);
					echo json_encode(array(
							"success" => true,
							"attendeeID" => $this->input->post("inputAttendeeID"),
							"responseMsg" => "Passwords updated successfully!"
						)
					);
					}
					else{
						echo json_encode(array(
								"success" => false,
								"attendeeID" => $this->input->post("inputAttendeeID"),
								"responseMsg" => "Passwords do not match!"
							)
						);
					}
					}
					else{
						echo json_encode(array(
								"success" => false,
								"attendeeID" => $this->input->post("inputAttendeeID"),
								"responseMsg" => "Authorization failed!"
							)
						);
					}
				}
				
			}
			else{
				show_404();
			}
			
		}
		
		
		/**
	 		*	Email all Attendees.
	 	**/
	 	
	 	public function alert_all_attendees(){
	 		if($this->session->userdata("adminLoggedin") == true && $_SERVER['REQUEST_METHOD'] == "POST"){
	 			$this->load->library('email');
	 			$sel_attendees = $this->attendees->select(array("attendeeEmail"));
	 			if($sel_attendees->num_rows() > 0){
	 				$list = array();
	 				foreach($sel_attendees->result() as $a){
	 					array_push($list, $a->attendeeEmail);
	 				}
	 				$this->email->set_mailtype("html");
          $this->email->from($this->config->item('service_email'), 'SCCS Alert');
	 				$this->email->to($list);
	 				$this->email->subject($this->input->post("inputEmailSubject"));
	 				$this->email->message($this->input->post("inputEmailMessage"));
	 				$this->email->send();
	 				echo json_encode(array("success" => true, "message" => $this->input->post()));
	 			}
	 		}
	 		else{
	 			show_404();
	 		}
	 	}
		
		
		/**
			*	Get certain data from attendee.
		**/
		
		public function attendee_data($data, $where){
			return $this->attendees->select_where($data, $where);
		}
		
		
		/**
			*	Get last Attendee.
		**/
		
		public function latest_ticket(){
			return $this->attendees->get_order_limit(array("attendeeTicket"), "attendeeTicket", "DESC", "1");
		}
		
		
		
		/**
			*	Handles Sync of Attendees from doAttend API.
		**/
		
		public function sync(){
				//$my_ticket = $this->uri->segment(3);
				$flag = 0;
				$url = "http://doattend.com/api/events/".$this->config->item('doAttend_event')."/participants_list.json?api_key=".$this->config->item('doAttend_key');
				$jsonObject = json_decode(file_get_contents($url), true);
				$participants = $jsonObject['participants'];
				$c = $this->attendees->get_doattend_count();
				if($c < 1){
					require_once(APPPATH."controllers/conference.php");
					$c = new Conference();
					$q = $c->get_order_limit(array("conferenceID"), "conferenceID", "DESC", "1");
					$conferenceID = $q[0]->conferenceID;
					foreach($participants as $p){
						$dob = $p['participant_information'][3]['info'];
						$parse_dob = date_parse_from_format("M-d-Y", $dob);
						//print_r($parse_dob);
						$dob = $parse_dob['year']."-".$parse_dob['month']."-".$parse_dob['day'];
						//echo $dob;
						$data = array(
							"attendeeFirstName" => $p['participant_information'][0]['info'],
							"attendeeLastName" => $p['participant_information'][1]['info'],
							"attendeeEmail" => $p["Email"],
							"registered" => 1,
							"attendeeGender" => $p['participant_information'][2]['info'],
							"attendeeDOB" => $dob,
							"attendeeAcademic" => $p['participant_information'][4]['info'],
							"attendeeInstAffiliation" => $p['participant_information'][5]['info'],
							"attendeeAddress" => "", //@TODO Get Address key from the doAttend json.
							"attendeePhone" => $p['participant_information'][6]['info'],
							"attendeeNationality" => $p['participant_information'][7]['info'],
							"attendeePassport" => "",
							"attendeeTicket" => $p["Ticket_Number"],
							"conferenceID" => $conferenceID
						);
						//echo json_encode($data);
						$this->attendees->insert($data);
					}
				}
				else{
					$res = $this->attendees->get_order_limit(array("attendeeTicket"), "attendeeTicket", "DESC", "1");
					$last_ticket = $res[0]->attendeeTicket;
					foreach($participants as $p){
						$ticket = $p["Ticket_Number"];
						if($ticket > $last_ticket){
							$dob = $p['participant_information'][3]['info'];
							$parse_dob = date_parse_from_format("M-d-Y", $dob);
							//print_r($parse_dob);
							$dob = $parse_dob['year']."-".$parse_dob['month']."-".$parse_dob['day'];
							//echo $dob;
							$data = array(
								"attendeeFirstName" => $p['participant_information'][0]['info'],
								"attendeeLastName" => $p['participant_information'][1]['info'],
								"attendeeEmail" => $p["Email"],
								"registered" => 1,
								"attendeeGender" => $p['participant_information'][2]['info'],
								"attendeeDOB" => $dob,
								"attendeeAcademic" => $p['participant_information'][4]['info'],
								"attendeeInstAffiliation" => $p['participant_information'][5]['info'],
								"attendeeAddress" => "", //@TODO Get Address key from the doAttend json.
								"attendeePhone" => $p['participant_information'][6]['info'],
								"attendeeNationality" => $p['participant_information'][7]['info'],
								"attendeePassport" => "",
								"attendeeTicket" => $p["Ticket_Number"]
							);
							//echo json_encode($data);
							$this->attendees->insert($data);
						}
					}
				}
		}
		
		
		/**
			*	 Handles checking of doAttend ticket number.
		**/
		
		public function check_ticket(){
			if($_SERVER['REQUEST_METHOD'] == "POST"){
				$this->sync();
				$ticket = $this->uri->segment(3);
				$email = $this->input->post("inputEmail");
				$q = $this->attendees->view_where(array("attendeeTicket" => $ticket, "attendeeEmail" => $email));
				if($q->num_rows > 0){
					$r = $q->result();
					if($r[0]->attendeePassword != NULL){
						echo json_encode(array("success" => true, "flag" => 1));
					}
					else{
						foreach($r as $a){
							$attendee = array(
								"attendeeID" => $a->attendeeID,
								"attendeeFirstName" => $a->attendeeFirstName,
								"attendeeLastName" => $a->attendeeLastName,
								"attendeeNationality" => $a->attendeeNationality,
								"attendeeEmail" => $a->attendeeEmail,
								"attendeeTicket" => $a->attendeeTicket
							);
						}
						echo json_encode(array("success" => true, "flag" => 2, "attendee" => $attendee));
					}
				}
				else{
					echo json_encode(array("success" => false, "flag" => 0));
				}
			}
			else{
				show_404();
			}
		}
		
		
		/**
			* Handles deletion of an Attendee.
		**/
		
		public function delete(){
			if($_SERVER['REQUEST_METHOD'] == "POST"){
				if($this->session->userdata("adminLoggedin") == true){
					if($this->attendees->view_where(array("attendeeID" => $this->input->post("inputAttendeeID")))->num_rows()>0){
						$data = array(
						"attendeeID" => $this->input->post("inputAttendeeID")
						);
						$this->attendees->delete($data);
						echo json_encode(array(
								"success" => true,
								"responseMsg" => "Attendee has been removed!"
							)
						);
				}
				else{
						echo json_encode(array(
								"success" => false,
								"responseMsg" => "No such Attendee exists!"
							)
						);
					}
				}
				else{
					show_404();
				}
			}
			else{
				show_404();
			}
		}
		
		
	}

?>
