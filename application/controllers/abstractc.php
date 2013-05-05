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
		 * Handles creation of an Abstract and Uploading of File.
		 * @TODO Need to implement Foreign Key checks.
		**/
		
		public function create(){
			if($_SERVER['REQUEST_METHOD'] == "POST"){
				if($this->session->userdata("loggedin") == true){
					$exists = $this->abstracts->select_where(array("abstractID"), array("attendeeID" => $this->session->userdata("id"), "conferenceID" => $this->session->userdata("conferenceID")));
					if($exists->num_rows()){
						echo json_encode(array("success" => false, "message" => "You have already submitted an Abstract for this Conference"));
					}
					else{
						$abstractTitle = $this->input->post("inputAbstractTitle");
						//str_replace('"',"'",$text);
						$abstractContent = '{"methods": "'.str_replace('"',"'",$this->input->post('inputAbstractMethods')).'", "aim": "'.str_replace('"',"'",$this->input->post('inputAbstractAim')).'", "results": "'.str_replace('"',"'",$this->input->post('inputAbstractResults')).'", "conservation": "'.str_replace('"',"'",$this->input->post('inputAbstractConservation')).'"}';
						$file = "inputAbstractImage";
						$config['upload_path'] = $this->config->item("upload_path");
				 		$config['allowed_types'] = $this->config->item("allowed_types");
						$config['max_size']	= $this->config->item("max_size");
						$this->load->library('upload', $config);
						if($this->upload->do_upload($file)){
							$a = $this->upload->data();
							$abstractContent = str_replace("\n\n", "<br><br>", $abstractContent);
							$abstractContent = str_replace("\n", "", $abstractContent);
							$data = array(
							"abstractTitle" => $abstractTitle,
							"abstractContent" => $abstractContent,
							"conferenceID" => $this->session->userdata("conferenceID"),
							"attendeeID" => $this->session->userdata("id"),
							"attendeePreference" => $this->input->post("inputAbstractPreference"),
							"bursary" => '{"bursary_for": "'.$this->input->post("inputBursary_For").'", "bursary_why": "'.$this->input->post("inputBursary_Why").'", "accomodation":"'.$this->input->post("inputAbstractAccommodation").'""}',
							"abstractAuthors" => $this->input->post("inputAbstractAuthors"),
							"abstractImageFolder" => $a['file_name']
						);
							$this->abstracts->insert($data);
							echo json_encode(array("success" => true, "abstractID" => $this->db->insert_id()));
						}
						else{
							echo json_encode(array("success" => false));
						}
					}
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
			 			$rids = array($row->reviewer1, $row->reviewer2, $row->reviewer3);
			 			$reviewers = array();
			 			for($i=0;$i<3;$i++){
			 				$rev = $r->select_where(array("reviewerFirstName", "reviewerLastName"), array("reviewerID" => $rids[$i]));
			 				if($rev->num_rows > 0){
			 					foreach($rev->result() as $revs){
			 						$reviewers[] = array(
			 							"reviewerID" => $rids[$i],
			 							"reviewerFirstName" => $revs->reviewerFirstName,
			 							"reviewerLastName" => $revs->reviewerLastName
			 						);
			 					}
			 				}
			 				else{
			 					$reviewers[] = array(
			 							"reviewerID" => "",
			 							"reviewerFirstName" => "",
			 							"reviewerLastName" => ""
			 						);
			 				}
			 			}
			 			$q2 = $s->view_avg($row->abstractID); # Result Set that holds avg. score of an abstract.
			 			$q3 = $s->select_where(array("recommendation"), array("abstractID" => $aid));
			 			$result[]=array(
			 				"abstractID" => $row->abstractID,
			 				"abstractTitle" => $row->abstractTitle,
			 				"abstractImageFolder" => $row->abstractImageFolder,
			 				"attendeeFirstName" => $row->attendeeFirstName,
			 				"attendeeLastName" => $row->attendeeLastName,
			 				"reviewers" => $reviewers,
			 				"score" => $q2,
			 				"recommendations" => $q3,
			 				"approved" => $row->approved
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
			 			$rids = array($row->reviewer1, $row->reviewer2, $row->reviewer3);
			 			$q2 = $s->view_avg($row->abstractID); # Result Set that holds avg. score of an abstract.
			 			$r3 = $c->select_where_reviewer(array("commentID", "commentContent", "commentType", "reviewerID"), array("abstractID" => $aid));
			 			$detailed_score = array();
			 			$reviewers = array();
			 			$reviewers_list = array();
			 			for($i=0;$i<3;$i++){
			 				$q5 = $s->view_where(array("abstractID" => $this->uri->segment(2), "reviewerID" => $rids[$i]));
			 				$rev2 = $r->select_where(array("reviewerFirstName", "reviewerLastName"), array("reviewerID" => $rids[$i]));
				 				if($rev2->num_rows > 0){
				 					foreach($rev2->result() as $revs){
				 						$reviewers_list[] = array(
				 							"reviewerFirstName" => $revs->reviewerFirstName,
				 							"reviewerLastName" => $revs->reviewerLastName
				 						);
				 					}
				 				}
			 				if($q5->num_rows() > 0){
			 					$reviewers = array();
			 					$rev = $r->select_where(array("reviewerFirstName", "reviewerLastName"), array("reviewerID" => $rids[$i]));
				 				if($rev->num_rows > 0){
				 					foreach($rev->result() as $revs){
				 						$reviewers[] = array(
				 							"reviewerFirstName" => $revs->reviewerFirstName,
				 							"reviewerLastName" => $revs->reviewerLastName
				 						);
				 					}
				 				}
			 					$score_detail = $q5->result();
			 					$detailed_score[] = array(
			 						"scoreID" => $score_detail[0]->scoreID,
			 						"reviewerID" => $score_detail[0]->reviewerID,
			 						"score" => $score_detail[0]->score,
			 						"recommendation" => $score_detail[0]->recommendation,
			 						"reviewer" => $reviewers
			 					);
			 				}
			 				#echo json_encode($q5->result());
			 			}
			 			$result[]=array(
			 				"abstractID" => $row->abstractID,
			 				"abstractTitle" => $row->abstractTitle,
			 				"abstractContent" => $row->abstractContent,
			 				"abstractImageFolder" => base_url().$this->config->item("upload_path").$row->abstractImageFolder,
			 				"attendeeFirstName" => $row->attendeeFirstName,
			 				"attendeeLastName" => $row->attendeeLastName,
			 				"reviewers" => $reviewers_list,
			 				"score" => $q2,
			 				"comments" => $r3,
			 				"detailed_scores" => $detailed_score,
			 				"approved" => $row->approved,
			 				"bursary" => $row->bursary,
			 				"abstractAuthors" => $row->abstractAuthors
			 			);
			 		}
			 		echo json_encode($result);
		 		}
		 		else{
		 			echo json_encode(array());
		 		}
	 		}
	 		else{
	 			$a = $this->abstracts->view_where($this->uri->segment(2), $this->session->userdata("conferenceID"));
		 		$n = $a->num_rows();
		 		$aid = $this->uri->segment(2);
		 		if($n>0){
		 			$q = $a->result();
			 		foreach($q as $row){
			 			$result[]=array(
			 				"abstractID" => $row->abstractID,
			 				"abstractTitle" => $row->abstractTitle,
			 				"abstractContent" => $row->abstractContent,
			 				"abstractImageFolder" => base_url().$this->config->item("upload_path").$row->abstractImageFolder,
			 				"attendeeFirstName" => $row->attendeeFirstName,
			 				"attendeeLastName" => $row->attendeeLastName,
			 				"abstractAuthors" => $row->abstractAuthors,
			 				"bursary" => $row->bursary,
			 				"approved" => $row->approved
			 			);
			 		}
			 		echo json_encode($result);
		 		}
		 		else{
		 			echo json_encode(array());
		 		}
	 			// show_404();
	 		}
		}
		
	 	
	 	/**
			*	Handles edit/update of an Abstract.
		**/
	
		public function update(){
				if($_SERVER['REQUEST_METHOD'] == "POST"){
					if($this->session->userdata("adminLoggedin") == true){
						$abstractTitle = $this->input->post("inputAbstractTitle");
						$abstractContent = '{"methods": "'.$this->input->post('inputAbstractMethods').'", "aim": "'.$this->input->post('inputAbstractAim').'", "results": "'.$this->input->post('inputAbstractResults').'", "conservation": "'.$this->input->post('inputAbstractConservation').'"}';
						$data = array(
						"abstractTitle" => $abstractTitle,
						"abstractContent" => $abstractContent
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
	 		*	Handles addition of Bursary.
	 	**/
	 	
	 	public function add_bursary(){
	 		if($this->session->userdata("loggedin") == true){
	 			$abstractID = $this->input->post("inputAbstractID");
	 			$q = $this->abstracts->select_where(array("attendeeID", "bursary"), array("abstractID" => $abstractID));
	 			if($q->num_rows > 0){
	 				$r = $q->result();
	 				if($r[0]->attendeeID == $this->session->userdata("id")){
	 					if($r[0]->bursary == null || $r[0]->bursary == ""){
		 					$data = array(
				 				"bursary" => '{"bursary_for": "'.$this->input->post("inputBursary_For").'", "bursary_why": "'.$this->input->post("inputBursary_Why").'"}'
				 			);
				 			$where = array(
				 				"abstractID" => $abstractID
				 			);
				 			$this->abstracts->update($data, $where);
				 			echo json_encode(array("success" => true));
		 				}
		 				else{
		 					echo json_encode(array("success" => false, "message" => "Bursary information has already been submitted."));
		 				}
	 				}
	 				else{
	 					show_404();
	 				}
	 			}
	 		}
	 	}
	 	
	 	
	 	/**
			*	Handles assignment of an Abstract.
			* @TODO: Need to implement Foreign Key checks.
		**/
		
		public function assign(){
			if($_SERVER['REQUEST_METHOD'] == "POST"){
				if($this->session->userdata("adminLoggedin") == true){
				$abstractID = $this->input->post("abstractID");
				$reviewerID = $this->input->post("reviewerID");
				$reviewername = $this->input->post("reviewername");
				$data = array(
					$reviewername => $reviewerID,
				);
				$where = array(
					"abstractID" => $abstractID
				);
				//echo $abstractID.", ".$reviewerID." and ".$reviewername;
				$this->abstracts->update($data, $where);
				require_once(APPPATH."controllers/reviewer.php");
				$r = new Reviewer();
				$q = $r->select_where(array("reviewerFirstName", "reviewerLastName"), array("reviewerID" => $reviewerID));
				$row = $q->result();
				echo json_encode(
					array(
						"success" => true,
						"reviewerFirstName" => $row[0]->reviewerFirstName,
						"reviewerLastName" => $row[0]->reviewerLastName,
						"reviewerID" => $reviewerID
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
			*	Handles unassignment of a Reviewer for a particular Abstract.
		**/
		
		public function unassign(){
			if($_SERVER['REQUEST_METHOD'] == "POST"){
				if($this->session->userdata("adminLoggedin") == true){
					$reviewerID = $this->input->post("inputReviewerID");
					$abstractID = $this->input->post("inputAbstractID");
					require_once(APPPATH."controllers/score.php");
					$s = new Score();
					$data2 = array(
						"reviewer1", "reviewer2", "reviewer3"
					);
					$where2 = array(
						"abstractID" => $abstractID
					);
					$q = $this->abstracts->select_where($data2, $where2);
					if($q->num_rows() > 0){
						foreach($q->result() as $r){
							if($r->reviewer1 == $reviewerID){
								$flag = 1;
								$data = array(
									"reviewer1" => NULL
								);
							}
							else if($r->reviewer2 == $reviewerID){
								$flag = 1;
								$data = array(
									"reviewer2" => NULL
								);
							}
							else if($r->reviewer3 == $reviewerID){
								$flag = 1;
								$data = array(
									"reviewer3" => NULL
								);
							}
							else{
								$flag = 2;
								$error = "It doesn't exist!";
							}
						}
						if($flag == 1){
							$this->abstracts->update($data, array("abstractID" => $abstractID));
							$s->delete(
								array(
									"abstractID" => $abstractID,
									"reviewerID" => $reviewerID
								)
							);
							echo json_encode(array(
								"success" => true
							));
						}
						if($flag == 2){
							echo json_encode(array(
								"success" => false,
								"error" => $error
							));
						}
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
			* Handles select_where of an Abstract.
		**/
		
		public function select_where($data, $where, $or=0){
			if($or==0)
				return $this->abstracts->select_where($data, $where);
			else
				return $this->abstracts->select_where_plain($data, $where);
		}
	 	
	 	
	 	/**
	 		*	Handles Updating of a Message by an Admin.
	 	*/
	 	
	 	public function update_message(){
	 		if($this->session->userdata("adminLoggedin") == true && $_SERVER['REQUEST_METHOD'] == "POST"){
	 			$data = array(
	 				"message" => $this->input->post("inputAbstractMessage")
	 			);
	 			$where = array(
	 				"abstractID" => $this->input->post("inputAbstractID")
	 			);
	 			$this->abstracts->update($data, $where);
	 			echo json_encode(array("success" => true, "message" => $this->input->post("inputAbstractMessage")));
	 		}
	 		else{
	 			show_404();
	 		}
	 	}
	 	
	 	
	 	/**
	 		*	Approve an Abstract.
	 	**/
	 	
	 	public function approve(){
	 		if($this->session->userdata("adminLoggedin") == true && $_SERVER['REQUEST_METHOD'] == "POST"){
	 			$recommendation_admin = $this->input->post("recommendation_admin");
	 			if($recommendation_admin == 3)
	 				$recommendation_admin = NULL;
	 			$data = array(
	 				"approved" => $recommendation_admin
	 			);
	 			$where = array(
	 				"abstractID" => $this->input->post("abstractID")
	 			);
	 			$this->abstracts->update($data, $where);
	 			echo json_encode(array("success" => true, "message" => "Abstract approved"));
	 		}
	 		else{
	 			show_404();
	 		}
	 	}
	 	
	 	
	 	/**
	 		*	Schedule an Abstract.
	 	**/
	 	
	 	public function schedule(){
	 		if($this->session->userdata("adminLoggedin") == true && $_SERVER['REQUEST_METHOD'] == "POST"){
	 			$abstractID = $this->uri->segment(3);
	 			$schedule = $this->input->post("inputScheduled");
	 			$this->abstracts->update(
	 				array(
	 					"scheduled" => $schedule
	 				),
	 				array(
	 					"abstractID" => $abstractID
	 				)
	 			);
	 			echo json_encode(array("success" => true));
	 		}
	 		else{
	 			show_404();
	 		}
	 	}
	 	
	 	
	 	/**
	 		*	Publish Abstracts that are approved.
	 	**/
	 	
	 	public function publish(){
	 		if($this->session->userdata("adminLoggedin") == true){
	 			$data = array(
	 				"active" => 1
	 			);
	 			$where = array(
	 				"approved >" => 0,
	 				"conferenceID" => $this->session->userdata("cur_conference")
	 			);
	 			$this->abstracts->update($data, $where);
	 			echo json_encode(array("success" => true, "message" => "Approved abstracts have been published"));
	 		}
	 		else{
	 			show_404();
	 		}
	 	}
	 	
	 	
	 	/**
	 		*	Email Attendees who's Abstracts have been selected.
	 	**/
	 	
	 	public function alert_selected_attendees(){
	 		if($this->session->userdata("adminLoggedin") == true && $_SERVER['REQUEST_METHOD'] == "POST"){
	 			$this->load->library('email');
	 			$sel_attendees = $this->abstracts->select_where(array("attendeeID"), array("approved >" => 0, "conferenceID" => $this->session->userdata("cur_conference")));
	 			if($sel_attendees->num_rows() > 0){
	 				require_once(APPPATH."controllers/attendee.php");
	 				$abs = new Attendee();
	 				$list = array();
	 				foreach($sel_attendees->result() as $a){
	 					$aEmail = $abs->attendee_data(array("attendeeEmail"), array("attendeeID" => $a->attendeeID));
	 					foreach($aEmail->result() as $sel_att)
		 					array_push($list, $sel_att->attendeeEmail);
	 				}
	 				$this->email->set_mailtype("html");
          $this->email->from($this->config->item('service_email'), 'SCCS Alert');
	 				$this->email->to($list);
	 				$this->email->subject($this->input->post("inputEmailSubject"));
	 				$this->email->message($this->input->post("inputEmailMessage"));
	 				$this->email->send();
	 				echo json_encode(array("success" => true, "message" => "Email has been sent"));
	 			}
	 			else{
	 				echo json_encode(array("success" => false, "message" => "No Attendees have been selected for a talk/poster yet."));
	 			}
	 		}
	 		else{
	 			show_404();
	 		}
	 	}
	 	
	 	
	 	/**
	 		*	Email Attendees who's Abstracts have been rejected.
	 	**/
	 	
	 	public function alert_rejected_attendees(){
	 		if($this->session->userdata("adminLoggedin") == true && $_SERVER['REQUEST_METHOD'] == "POST"){
	 			$this->load->library('email');
	 			$sel_attendees = $this->abstracts->select_where(array("attendeeID"), array("approved" => NULL, "conferenceID" => $this->session->userdata("cur_conference")));
	 			if($sel_attendees->num_rows() > 0){
	 				require_once(APPPATH."controllers/attendee.php");
	 				$abs = new Attendee();
	 				$list = array();
	 				foreach($sel_attendees->result() as $a){
	 					$aEmail = $abs->attendee_data(array("attendeeEmail"), array("attendeeID" => $a->attendeeID));
	 					foreach($aEmail->result() as $rej_att)
		 					array_push($list, $rej_att->attendeeEmail);
	 				}
	 				$this->email->set_mailtype("html");
          $this->email->from($this->config->item('service_email'), 'SCCS Alert');
	 				$this->email->to($list);
	 				$this->email->subject($this->input->post("inputEmailSubject"));
	 				$this->email->message($this->input->post("inputEmailMessage"));
	 				$this->email->send();
	 				echo json_encode(array("success" => true, "message" => "Email has been sent"));
	 			}
	 			else{
	 				echo json_encode(array("success" => false, "message" => "Either there are no abstracts submitted or all the abstracts have been approved."));
	 			}
	 		}
	 		else{
	 			show_404();
	 		}
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
