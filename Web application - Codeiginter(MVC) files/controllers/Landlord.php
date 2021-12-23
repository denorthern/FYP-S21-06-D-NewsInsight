<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Landlord extends CI_Controller {
	
		
	
	public function index()
	{
		if (!$this->session->userdata('user_type'))
			redirect(base_url() . 'auth/signin', 'refresh');

		if (in_array($this->db->get_where('module', array('module_name' => 'dashboard'))->row()->module_id, $this->session->userdata('permissions'))) {
			$page_data['page_title']	=	'Home';
			$page_data['page_name']		=	'home';
			
			$this->load->view('index', $page_data);
		} else {
			$page_data['page_title']	=	'Permission Denied';
			$page_data['page_name'] 	= 	'permission_denied';
			$this->load->view('index', $page_data);
		}
	}

	function login()
	{
		$this->load->view('login');
	}


	function details($param1 = '', $param3 = '', $param4 = '', $param2='')
	{
		if (!$this->session->userdata('user_type'))
			redirect(base_url() . 'auth/signin', 'refresh');
		
		if (in_array($this->db->get_where('module', array('module_name' => 'details'))->row()->module_id, $this->session->userdata('permissions'))) {
			
			$NewsSource=array("", "Global","Dawn", "Tribune", "SCMP", "Xinhua", "Sputnik", "NewYorkTimes","TimesOfIndia","Tass", "Pakistan","India","China", "Russia", "USA", "US" );
			$NewsSourceCode=array("worldwide", "worldwide","dawn", "tribune", "scmp", "xinhua", "sputnik", "nyt","toi","tass", "pakistan","india","china", "russia", "america", "america" );
			$c=0;
			$var="";
			while ($c<16 ){
			if ( $NewsSource[$c]==$param1) $var=$NewsSourceCode[$c];
			$c++;
			}			
			
			$page_data['page_title']	=	$param3;
			$page_data['n_source']	=	$var;
			$page_data['code']	=	$var;
			$page_data['name']	=	$param3;
			$page_data['country']	=	$param1;
			$page_data['asource']	=	$param1;
			$page_data['page_name'] 	=	'details';
			
			$this->load->view('index', $page_data);
		} else {
			$page_data['page_title']	=	'Permission Denied';
			$page_data['page_name'] 	= 	'permission_denied';
			$this->load->view('index', $page_data);
		}
	}
	
	
	function compare($param1 = '', $param3 = '', $param2 = '')
	{
		if (!$this->session->userdata('user_type'))
			redirect(base_url() . 'auth/signin', 'refresh');
		
		if (in_array($this->db->get_where('module', array('module_name' => 'compare'))->row()->module_id, $this->session->userdata('permissions'))) {
		$countries=array("","Pakistan", "Russia", "USA","US", "India", "China", "Global");
			
			$flag=False;
			$c=0;
			while ($c<8 ){
			if ( $countries[$c]==$param1) {
				$flag=True;
			}
			$c++;
			
			}

			if ($flag!=True ){
				$param1='';
				redirect(base_url() . 'overview', '');
			}
			
			if ($param3=='' ){
				$param3=$param1;
			}
			
			$NewsSource=array("", "Global","Dawn", "Tribune", "SCMP", "Xinhua", "Sputnik", "NewYorkTimes","TimesOfIndia","Tass", "Pakistan","India","China", "Russia", "USA", "US" );
			$NewsSourceCode=array("worldwide", "worldwide","dawn", "tribune", "scmp", "xinhua", "sputnik", "nyt","toi","tass", "pakistan","india","china", "russia", "america", "america" );
			$c=0;
			$var="";
			while ($c<16 ){
			if ( $NewsSource[$c]==$param3) $var=$NewsSourceCode[$c];
			$c++;
			}			
			
			$page_data['page_title']	=	$param3;
			$page_data['n_source']	=	$var;
			$page_data['code']	=	$var;
			$page_data['asource']	=	$param3;
			$page_data['country']	=	$param1;
			$page_data['page_name'] 	=	'compare';
			
			$this->load->view('index', $page_data);
		} else {
			$page_data['page_title']	=	'Permission Denied';
			$page_data['page_name'] 	= 	'permission_denied';
			$this->load->view('index', $page_data);
		}
	}
	
	function sources($param1 = '', $param3='', $param2 = '')
	{
		if (!$this->session->userdata('user_type'))
			redirect(base_url() . 'auth/signin', 'refresh');

		if (in_array($this->db->get_where('module', array('module_name' => 'sources'))->row()->module_id, $this->session->userdata('permissions'))) {
			$countries=array("","Pakistan", "Russia", "USA", "India", "China", "Global");
			$flag=False;
			$c=0;
			while ($c<7 ){
			if ( $countries[$c]==$param1) $flag=True;
			$c++;
			
			}
			
			if ($flag!=True ){
				$param1='';
				redirect(base_url() . 'sources', '');
			}
			
			$NewsSource=array("Global","Dawn", "Tribune", "SCMP", "Xinhua", "Sputnik", "NewYorkTimes","TimesOfIndia","Tass", "Pakistan","India","China", "Russia", "USA" );
			$NewsSourceCode=array("worldwide","dawn", "tribune", "scmp", "xinhua", "sputnik", "nyt","toi","tass", "pakistan","india","china", "russia", "america" );
			$c=0;
			$var="";
			while ($c<14 ){
			if ( $NewsSourceCode[$c]==$param3) $var=$NewsSource[$c];
			$c++;
			}			
			
			$page_data['page_title']	=	$var;
			$page_data['code']	=	$param3;
			$page_data['country']	=	$param1;
			$page_data['asource']	=	$var;
			$page_data['n_source']	=	$param3;
			$page_data['page_name'] 	=	'sources';
			
			$this->load->view('index', $page_data);
		} else {
			$page_data['page_title']	=	'Permission Denied';
			$page_data['page_name'] 	= 	'permission_denied';
			$this->load->view('index', $page_data);
		}
	}	


	function overview($param1 = '', $param3 = '', $param2 = '')
	{
		if (!$this->session->userdata('user_type'))
			redirect(base_url() . 'auth/signin', 'refresh');

		if (in_array($this->db->get_where('module', array('module_name' => 'overview'))->row()->module_id, $this->session->userdata('permissions'))) {
			$countries=array("","Pakistan", "Russia", "USA","US", "India", "China", "Global");
			
			$flag=False;
			$c=0;
			while ($c<8 ){
			if ( $countries[$c]==$param1) {
				$flag=True;
			}
			$c++;
			
			}

			if ($flag!=True ){
				$param1='';
				redirect(base_url() . 'overview', '');
			}
			
			if ($param3=='' ){
				$param3=$param1;
			}
			
			$NewsSource=array("", "Global","Dawn", "Tribune", "SCMP", "Xinhua", "Sputnik", "NewYorkTimes","TimesOfIndia","Tass", "Pakistan","India","China", "Russia", "USA", "US" );
			$NewsSourceCode=array("worldwide", "worldwide","dawn", "tribune", "scmp", "xinhua", "sputnik", "nyt","toi","tass", "pakistan","india","china", "russia", "america", "america" );
			$c=0;
			$var="";
			while ($c<16 ){
			if ( $NewsSource[$c]==$param3) $var=$NewsSourceCode[$c];
			$c++;
			}			
			
			$page_data['page_title']	=	$param3;
			$page_data['asource']	=	$param3;
			$page_data['n_source']	=	$var;
			$page_data['code']	=	$var;
			$page_data['country']	=	$param1;
			$page_data['page_name'] 	=	'overview';
			
			$this->load->view('index', $page_data);
		} else {
			$page_data['page_title']	=	'Permission Denied';
			$page_data['page_name'] 	= 	'permission_denied';
			$this->load->view('index', $page_data);
		}
	}	
	


	function list_trends($param1='',$param3='', $param2='')
	{
		if (!$this->session->userdata('user_type'))
			redirect(base_url() . 'auth/signin', 'refresh');
		
		if (in_array($this->db->get_where('module', array('module_name' => 'list_trends'))->row()->module_id, $this->session->userdata('permissions'))) {
			$countries=array("","Pakistan", "Russia", "USA", "India", "China", "Global");
			$flag=False;
			$c=0;
			while ($c<7 ){
			if ( $countries[$c]==$param1) $flag=True;
			$c++;
			
			}
			
			if ($flag!=True ){
				$param1='';
				redirect(base_url() . 'list_trends', '');
			}
			$NewsSource=array("Global","Dawn", "Tribune", "SCMP", "Xinhua", "Sputnik", "NewYorkTimes","TimesOfIndia","Tass", "Pakistan","India","China", "Russia", "USA" );
			$NewsSourceCode=array("worldwide","dawn", "tribune", "scmp", "xinhua", "sputnik", "nyt","toi","tass", "pakistan","india","china", "russia", "america" );
			$c=0;
			$var="";
			while ($c<14 ){
			if ( $NewsSourceCode[$c]==$param3) $var=$NewsSource[$c];
			$c++;
			}			
			
			$page_data['page_title']	=	$var;
			$page_data['code']	=	$param3;
			$page_data['country']	=	$param1;
			$page_data['n_source']	=	$param3;
			$page_data['asource']	=	$var;
			$page_data['category']	=	$param2;
			$page_data['page_name'] 	=	'list_trends';
			$this->load->view('index', $page_data);
		} else {
			$page_data['page_title']	=	'Permission Denied';
			$page_data['page_name'] 	= 	'permission_denied';
			$this->load->view('index', $page_data);
		}
	}





	
	function home()
	{
		if (!$this->session->userdata('user_type'))
			redirect(base_url() . 'auth/signin', 'refresh');

		if (in_array($this->db->get_where('module', array('module_name' => 'home'))->row()->module_id, $this->session->userdata('permissions'))) {
			
			
			$page_data['page_title']	=	"Home";
			
			$page_data['page_name'] 	=	'home';
			
			$this->load->view('index', $page_data);
		} else {
			$page_data['page_title']	=	'Permission Denied';
			$page_data['page_name'] 	= 	'permission_denied';
			$this->load->view('index', $page_data);
		}
	}	
		
	
	
}
