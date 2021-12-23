<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notfound extends CI_Controller {
	public function index()
	{
		if (!$this->session->userdata('user_type'))
			redirect(base_url() . 'login', 'refresh');
			
		$page_data['page_title']	=	'404';
		$page_data['page_name'] 	= 	'404';
		$this->load->view('index', $page_data);
	}
}
