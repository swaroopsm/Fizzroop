<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Image extends CI_Controller{
		
		/**
			*	Constructor function.
		*/
		
		public function __construct(){
			parent::__construct();
			$this->load->library("session");
			$this->load->model("images");
		}
		
		
		/**
			* Handles uploading of an Image.
		*/
		
		private function image_upload($file){
			$config['upload_path'] = $this->config->item("upload_path");
			$config['allowed_types'] = $this->config->item("allowed_types");
			$config['max_size']	= $this->config->item("max_size");
			$this->load->library('upload', $config);
			if($this->upload->do_upload($file)){
				$a = $this->upload->data();
				return array("success" => 1, "data" => $a);
			}
			else{
				return array("success" => 0);
			}
		}
		
		
		/**
			*	Handles creation of an Image entry.
		**/
		
		public function create(){
			if($this->session->userdata("adminLoggedin") == true && $_SERVER['REQUEST_METHOD'] == "POST"){
				$pageId = $this->input->post("inputPageID");
				$file = "inputPageImage";
				$img = $this->image_upload($file);
				if($img['success']){
					$filename = $img['data']['file_name'];
					$this->images->insert(
						array(
							"image" => $filename,
							"pageID" => $this->input->post("inputPageID")
						)
					);
					echo json_encode(
						array(
							"success" => true,
							"image" => $this->config->item("upload_path").$filename
						)
					);
				}
			}
			else{
				show_404();
			}
		}
		
		
		/**
			*	Returns all images for a particular Page.
		*/
		
		public function view_page_images($pageID){
			return $this->images->view_where(array("pageID" => $pageID));
		}
		
		
		/**
			*	Returns all Images.
		*/
		
		public function view(){
			if($this->session->userdata("adminLoggedin") == true){
				$q = $this->images->view();
				echo json_encode($q->result());
			}
			else{
				show_404();
			}
		}
		
		
		/**
			*	Returns a specific Image.
		*/
		
		public function view_where(){
			$id = $this->uri->segment(2);
			$q = $this->images->view_where(array("imageID" => $id));
			echo json_encode($q->result());
		}
		
		
		/**
			*	Deletes an Image.
		*/
		
		public function delete(){
			$id = $this->input->post("inputImageID");
			$q = $this->images->view_where(array("imageID" => $id));
			if($q->num_rows() > 0){
				$r = $q->result();
				$image = $r[0]->image;
				unlink($this->config->item("upload_path").$image);
				$this->images->delete(array("imageID" => $id));
				echo json_encode(array("success" => true));
			}
		}
		
	}

?>
