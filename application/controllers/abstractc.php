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
					$dir =  $this->encrypt->sha1($this->session->userdata("email").time().$this->encrypt->sha1($this->config->item("password_salt")));
					$data = array(
						"abstractTitle" => $this->input->post("inputAbstractTitle"),
						"abstractContent" => $this->input->post("inputAbstractContent"),
						"conferenceID" => $this->input->post("inputConferenceID"),
						"attendeeID" => $this->input->post("inputAttendeeID"),
						"abstractImageFolder" => $dir
					);
					$this->abstracts->insert($data);
					mkdir($this->config->item("upload_path").$dir); 				# Creates image directory.
					chmod($this->config->item("upload_path").$dir, 0777);		# Changes permission to 0777.
					echo json_encode(
						array(
							"success" => true,
							"abstractID" => $this->db->insert_id(),
							"abstractImageFolder" => $this->config->item("upload_path").$dir
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
		**/
		
		public function upload(){
			if($_SERVER['REQUEST_METHOD'] == "POST"){
				if($this->session->userdata("loggedin") == true){
					$q = $this->abstracts->select_where(
						array(
							"abstractImageFolder"
						),
						array(
							"abstractID" => $this->input->post("inputAbstractID")
						)
					);
					$dir = $q[0]->abstractImageFolder; #Holds the abstractImageFolder sha1.
					$config['upload_path'] = $this->config->item("upload_path").$dir;
			 	  $config['allowed_types'] = $this->config->item("allowed_types");
					$config['max_size']	= $this->config->item("max_size");
					$this->load->library('upload', $config);
					$file = "myFile";
					if ( ! $this->upload->do_upload($file))
					{
						$error = array('error' => $this->upload->display_errors(), "success" => false);
						echo json_encode($error);
					}
					else
					{
						$success = array('upload_data' => $this->upload->data(), "success" => true);
				
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
