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
		
		
		/**
			* Handles uploading of a file.
			* @TODO Need to improve the clarity, think of a way to store it in the DB.
		**/
		
		public function upload(){
			if($_SERVER['REQUEST_METHOD'] == "POST"){
				if($this->session->userdata("loggedin") == true){
					$config['upload_path'] = $this->config->item("upload_path");
			 	  $config['allowed_types'] = $this->config->item("allowed_types");
					$config['max_size']	= $this->config->item("max_size");
					$config['file_name'] = $this->encrypt->sha1($this->session->userdata("email").time().$this->encrypt->sha1($this->config->item("password_salt")));
					$this->load->library('upload', $config);
					$file = "myFile";
					if ( ! $this->upload->do_upload($file))
					{
						$error = array('error' => $this->upload->display_errors());
						echo json_encode($error);
					}
					else
					{
						$success = array('upload_data' => $this->upload->data());
				
						echo json_encode($success);
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
	 
	 
	  /**
	  	* Handles the BIG ABSTRACTS table.
	  **/
	 	public function view(){
	 		if($this->session->userdata("adminLoggedin") == true){
	 			require_once(APPPATH."controllers/score.php");
		 		require_once(APPPATH."controllers/reviewer.php");
		 		$q = $this->abstracts->view();
		 		$s = new Score();
		 		$r = new Reviewer();
		 		foreach($q as $row){
		 			$aid = $row->abstractID;
		 			$q2 = $s->view_avg($row->abstractID); # Result Set that holds avg. score of an abstract.
		 			$q3 = $s->select_where(array("recommendation"), array("abstractID" => $aid));
		 			$r2 = $r->select_where(array("reviewerFirstName", "reviewerLastName"), array("abstractID" => $aid));
		 			$result[]=array(
		 				"abstractID" => $row->abstractID,
		 				"abstractTitle" => $row->abstractTitle,
		 				"abstractImageFolder" => $row->abstractImageFolder,
		 				"attendeeFirstName" => $row->attendeeFirstName,
		 				"attendeeLastName" => $row->attendeeLastName,
		 				"reviewers" => $r2,
		 				"score" => $q2[0]->score,
		 				"recommendations" => $q3
		 			);
		 		}
		 		echo json_encode($result);
	 		}
	 		else{
	 			show_404();
	 		}
	 	}
	 	
	 	
	 	/**
		 * Handles deletion of a Abstract.
		**/
		
		public function delete(){
			if($_SERVER['REQUEST_METHOD'] == "POST"){
				if($this->session->userdata("loggedin") ==true && $this->session->userdata("adminLoggedin") == true){
					if($this->abstracts->view_where(array("abstractID" => $this->input->post("inputAbstractID")))->num_rows()>0){
						$data = array(
						"abstractID" => $this->input->post("inputAbstractID")
						);
						$this->abstracts->delete($data);
						echo json_encode(array(
								"success" => true,
								"responseMsg" => "Abstract has been removed!"
							)
						);
				}
				else{
						echo json_encode(array(
								"success" => false,
								"responseMsg" => "No such Abstract exists!"
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
