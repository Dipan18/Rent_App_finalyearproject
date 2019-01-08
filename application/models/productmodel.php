<?php 

class Productmodel extends CI_Model {

    public function get_categories() {
        $query = $this->db->get('categories');
        // echo '<pre>';
        // print_r($query->result_array());
        return $query->result_array();
    }

    public function insert_adData($data) {
        $query = $this->db->insert('products', $data);                        
        $id = $this->db->insert_id();

        return $id;             
    }

    public function insert_image_metadata($data) {
        $query = $this->db->insert_batch('product_images', $data);
        return $query;
    }

    public function remove_row($id) {
        $query = $this->db->where('pro_id', $id)->delete('products');

        return $this->db->affected_rows(); 
    }

    public function get_products($limit, $offset) {
        $query = $this->db->select('products.pro_id, products.pro_price, pro_title, img_name, img_path')
                          ->from('product_images')
                          ->join('products', 'product_images.pro_id = products.pro_id', 'inner')
                          ->limit($limit, $offset)
                          ->group_by('products.pro_id')
                          ->get();
                        //   select products.pro_id, pro_title, img_name, img_path
                        //   from product_images 
                        //   inner join products
                        //   on product_images.pro_id = products.pro_id
                        //   GROUP BY products.pro_id;
                        // echo '<pre>';
                        // print_r($query->result_array()); exit;
        return $query->result_array();
    }

    public function get_products_rows() {
        $query = $this->db->select('products.pro_id, products.pro_price, pro_title, img_name, img_path')
                          ->from('product_images')
                          ->join('products', 'product_images.pro_id = products.pro_id', 'inner')
                          ->group_by('products.pro_id')
                          ->get();
                        //   select products.pro_id, pro_title, img_name, img_path
                        //   from product_images 
                        //   inner join products
                        //   on product_images.pro_id = products.pro_id
                        //   GROUP BY products.pro_id;
                        // echo '<pre>';
                        // print_r($query->result_array()); exit;
        return $query->num_rows();
    }

    public function categorized_products($id, $limit, $offset) {
        // echo $id; exit;
        $query = $this->db->select('products.pro_id, products.pro_price, pro_title, img_name, img_path')
                          ->from('product_images')
                          ->join('products', 'product_images.pro_id = products.pro_id', 'inner')
                          ->where('pro_cat', $id)
                          ->limit($limit, $offset)
                          ->group_by('products.pro_id')
                          ->get();

        // print_r($query->result_array()); exit;
        return $query->result_array();
    }

    public function categorized_products_rows($id) {
        // echo $id; exit;
        $query = $this->db->select('products.pro_id, products.pro_price, pro_title, img_name, img_path')
                          ->from('product_images')
                          ->join('products', 'product_images.pro_id = products.pro_id', 'inner')
                          ->where('pro_cat', $id)
                          ->group_by('products.pro_id')
                          ->get();

        // print_r($query->result_array()); exit;
        return $query->num_rows();
    }

    public function get_product_details($id) {
        // SELECT * FROM products
        // INNER JOIN categories 
        // ON products.pro_cat = categories.cat_id
        // INNER JOIN users
        // on products.user_id = users.id
        // WHERE products.pro_id = 48;

        // 'products.pro_id, products.pro_title, products.pro_cat, products.pro_desc, products.pro_price, products.rent_period, products.pro_pincode, products.pro_address,
        // categories.cat_name, users.first_name, users.last_name, users.email, users.phone_no
                                  


        $query = $this->db->select('products.pro_id, products.user_id, products.pro_title, products.pro_desc, products.pro_price,                                          
                                    products.rent_period, products.pro_pincode, products.pro_address, products.created_at,
                                    categories.cat_name, users.first_name, users.last_name, users.email, users.phone_no')
                          ->from('products')
                          ->join('categories', 'products.pro_cat = categories.cat_id', 'inner')
                          ->join('users', 'products.user_id = users.id', 'inner')
                          ->where('pro_id', $id)
                          ->get();

        // echo '<pre>';
        // print_r($query->result_array()); exit;
        return $query->result_array();
    }

    public function get_product_images($id) {
        $query = $this->db->select('img_path, img_name')->from('product_images')->where('pro_id', $id)->get();
        return $query->result_array();
    }

    public function user_ads($id) {
        $query = $this->db
                      ->select('product_images.img_name, product_images.img_path,
                                products.pro_id, products.pro_title, products.created_at')
                      ->from('product_images')
                      ->join('products', 'products.pro_id = product_images.pro_id', 'inner')
                      ->where('user_id', $id)
                      ->group_by('products.pro_id')
                      ->get();
                      
        return $query->result_array();
    }

    public function search_db($search_query) {
        // SELECT products.pro_id, products.pro_title, products.pro_price, product_images.img_name, product_images.img_path
        // FROM products 
        // INNER JOIN product_images
        // ON products.pro_id = product_images.pro_id
        // WHERE products.pro_title OR products.pro_desc LIKE '%ham%'

        $query = $this->db
                      ->select('products.pro_id, products.pro_title, pro_price, img_name, img_path')
                      ->from('products')
                      ->join('product_images', 'products.pro_id = product_images.pro_id')
                      ->like('products.pro_title', $search_query)
                      ->like('products.pro_desc', $search_query)
                      ->group_by('products.pro_id')
                      ->get();

        // echo '<pre>'; print_r($query->result_array()); exit;
        return $query->result_array();
    }


}