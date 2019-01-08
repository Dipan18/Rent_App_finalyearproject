<?php 

class MY_Controller extends CI_Controller {

    protected $data; 

    public function __construct() {
        parent::__construct();
    
        if (! $this->session->userdata('user'))
            return redirect('login');
        else {
            $this->load->model('loginmodel');
            $this->data = $this->loginmodel->get_userdata($this->session->user['email']);
        }
    }

    protected function _display_products($products) {
        $this->data['products'] = [];
        
        foreach($products as $product) {
            $path = $product['img_path'];
            $prefix = 'C:/xampp/htdocs/codeigniter/';

            if (substr($path, 0, strlen($prefix)) == $prefix) {
                $path = substr($path, strlen($prefix));
            } 
            array_push($this->data['products'], ['pro_id'=>$product['pro_id'],
                                                 'pro_title'=>$product['pro_title'],
                                                 'created_at'=>$product['created_at'],
                                                 'img_path'=>$path . $product['img_name'],
                                                ]);
        }
    }

    protected function _fix_img_path($product_images) {
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

    public function _rmdir_recursive($dir) {
        foreach(scandir($dir) as $file) {
            if ('.' === $file || '..' === $file) continue;
            if (is_dir("$dir/$file")) rmdir_recursive("$dir/$file");
            else unlink("$dir/$file");
        }
        rmdir($dir);
    }
}
