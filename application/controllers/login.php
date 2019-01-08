<?php 	

class Login extends CI_Controller {

	public function __construct() {
		parent::__construct();
		if ($this->session->userdata('user'))
			return redirect('home'); 
	}

	public function index() {
		$this->load->helper('form');
		$this->load->view('login');			
	}

	public function login_user() {
		$this->load->library('form_validation');

		if ($this->form_validation->run()) {
			
			$this->load->model('loginmodel');
			
			$email = $this->input->post('email');
			$password = $this->input->post('password');
			$login_id = $this->loginmodel->validate_login($email, $password);
			
			if ($login_id) { // User input correct, set session 
				$this->set_session($email);
				return redirect('home');
			} else { // Validation passed but user entered wrong data		
				$this->session->set_flashdata('login_failed', 'Invalid Email/Password!');
				return redirect('login');
			}
		} else { 
			$this->load->view('login'); // To load the form again with validation errors
		}
	}

	public function set_session($email) {
		$this->load->library('session');

		$user_details = $this->loginmodel->get_userdata($email);

		$user = ['id' => $user_details['id'],
				'email' => $user_details['email'],
				// 'first_name' => $user_details['first_name'],
				// 'last_name' => $user_details['last_name']
				];

		$this->session->set_userdata('user', $user);
 	}

}