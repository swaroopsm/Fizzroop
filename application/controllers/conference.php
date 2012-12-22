<?php
	
	class Conference extends CI_Controller{
		
		public function create(){
			$this->load->model("conferences");
			$method = $_SERVER['REQUEST_METHOD'];
			if($method=="POST"){
				$data = array(
					"venue" => $_POST['inputVenue'],
					"year" => $_POST['inputYear'],
					"startDate" => $_POST['inputStartDate'],
					"endDate" => $_POST['inputEndDate']
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
