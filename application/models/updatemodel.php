<?php

class Updatemodel extends CI_Model {

    public function update_data($id, $first_name, $last_name, $pincode, $address) {
        $data = ['first_name'=>$first_name, 'last_name'=>$last_name, 'pincode'=>$pincode, 'address'=>$address];
        $this->db->where('id', $id);
        return $this->db->update('users', $data);
    }

    public function check_password($id, $password) {
        $query = $this->db->where(['id'=>$id])->get('users');
        $pass = $query->row()->password;

        if (password_verify($password, $pass)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function update_password($id, $new_password) {
        $query = $this->db->where('id', $id);
        return $this->db->update('users', ['password' => $new_password]);
    }
}