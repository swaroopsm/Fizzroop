<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Colloquy extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library("session");
		$this->load->library("encrypt");
		$this->load->model("abstracts");
		$this->load->library("uri");
	}

	// Load up the home page
	public function index()
	{
		// need to pass the following data:
		// plenaries from the latest year

		// workshops from the latest year

		// timers from latest year

		$this->load->view('public/header');
		$this->load->view('public/home');
		$this->load->view('public/footer');
	}

	// Plenaries should be visible on the url : colloquy/plenaries/$year/$id

	// Workshops should be visible on the url : colloquy/workshops/$year/$id

	// Approved talks and posters should be visible on the url : colloquy/abstracts/$year/$id

	// Special Sessions should be visible on the url: colloquy/special/$year/$id

}

/* End of file public.php */
/* Location: ./application/controllers/public.php */