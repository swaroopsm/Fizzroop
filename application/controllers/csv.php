<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Csv extends CI_Controller{
		
		/**
			*	Constructor function.
		**/
		
		public function __construct(){
			parent::__construct();
			$this->load->library("session");
			$this->load->library("uri");
			$this->load->dbutil();
			$this->load->helper('file');
			$this->load->helper('download');
			$this->load->model("attendees");
		}
		
		
		/**
			*	CSV generator function.
		**/
		
		public function generator(){
			if($this->session->userdata("adminLoggedin") == true){
				$model = $this->uri->segment(2);
				$q = $this->$model->export_csv(array("conferenceID" => $this->session->userdata("conferenceID")));
				write_file($this->config->item("csv_path").$model.'.csv', $this->dbutil->csv_from_result($q));
				$data = file_get_contents($this->config->item("csv_path").$model.'.csv'); // Read the file's contents
				$name = "$model.csv";
				force_download($name, $data);
			}
			else{
				show_404();
			}
		}
		
		
	}

?>
