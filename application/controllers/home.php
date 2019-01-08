<?php 

class Home extends CI_Controller {

    private $data;

    public function __construct() {
        parent::__construct();
        $this->load->library('pagination');
        $this->load->model('productmodel');
        $this->load->model('loginmodel');
        $this->data = $this->loginmodel->get_userdata($this->session->user['email']);
    }


    private function _display_products($products) {
        $this->data['products'] = [];
        
        foreach($products as $product) {
            $path = $product['img_path'];
            $prefix = 'C:/xampp/htdocs/codeigniter/';
    
            if (substr($path, 0, strlen($prefix)) == $prefix) {
                $path = substr($path, strlen($prefix));
            } 
            array_push($this->data['products'], ['pro_id'=>$product['pro_id'],
                                                 'pro_title'=>$product['pro_title'],
                                                 'img_path'=>$path . $product['img_name'],
                                                 'pro_price'=>$product['pro_price']
                                                ]);
        }
    }
    

    private function _pagination_config() {
        $config = [
            'base_url'          => base_url('/home'),
            'per_page'          => 16,
            'total_rows'        => $this->productmodel->get_products_rows(),
            'attributes'        => ['class'=>'page-link'],
            'full_tag_open'     => '<ul class="pagination justify-content-center">',
            'full_tag_close'    => '</ul>',
            'next_tag_open'     => '<li class="page-item">',
            'next_tag_close'    => '</li>',
            'prev_tag_open'     => '<li class="page-item">',
            'prev_tag_close'    => '</li>',
            'num_tag_open'      => '<li class="page-item">',
            'num_tag_close'     => '</li>',
            'cur_tag_open'      => '<li class="page-item active"><a class="page-link">',
            'cur_tag_close'     => '</a></li>'
        ];

        return $config;
    }

    public function index() {
        $config = $this->_pagination_config();

        $this->pagination->initialize($config);

        $products = $this->productmodel->get_products($config['per_page'], $this->uri->segment(2)); 
        $this->_display_products($products);
        
        $this->load->view('homepage', $this->data); 
    }


    public function sort_by_category() {
        $id = $this->uri->segment(3);

        if (empty($id))
            return redirect('home');

        $config = $this->_pagination_config();
        $config['base_url'] = base_url() . '/home/sort_by_category/' . $id;
        $config['total_rows'] = $this->productmodel->categorized_products_rows($id);
        $config['uri_segment'] = 4;
        $this->pagination->initialize($config);

        $categorized_products = $this->productmodel->categorized_products($id, $config['per_page'], $this->uri->segment(4));

        $this->_display_products($categorized_products);
        
        $this->load->view('homepage', $this->data);
    }

    public function search() {
        $search_query = trim($this->input->get('q'));

        $search_result = $this->productmodel->search_db($search_query);

        if (empty($search_result)) {
            $this->session->set_flashdata('search_failed', 'Sorry your search didnt return any results!');
            return redirect('home');
        }

        $this->_display_products($search_result);
        
        $this->load->view('homepage', $this->data); 
    } 
}