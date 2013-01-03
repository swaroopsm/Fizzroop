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
		 		$a = $this->abstracts->view($this->session->userdata("conferenceID"));
		 		$n = $a->num_rows();
		 		if($n>0){
		 			$q = $a->result();
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
		 			echo json_encode(array());
		 		}
	 		}
	 		else{
	 			show_404();
	 		}
	 	}
	 	
	 	
	 	
	 	
		/**
			* Handles viewing of a particular Abstract.
		**/
		
		public function view_where(){
			if($this->session->userdata("adminLoggedin") == true){
	 			require_once(APPPATH."controllers/score.php");
		 		require_once(APPPATH."controllers/reviewer.php");
		 		require_once(APPPATH."controllers/comment.php");
		 		$a = $this->abstracts->view_where($this->uri->segment(2), $this->session->userdata("conferenceID"));
		 		$n = $a->num_rows();
		 		$aid = $this->uri->segment(2);
		 		
		 		if($n>0){
		 			$q = $a->result();
		 			$s = new Score();
			 		$r = new Reviewer();
			 		$c = new Comment();
			 		foreach($q as $row){
			 			$aid = $row->abstractID;
			 			$q2 = $s->view_avg($row->abstractID); # Result Set that holds avg. score of an abstract.
			 			$q3 = $s->select_where(array("recommendation"), array("abstractID" => $aid));
			 			$r2 = $r->select_where(array("reviewerFirstName", "reviewerLastName"), array("abstractID" => $aid));
			 			$r3 = $c->select_where_reviewer(array("commentContent", "commentType", "reviewerID"), array("abstractID" => $aid));
			 			$result[]=array(
			 				"abstractID" => $row->abstractID,
			 				"abstractTitle" => $row->abstractTitle,
			 				"abstractContent" => $row->abstractContent, // Fizz added to get abstract content
			 				"abstractImageFolder" => $row->abstractImageFolder,
			 				"attendeeFirstName" => $row->attendeeFirstName,
			 				"attendeeLastName" => $row->attendeeLastName,
			 				"reviewers" => $r2,
			 				"score" => $q2[0]->score,
			 				"recommendations" => $q3,
			 				"comments" => $r3
			 			);
			 		}
			 		echo json_encode($result);
		 		}
		 		else{
		 			echo json_encode(array());
		 		}
	 		}
	 		else{
	 			show_404();
	 		}
		}
		
	 	
	 	/**
			*	Handles edit/update of an Abstract.
		**/
	
		public function update(){
				if($_SERVER['REQUEST_METHOD'] == "POST"){
					if($this->session->userdata("loggedin") == true || $this->session->userdata("adminLoggedin") == true){
						$data = array(
						"abstractTitle" => $this->input->post("inputAbstractTitle"),
						"abstractContent" => $this->input->post("inputAbstractContent")
					);
						$where = array(
							"abstractID" => $this->input->post("inputAbstractID")
						);
						$this->abstracts->update($data, $where);
						echo json_encode(array(
								"success" => true,
								"abstractID" => $this->input->post("inputAbstractID")
							)
						);
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
			* Handles select_where of an Abstract.
		**/
		
		public function select_where($data, $where){
			return $this->abstracts->select_where($data, $where);
		}
	 	
	 	
	 	/**
		 * Handles deletion of an Abstract.
		**/
		
		public function delete(){
			if($_SERVER['REQUEST_METHOD'] == "POST"){
				if($this->session->userdata("loggedin") ==true && $this->session->userdata("adminLoggedin") == true){
					$q = $this->abstracts->view_where(array("abstractID" => $this->input->post("inputAbstractID")));
					if($q->num_rows()>0){
						$r = $q->result();
						$dir = $r[0]->abstractImageFolder;
						$data = array(
						"abstractID" => $this->input->post("inputAbstractID")
						);
						$this->abstracts->delete($data);
						$this->rrmdir($this->config->item("upload_path").$dir);
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
		
		/**
			* Handles a single Abstract Image deletion.
		**/
		
		public function delete_abstractImage(){
			if($_SERVER['REQUEST_METHOD'] == "POST"){
				if($this->session->userdata("loggedin") ==true && $this->session->userdata("adminLoggedin") == true){
					$image = $this->config->item("upload_path").$this->input->post("inputAbstractImage");
					if(file_exists($image)){
						if(unlink($image)){
							echo json_encode(
								array(
									"success" => true
								)
							);
						}
						else{
							echo json_encode(
								array(
									"success" => false,
									"error" => "An error occurred."
								)
							);
						}
					}
					else{
						echo json_encode(
							array(
								"success" => false,
								"error" => "File does not exist!"
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
		
		
		/**
			* Deletes all images from an abstractImageFolder.
		**/
		
		public function delete_allAbstractImage(){
			if($_SERVER['REQUEST_METHOD'] == "POST"){
				if($this->session->userdata("loggedin") ==true && $this->session->userdata("adminLoggedin") == true){
					$dir = $this->config->item("upload_path").$this->input->post("inputAbstractImageFolder");
					$count = 0;
					if ($handle = opendir($dir)) {
							while (false !== ($file = readdir($handle))){
									if ('.' === $file) continue;
									if ('..' === $file) continue;
									$to_remove = $dir."/".$file;
									unlink($to_remove);
									$count+=1;
							}
							closedir($handle);
					}
					echo json_encode(
						array(
							"success" => true,
							"count" => $count
						)
					);
				}
			}
		}
		
		
		/**
			* Handles deletion of abstractImageFolder and it's sub-files/sub-directories.
		**/
		
		private function rrmdir($dir) { 
		 if (is_dir($dir)) { 
		   $objects = scandir($dir); 
		   foreach ($objects as $object) { 
		     if ($object != "." && $object != "..") { 
		       if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object); 
		     } 
		   } 
		   reset($objects); 
		   rmdir($dir); 
		 } 
	 	}
		
	}

?>
