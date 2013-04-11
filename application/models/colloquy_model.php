<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Colloquy_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		
	}

	public function get_pages(){
		$q = $this->db->get("pages");
		return $q->result_array();
	}

	public function get_page_by_type($pageType){
		$query = $this->db->get_where('pages', array('pageType' => $pageType));
		foreach ($query as $q) {
			# code...
		}
		return $query->result_array();
	}

	public function get_four_page_by_type($pageType){
		$limit = 4;
		$query = $this->db->get_where('pages', array('pageType' => $pageType), $limit, $offset=0);
		foreach ($query as $q) {
			# code...
		}
		return $query->result_array();
	}

	public function get_page_by_id($id){
		$query = $this->db->get_where('pages', array('pageID'=>$id));
		return $query->row_array();
	}

	public function view_abstract_by_id($id) {
		$query = $this->db->get_where('abstracts', array('id'=>$id));
		return $query->result_array();
	}

	public function get_image_by_page_id($id) {
		$query = $this->db->get_where('images', array('pageID'=>$id));
		return $query->row_array();
	}

	public function get_abstracts() {
		$query = $this->db->get_where('abstracts', array('active'=>1));
		return $query->result_array();
	}

	public function get_timers(){
		$q = $this->db->get('conferences');
		return $q->row_array();
	}

}

/* End of file colloquy.php */
/* Location: ./application/models/colloquy.php */