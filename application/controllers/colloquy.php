<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Colloquy extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library("session");
		$this->load->library("encrypt");
		$this->load->model("colloquy_model");
		$this->load->library("uri");
	}

	// Load up the home page
	public function index()
	{
		// need to pass the following data:
		// plenaries and workshops from the latest year

		$confstuff = $this->colloquy_model->get_timers(26);
		$data['timers'] = $confstuff['timer'];
		$workshops = $this->colloquy_model->get_four_page_by_type(3);
		$plens = $this->colloquy_model->get_four_page_by_type(2);

		$j = 0;
		foreach ($workshops as $w) {
			# code...
			
			$i = $this->colloquy_model->get_image_by_page_id($w['pageID']);
			$workshops[$j]['imagepath'] = $i['image'];
			$j++;
		}

		$k = 0;
		foreach ($plens as $w) {
			# code...
			
			$i = $this->colloquy_model->get_image_by_page_id($w['pageID']);
			$plens[$k]['imagepath'] = $i['image'];
			$k++;
		}


		$data['workshops'] = $workshops;
		$data['plenaries'] = $plens;

		// timers from latest year

		$this->load->view('public/header');
		$this->load->view('public/home',$data);
		$this->load->view('public/footer');
	}

	// Plenaries workshops specialSessions and pages should be visible on the url : colloquy/viewpage/$id

	public function viewpage($id) {
		$data['singlepage'] = $this->colloquy_model->get_page_by_id($id);
		$data['imagepath'] = $this->colloquy_model->get_image_by_page_id($id);
		$this->load->view('public/header');
		$this->load->view('public/page',$data);
		$this->load->view('public/footer');

	}

	public function viewtype($id) {
		$listofpages = $this->colloquy_model->get_page_by_type($id);
		$j = 0;
		foreach ($listofpages as $w) {
			$i = $this->colloquy_model->get_image_by_page_id($w['pageID']);
			$listofpages[$j]['imagepath'] = $i['image'];
			$j++;
		}
		$data['listofpages'] = $listofpages;

		$this->load->view('public/header');
		$this->load->view('public/inner',$data);
		$this->load->view('public/footer');
	}

	// Approved talks and posters should be visible on the url : colloquy/viewabstract/$id

	public function viewabstracts() {
		$allabstracts = $this->colloquy_model->get_abstracts();
		$data['allabstracts'] = $allabstracts;
		
			$this->load->view('public/header');
			// print_r($allabstracts);
			$this->load->view('public/abstracts');
			$this->load->view('public/footer');
	}
	
	
	// Forgot Password View.
	
	public function forgot(){
		$data['page_title'] = "Forgot Password";
		$data['message'] = $this->session->flashdata('message');
		$this->load->view("forgot", $data);
	}


}

/* End of file public.php */
/* Location: ./application/controllers/public.php */
