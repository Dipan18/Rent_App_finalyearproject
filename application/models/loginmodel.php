<?php

class Loginmodel extends CI_Model {

	public function validate_login($email, $password) {
		$query = $this->db->where(['email'=>$email])->get('users'); // get the row with the email
		
		$pass = $query->row()->password; // get the password from result row
										
		if (password_verify($password, $pass)) { // if password from input matches hased password
			//  refactor
			// $id = $query->row()->id;
			// $email = $query->row()->email;
			// $first_name = $query->row()->first_name;
			// $last_name = $query->row()->last_name;

			return TRUE;
			//['id'=>$id, 'email'=>$email, 'first_name'=>$first_name, 'last_name'=>$last_name];
		} else {
			return FALSE;
		}
	}

	public function get_userdata($email) {
		$query = $this->db->get_where('users', ['email'=>$email]);
		$result = $query->row_array();
		unset($result['password']);
		//print_r($result);
		return $result;
	}
}