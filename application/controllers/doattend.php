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
			$this->load->model("attendees");
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
							"attendeeTicket" => $p["Ticket_Number"]
						);
						//echo json_encode($data);
						$this->attendees->insert($data);
					}
				}
				else{
					require_once(APPPATH."controllers/attendee.php");
					$a = new Attendee();
					$res = $a->latest_ticket();
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
		
	}

?>
