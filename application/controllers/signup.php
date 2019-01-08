<?php

class Signup extends CI_Controller {

	public function __construct() {
		parent::__construct();
		if ($this->session->userdata('user')) // check to see if user is logged in
			return redirect('homepage');	  // if user is logged in redirect to homepage, dont allow to register
	}

	public function index() {
		$this->load->helper('form');
		$this->load->view('signup');
	}

	public function register_user() {
		$this->load->library('form_validation');
	
		if ($this->form_validation->run()) { // runs if validations passed
			$this->load->model('signupmodel');
		
			$first_name = $this->input->post('first_name');
			$last_name = $this->input->post('last_name');
			$email = $this->input->post('email');
			$password = $this->input->post('password');
			$phone_no = $this->input->post('phone_no');

			$hashed_password = password_hash($password, PASSWORD_DEFAULT);

			if ($this->signupmodel->register_user($first_name, $last_name, $email, $phone_no, $hashed_password)) { // executes insert query through signup model
				$this->session->set_flashdata('registration_success', 'Registration Successful!');
				return redirect('login');
			} else { // if insertion in database fails
				$this->session->set_flashdata('registration_fail', 'Something went wrong! Try Again.');
				return redirect('signup');
			}			
		} else { // validations failed reload forms with errors
			$this->load->view('signup');
		}
	}
}