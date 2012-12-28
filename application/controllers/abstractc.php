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
	 
	}

?>
