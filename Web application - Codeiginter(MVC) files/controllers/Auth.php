<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	function signin()
	{
		#$email				=	$this->input->post('email');
		#$password			=	$this->input->post('password');
		$email				=	'admin@mars.com';
		$password			=	'admin';
		$query				=	$this->db->get_where('user' , array('email' => $email, 'status' => 1));

		// MATCHES WITH THE USER TABLE
		if ($query->num_rows() > 0)
		{
			$db_password	=	$this->db->get_where('user' , array('email' => $email ))->row()->password;

			if (password_verify($password, $db_password))
			{
				$this->session->set_userdata('user_type' , $query->row()->user_type);
				$this->session->set_userdata('user_id' , $query->row()->user_id);
				$this->session->set_userdata('permissions' , explode(",", $query->row()->permissions));
				
				redirect(base_url(), 'refresh');
			} else {
				$this->session->set_flashdata('warning', 'Incorrect password, Try again.');

				redirect(base_url() . 'login', 'refresh');
			}
		}
		else
		{
			$this->session->set_flashdata('warning', 'Incorrect email, Try again.');

			redirect(base_url() . 'login', 'refresh');
		}
		
	}

	function logout()
	{
		$this->session->unset_userdata('user_type');
		$this->session->unset_userdata('user_id');
		$this->session->unset_userdata('permissions');

		$this->session->set_flashdata('success', 'You have successfully logged out, Thank you.');

		redirect(base_url()  . 'login', 'refresh');
	}
}
?>
