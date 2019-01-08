<?php

class Signupmodel extends CI_Model {

	public function register_user($first_name, $last_name, $email, $phone_no, $password ) {
		$data = ['first_name'=>$first_name, 'last_name'=>$last_name, 'email'=>$email, 'phone_no'=>$phone_no, 'password'=>$password];
		return $query = $this->db->insert('users', $data);
	}
}