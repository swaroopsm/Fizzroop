<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	
	class Conference extends CI_Controller{
		
		public function __construct(){
			parent::__construct();
			$this->load->model("conferences");
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
		
	}
	
?>
