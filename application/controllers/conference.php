<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	
	class Conference extends CI_Controller{
		
		public function __construct(){
			parent::__construct();
			$this->load->model("conferences");
			$this->load->library("uri");
		}
		
		public function create(){
			$method = $_SERVER['REQUEST_METHOD'];
			if($method=="POST"){
				$data = array(
					"venue" => trim($_POST['inputVenue']),
					"year" => trim($_POST['inputYear']),
					"startDate" => trim($_POST['inputStartDate']),
					"endDate" => trim($_POST['inputEndDate'])
				);
				if($this->conferences->insert($data))
					echo json_encode(array("success" => true));
				else
					echo json_encode(array("success" => false));
			}
			else{
				show_404();
			}
		}
		
		public function update(){
			if($_SERVER['REQUEST_METHOD'] == "POST"){
				$data = array(
					"year" => $this->input->post("inputYear"),
					"venue" => $this->input->post("inputVenue"),
					"startDate" => $this->input->post("inputStartDate"),
					"endDate" => $this->input->post("inputEndDate"),
					"visibility" => $this->input->post("inputVisibility")
				);
				$where = array(
					"conferenceID" => $this->input->post("inputConferenceID")
				);
				$this->conferences->update($data, $where);
				echo json_encode(array(
						"success" => true,
						"conferenceID" => $this->input->post("inputConferenceID")
					)
				);
			}
			else{
				show_404();
			}
		}
		
		public function publish(){
			if($_SERVER['REQUEST_METHOD'] == "POST"){
				$data = array(
						"visibility" => 1
					);
					$where = array(
						"conferenceID" => $this->input->post("inputConferenceID")
					);
					$this->conferences->update($data, $where);
					echo json_encode(array(
							"success" => true,
							"conferenceID" => $this->input->post("inputConferenceID")
						)
					);
				}
				else{
					show_404();
				}
		}
		
		public function view_where(){
			$data = array(
				"conferenceID" => $this->uri->segment(2)
			);
			$q = $this->conferences->view_where($data);
			echo json_encode($q->result());
		}
		
		public function view(){
			$q = $this->conferences->view();
			echo json_encode($q->result());
		}
		
		public function get_order_limit($data, $order, $ordering,$limit){
			return $this->conferences->get_order_limit($data, $order, $ordering, $limit);
		}
		
		
		public function select_where($data, $where){
			return $this->conferences->select_where($data, $where);
		}	
		
		public function get_current_conf(){
			return $this->conferences->get_order_limit(array("conferenceID"), "conferenceID", "DESC", "1");
		}
		
		
	}
	
?>
