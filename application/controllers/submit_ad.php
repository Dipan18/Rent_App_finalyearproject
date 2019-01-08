<?php

class Submit_ad extends MY_Controller {
    
    private $files = NULL;
    private $image_upload_errors = [];
    private $image_upload_data = [];
    private $folder_path;


    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
    }


    public function _re_array_files(&$file_post) {

        $file_ary = array();
        $file_count = count($file_post['name']);
        $file_keys = array_keys($file_post);

        for ($i = 0; $i < $file_count; $i++) {
            foreach ($file_keys as $key) {
                $file_ary[$i][$key] = $file_post[$key][$i];
            }
        }

        return $file_ary;
    }


    private function _init_folder_path() {
        date_default_timezone_set("Asia/Calcutta");
        // echo date("j"); // day
        // echo date("n"); // month
        // echo date("y"); // year
        // echo date("i"); // minutes
        // echo date("s"); // seconds

        $sub_folder = date('j') . date ('n') . date('y') . date('i') . date('s');
        $this->folder_path = 'uploads/' . $this->data['phone_no'] . '/' .$sub_folder;

        if (! is_dir($this->folder_path)) // make directory if it does not exist
            mkdir($this->folder_path, 0777, TRUE);

    }


    public function index() { // function only user to load the ad form
        $this->load->model('productmodel');
        $this->load->view('submit_ad', $this->data);
    }


    public function _image_validation() {
        $num_files = 0;
       
        foreach ($this->files as $file) {
            if (! empty($file['name']))
                $num_files++;
        }
        
        if ($num_files <= 0) {
            $this->form_validation->set_message('_image_validation', 'Atleast upload 1 image');
            return FALSE;
        } else if ($num_files > 5) {
            $this->form_validation->set_message('_image_validation', 'Can not upload more than 5 images');
            return FALSE;
        } else {
            return TRUE;
        }
    }


    private function _upload_config() {
        $this->_init_folder_path();

        $config = [
            'upload_path' => $this->folder_path,
            'allowed_types' => ['jpg', 'png', 'jpeg'],
            'overwrite' => FALSE,
            'remove_spaces' => TRUE,
            'file_ext_tolower' => TRUE,	
            'max_size' => '2000'
            //'max_width' => '1024',
            //'max_height' => '768',
        ];
        
        return $config;
    }


    private function _upload_to_disk() {
        $config = $this->_upload_config();

        foreach($this->files as $file) {

            $_FILES['userfile']['name'] = $file['name'];
            $_FILES['userfile']['type'] = $file['type'];
            $_FILES['userfile']['tmp_name'] = $file['tmp_name'];
            $_FILES['userfile']['error'] = $file['error']; 
            $_FILES['userfile']['size'] = $file['size'];

            $this->load->library('upload', $config);
            
            if (! $this->upload->do_upload('userfile')) {
                array_push($this->image_upload_errors, ['name'=>$file['name'], 'error'=>$this->upload->display_errors()]);
            } else {
                // $this->image_upload_data = array('upload_data' => $this->upload->data());
                array_push($this->image_upload_data, $this->upload->data());
            }
        }

        if (! empty($this->image_upload_errors)) { // errors inside of errors array
            $this->_rmdir_recursive($config['upload_path']);  // to remove the created directory if upload errors
            return FALSE;
        } else { // no errors occured send the upload metadata
            return TRUE;
        }
    }


    private function _insert_db_adData($ad_data) {
        $this->load->model('productmodel');
        $id = $this->productmodel->insert_adData($ad_data);

        if ($id !== 0) { // insert to database successful
            $this->_insert_db_images($id); 
        } else { // errors while uploading to database
            $this->_rmdir_recursive($this->folder_path); // remove the images from disk
            $this->session->set_flashdata('db_insert_fail', 'Failed to submit the Ad, Try Again.');
            return redirect('submit_ad');
        }
    }

    
    private function _insert_db_images($id) {
        $image_metadata = [];
        $this->load->model('productmodel');

        foreach($this->image_upload_data as $data) {
            array_push($image_metadata, ['pro_id'=>$id, 'img_name'=>$data['file_name'], 'img_path'=>$data['file_path']]);
        }
        
        $result = $this->productmodel->insert_image_metadata($image_metadata);

        if ($result === 0) { // error inserting images to db. remove the ad data and, images from disk
            $this->_rmdir_recursive($this->folder_path);
            $this->productmodel->remove_row($id);
            $this->session->set_flashdata('db_insert_fail_img', 'Failed to upload images. Try Again');
            return redirect('submit_ad');
        } else { // Ad successfully inserted
            $this->session->set_flashdata('success', 'Ad submitted successfully!');
            return redirect('submit_ad');
        }
    }

    public function upload_ad() {
        $this->files = $this->_re_array_files($_FILES['userfile']);        
        
        if ($this->form_validation->run() && $this->_image_validation()) {
            
            $result = $this->_upload_to_disk(); // move/upload images to disk
            
            if ($result) { // no errors in upload to disk, add upload and AD metadata to database
                
                $ad_data = [
                    'user_id'     => $this->session->user['id'],
                    'pro_title'   => $this->input->post('item_name'),
                    'pro_desc'    => $this->input->post('item_desc'),
                    'pro_price'   => $this->input->post('price'),
                    'pro_cat'     => $this->input->post('category'),
                    'rent_period' => $this->input->post('rent_time'),
                    'pro_pincode' => $this->input->post('pincode'),
                    'pro_address' => $this->input->post('address')
                ];

                $this->_insert_db_adData($ad_data);

            } else { // errors in upload reload page with errors
                $this->session->set_flashdata('upload_errors', $this->image_upload_errors);
                return redirect('submit_ad');
            }

        } else { // validation errors load form again
            $this->index();
        }
    }
    
}