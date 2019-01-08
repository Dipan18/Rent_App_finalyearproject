<?php 

class Rentmodel extends CI_Model {

    public function rent_request($pro_id, $buyer_id) {
        $data = ['pro_id'=>$pro_id, 'buyer_id'=>$buyer_id];

        $query = $this->db->insert('rent_requests', $data);

        return $this->db->affected_rows();
    }

    public function move_product($id) {
        $query = $this->db->select('*')
                          ->from('products')
                          ->where('products.pro_id', $id)
                          ->get();
        
        // echo '<pre>'; 
        // print_r($query->result_array()); exit;        
        
        $data = $query->result_array();

        $this->db->insert('products_on_hold', $data[0]);
        
        return $this->db->affected_rows();
    }

    public function move_images($id) {
        $query = $this->db->select('pro_id, img_name, img_path')->from('product_images')->where('pro_id', $id)->get();

        $data = $query->result_array();
        
        // echo '<pre>';
        // print_r($data); exit;
        
        $this->db->insert_batch('product_images_on_hold', $data);

        return $this->db->affected_rows();
    }

    public function remove_rent_request($id) {
        $query = $this->db->where('pro_id', $id)->delete('rent_requests');
    }

    public function remove_product_on_hold($id) {
        $this->db->where('pro_id', $id)->delete('products_on_hold');
        return $this->db->affected_rows();
    }

    
    public function get_request_product_details($id) {
        $query = $this->db->select('products_on_hold.pro_id, products_on_hold.user_id, products_on_hold.pro_title, products_on_hold.pro_desc, products_on_hold.pro_price,                                          
                                    products_on_hold.rent_period, products_on_hold.pro_pincode, products_on_hold.pro_address, products_on_hold.created_at,
                                    categories.cat_name, users.first_name, users.last_name, users.email, users.phone_no')
                          ->from('products_on_hold')
                          ->join('categories', 'products_on_hold.pro_cat = categories.cat_id', 'inner')
                          ->join('users', 'products_on_hold.user_id = users.id', 'inner')
                          ->where('pro_id', $id)
                          ->get();

                          // echo '<pre>';
        // print_r($query->result_array()); exit;
        return $query->result_array();
    }
    
    public function get_product_images_on_hold($id) {
        $query = $this->db->select('img_path, img_name')->from('product_images_on_hold')->where('pro_id', $id)->get();
        return $query->result_array();
    }
    
    public function get_buyer_rent_requests($id) {
        // echo $id; exit;
        $query = $this->db->select('requested_on, products_on_hold.pro_id, products_on_hold.pro_title, rent_status.status')
                          ->from('rent_requests')
                          ->join('products_on_hold', 'products_on_hold.pro_id = rent_requests.pro_id', 'inner')
                          ->join('rent_status', 'rent_status.id = rent_requests.status', 'inner')
                          ->where('buyer_id', $id)
                          ->get();

        // echo '<pre>';
        // print_r($query->result_array()); exit;
        return $query->result_array();
    }

    public function get_seller_rent_requests($id) {
        $query = $this->db->select('requested_on, products_on_hold.pro_id, products_on_hold.pro_title, 
                                    rent_status.status, rent_requests.buyer_id, 
                                    rent_requests.rented_on, users.first_name, users.last_name')
                          ->from('products_on_hold')
                          ->join('rent_requests', 'products_on_hold.pro_id = rent_requests.pro_id', 'inner')
                          ->join('rent_status', 'rent_requests.status = rent_status.id')
                          ->join('users', 'users.id = rent_requests.buyer_id', 'inner')
                          ->where('user_id', $id)
                          ->get();

        // echo '<pre>';
        // print_r($query->result_array()); exit;
        return $query->result_array();
    }

    public function get_rejected_requests($id) {
        // echo $id; exit;
        $query = $this->db->select('requested_on, products.pro_id, products.pro_title, rent_status.status')
                          ->from('rejected_requests')
                          ->join('products', 'products.pro_id = rejected_requests.pro_id', 'inner')
                          ->join('rent_status', 'rent_status.id = rejected_requests.status', 'inner')
                          ->where('buyer_id', $id)
                          ->get();

        // echo '<pre>';
        // print_r($query->result_array()); exit;
        return $query->result_array();
    }

    public function move_request_to_rejected($pro_id) {
        $data = $this->db->select('pro_id, buyer_id, requested_on')
                     ->from('rent_requests')
                     ->where('pro_id', $pro_id)
                     ->get();
                     
        $data = $data->row_array();
        $data['status'] = 3;
        // echo '<pre>'; print_r($data); exit;
        $this->db->insert('rejected_requests', $data);
        return $this->db->affected_rows(); 
    }

    public function move_product_on_hold($id) {
        $query = $this->db->select('*')
                          ->from('products_on_hold')
                          ->where('products_on_hold.pro_id', $id)
                          ->get();
        
        // echo '<pre>'; 
        // print_r($query->result_array()); exit;        
        
        $data = $query->row_array();

        $this->db->insert('products', $data);
        
        return $this->db->affected_rows();;
    }

    public function move_images_on_hold($id) {
        $query = $this->db->select('pro_id, img_name, img_path')->from('product_images_on_hold')->where('pro_id', $id)->get();

        $data = $query->result_array();
        
        // echo '<pre>';
        // print_r($data); exit;
        
        $this->db->insert_batch('product_images', $data);
        // echo '<pre>';
        // print_r($this->db->error()); exit;
        return $this->db->affected_rows();
    }

    public function remove_rejected_request($id) {
        $query = $this->db->where('pro_id', $id)->delete('rejected_requests');
    }
    
    
    public function accept_request($id) {
        $now = date('Y-m-d H:i:s');

        $query = $this->db->set('status', 2)
                          ->set('rented_on', $now)
                          ->where('pro_id', $id)
                          ->update('rent_requests');

        return $this->db->affected_rows();
    }


    public function days_remaining($pro_id) {
        $query = 'SELECT DATEDIFF(DATE_ADD(rent_requests.rented_on, INTERVAL products_on_hold.rent_period DAY), CURTIME())
                  FROM rent_requests, products_on_hold
                  WHERE rent_requests.status = 2 AND products_on_hold.pro_id = ' . $pro_id;

        // echo $query; exit;
        $result = $this->db->query($query);
        $row = $result->row_array();
        return $row['DATEDIFF(DATE_ADD(rent_requests.rented_on, INTERVAL products_on_hold.rent_period DAY), CURTIME())'];     
    }

    public function request_user_details($id) {
        $query = $this->db->select('first_name, last_name, email, phone_no, pincode, address')
                          ->from('users')
                          ->where('id', $id)
                          ->get();

        // echo '<pre>';
        // print_r($query->row_array()); exit;
        return $query->row_array();
    }

    public function rented_by_user($id) {
        // echo $id; exit;
        $query = $this->db->select('requested_on, rented_on, products_on_hold.pro_id, products_on_hold.pro_title, products_on_hold.user_id,
                                    users.first_name, users.last_name')
                          ->from('rent_requests')
                          ->join('products_on_hold', 'products_on_hold.pro_id = rent_requests.pro_id', 'inner')
                          ->join('users', 'users.id = products_on_hold.user_id', 'inner')
                          ->where(['buyer_id' => $id, 'rent_requests.status' => 2])
                          ->get();

        // echo '<pre>';
        // print_r($query->result_array()); exit;
        return $query->result_array();
    }
}