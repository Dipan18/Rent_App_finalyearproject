<?php 

class User extends MY_Controller {
        
    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->model('productmodel');
        $this->load->model('rentmodel');
    }

    public function profile() { // used to load profile view 
        $this->load->view('profile', $this->data);
    }

    public function edit_profile() {  // function is only used to load the edit profile view        
        $this->load->view('edit_profile', $this->data);
    }

    public function change_password() { // function is only used to load the view
        $this->load->view('change_password', $this->data);
    }

    
    public function update_userdata() { // function is used to update user details in databases
        $this->load->library('form_validation');
        $this->load->model('updatemodel');
        
        if (! $this->form_validation->run()) { 
            $this->load->view('edit_profile', $this->data);
            return;
        }
        
        $id = $this->session->user['id'];
        $first_name = $this->input->post('first_name');
        $last_name = $this->input->post('last_name');
        $pincode = $this->input->post('pincode');
        $address = $this->input->post('address');
        
        $result = $this->updatemodel->update_data($id, $first_name, $last_name, $pincode, $address);

        if ($result == 1) {
            return redirect('user/profile');
        } else { // validation passeds but database error
            $this->session->set_flashdata('update_failed', 'Update process failed');
            return redirect('user/edit_profile');
        }               
    }
    
    public function update_password() { // function is used to change password in database
        $this->load->library('form_validation');
        
        if (! $this->form_validation->run()) {
            $this->load->view('change_password', $this->data);
            return;
        }

        $this->load->model('updatemodel');
        $id = $this->session->user['id'];

        $password = $this->input->post('current_password');
        $new_password = $this->input->post('new_password');

        if (! $this->updatemodel->check_password($id, $password)) { // to check current password matches the database password
            $this->session->set_flashdata('wrong_password', 'Current password is incorrect');
            return redirect('user/change_password');
        }

        if ($this->updatemodel->check_password($id, $new_password)) { // to check if new password is same as old password
            $this->session->set_flashdata('same_password', 'New password cannot be same as old password');
            return redirect('user/change_password');
        }

        $this->_change_password_db($new_password, $id);
    }

    private function _change_password_db($new_password, $id) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $result = $this->updatemodel->update_password($id, $hashed_password);
        
        if ($result == 1) { // password update successful
            return redirect('logout');
        } else { // error happened
            $this->session->set_flashdata('error', 'Something went wrong. Please try Again!');
            return redirect('user/change_password');
        }
    }
    
    public function your_ads() {
        // $user_products = $this->productmodel->user_ads($this->session->user['id']);
        $this->_display_products($this->productmodel->user_ads($this->session->user['id']));
        $this->load->view('your_ads', $this->data);
        // echo '<pre>'; print_r($this->data['products']); exit;
    }
    
    public function ad_details() {
        $id = rawurldecode($this->encrypt->decode($_GET['q']));
        
        if (empty($id))
            return redirect('user/your_ads');

        if (empty($this->productmodel->get_product_details($id)))
            show_404();
            
        $this->data['product'] = $this->productmodel->get_product_details($id);
        $this->data['product_images'] = $this->_fix_img_path($this->productmodel->get_product_images($id));        
        
        $this->load->view('product_details', $this->data);
    }

    public function request_details() {
        $id = rawurldecode($this->encrypt->decode($_GET['q']));
        
        if (empty($id))
            return redirect('user/your_ads');
            
        $this->data['product'] = $this->rentmodel->get_request_product_details($id);
        $this->data['product']['can_buy'] = FALSE;
        $this->data['product_images'] = $this->_fix_img_path($this->rentmodel->get_product_images_on_hold($id));        
        
        $this->load->view('product_details', $this->data);
    }
    
    public function remove_ad() {
        $id = rawurldecode($this->encrypt->decode($_GET['q']));
        
        if (empty($id))
            return redirect('user/your_ads');
            
            $img_metadata = $this->productmodel->get_product_images($id); 
            $result = $this->productmodel->remove_row($id);
            
            if ($result != 1) {
                $this->session->set_flashdata('remove_error', 'Error occurred while removing Ad, Try Again!');
            return redirect('user/your_ads');
        } else {        
            $this->_rmdir_recursive($img_metadata[0]['img_path']);

            $this->session->set_flashdata('remove_success', 'Ad removed Successfully!');
            return redirect('user/your_ads');
        }
    }
    
    private function _reload_page_with_error($url) {
        $this->session->set_flashdata('rent_error', 'Error Occurred, Please try agaian later!');
        return redirect('products/product_details/?q=' . urlencode($url));
    }
    
    private function _remove_redundant_data($id) {
        $this->rentmodel->remove_rent_request($id);        // delete the request first due to foreign key 
        $this->rentmodel->remove_product_on_hold($id);
    }
    
    public function rent_item() {
        $encrypted_id = $this->input->get('q'); 
        $item_id = rawurldecode($this->encrypt->decode($encrypted_id));
                
        if ($this->rentmodel->move_product($item_id) != 1) {     // failed to move product from products table     
            $this->_reload_page_with_error($encrypted_id);       // to products_on_hold table 
        }                                                        // remove the request
        
        if ($this->rentmodel->move_images($item_id) <= 0) {      // failed to move images from product_images 
            $this->rentmodel->remove_product_on_hold($item_id);  // to product_images_on_hol
            $this->_reload_page_with_error($encrypted_id);       // remove the copied row from product to products_on_hold
        }                                                        // and remove the rent request 
        
        if ($this->rentmodel->rent_request($item_id, $this->session->user['id']) != 1) {
            $this->rentmodel->remove_product_on_hold($item_id);
            $this->_reload_page_with_error($encrypted_id);
        }
        
        if ($this->productmodel->remove_row($item_id) != 1) {     // to remove the product from products table
            $this->_remove_redundant_data($item_id);              // so it does not get displayed in home, search, and sorting
            $this->_reload_page_with_error($encrypted_id);      
        } 
        
        $this->session->set_flashdata('request_sent', 'Request sent successfully. Contact the owner and come to terms about getting the item from them');
        return redirect('user/rent_requests');
    }
    
    public function rent_requests() {
        $this->data['buy_rent_requests'] = $this->rentmodel->get_buyer_rent_requests($this->data['id']);
        $this->data['sell_rent_requests'] = $this->rentmodel->get_seller_rent_requests($this->data['id']);
        $this->data['rejected_requests'] = $this->rentmodel->get_rejected_requests($this->data['id']); 
         
        for ($i = 0; $i < sizeof($this->data['sell_rent_requests']); $i++) {
            $days_remaining = $this->rentmodel->days_remaining($this->data['sell_rent_requests'][$i]['pro_id']);
            $this->data['sell_rent_requests'][$i]['days_remaining'] = $days_remaining;
        }
        // echo '<pre>';
        // print_r($this->data['sell_rent_requests']); exit;
        $this->load->view('rent_requests', $this->data);
    }

    public function rented_by_user() {
        $this->data['rented_by_user'] = $this->rentmodel->rented_by_user($this->data['id']);
     
        for ($i = 0; $i < sizeof($this->data['rented_by_user']); $i++) {
            $days_remaining = $this->rentmodel->days_remaining($this->data['rented_by_user'][$i]['pro_id']);
            $this->data['rented_by_user'][$i]['days_remaining'] = $days_remaining;
        }

        $this->load->view('rented_by_user', $this->data);
    }

    public function accept_request() {
        $id = rawurldecode($this->encrypt->decode($_GET['q']));

        if (empty($id))
            return redirect('user/rent_requests');

        if ($this->rentmodel->accept_request($id) != 1) {
            $this->session->set_flashdata('request_error', 'Error occurred, Try Again!');
            return redirect('user/rent_requests');
        } 

        $this->session->set_flashdata('accept_success', 'Request Accepted Successfully!');
        return redirect('user/rent_requests');
    }

    private function _reject_error() {
        $this->session->set_flashdata('request_error', 'Error Occurred, Try again Later!');
        return redirect('user/rent_requests');
    }
    
    public function reject_request() {
        $id = rawurldecode($this->encrypt->decode($_GET['q']));
        
        if (empty($id))
            return redirect('user/rent_requests');
        
        if ($this->rentmodel->move_request_to_rejected($id) != 1) 
            $this->_reject_error();

        if ($this->rentmodel->move_product_on_hold($id) != 1) {
            $this->rentmodel->remove_rejected_request($id);
            $this->_reject_error();
        }

        if ($this->rentmodel->move_images_on_hold($id) < 1) {
            $this->productmodel->remove_row($id);
            $this->rentmodel->remove_rejected_request($id);
            $this->_reject_error();
        }
        
        if ($this->rentmodel->remove_product_on_hold($id) != 1) {
            $this->productmodel->remove_row($id);
            $this->rentmodel->remove_rejected_request($id);
            $this->_reject_error();
        }

        $this->session->set_flashdata('reject_success', 'Request rejected Successfully!');
        return redirect('user/rent_requests');
    }

    public function request_by_user() {
        $id = rawurldecode($this->encrypt->decode($_GET['q']));

        $user_data = $this->rentmodel->request_user_details($id);

        foreach($user_data as $key => $user) {
            // echo $key;
            $new_key = 'request_user_' . $key;
            $user_data[$new_key] = $user;
            unset($user_data[$key]);
        }   
        
        $this->data['request_user_details'] = $user_data;
        $this->load->view('request_user_details', $this->data);
    }
}