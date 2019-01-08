<?php

class Products extends CI_Controller {
    
    private $data;

    public function __construct() {
        parent::__construct();
        $this->load->model('loginmodel');
        $this->data = $this->loginmodel->get_userdata($this->session->user['email']);
    }

    private function _fix_img_path($product_images) {
        $images = [];
        $prefix = 'C:/xampp/htdocs/codeigniter/';

        foreach($product_images as $image) {
            $path = $image['img_path'];
        
            if (substr($path, 0, strlen($prefix)) == $prefix) {
                $path = substr($path, strlen($prefix));
            }
            array_push($images, ['img_path' => $path . $image['img_name']]);
        }
        return $images; 
    }

    public function product_details() {
        $id = rawurldecode($this->encrypt->decode($_GET['q']));

        if (empty($id))
            return redirect('home');

        $this->load->model('productmodel');
        
        if (empty($this->productmodel->get_product_details($id)))
            show_404();
            
        $this->data['product'] = $this->productmodel->get_product_details($id);
        $this->data['product_images'] = $this->_fix_img_path($this->productmodel->get_product_images($id));        
        
        // echo '<pre>';
        // print_r($this->data); exit;
        $this->load->view('product_details', $this->data);
    }
}