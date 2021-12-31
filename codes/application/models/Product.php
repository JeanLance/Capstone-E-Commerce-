<?php
defined('BASEPATH') OR exit('No direct script access allowed');

    class Product extends CI_Model {

        /* Method: Fetch all products */
        public function fetch_all() {
            return $this->db->query('SELECT * FROM products')->result_array();
        }

        /* Method: Fetch product by id */
        public function fetch_by_id($id) {
            return $this->db->query('SELECT * FROM products WHERE id = ?', array($this->security->xss_clean($id)))->row_array();
        }

        /* Method: Fetch product by id */
        public function fetch_all_with_category() {
            $query = 'SELECT products.*, categories.category
                        FROM products
                        LEFT JOIN categories
                        ON  products.category_id = categories.id';
            return $this->db->query($query)->result_array();
        }

        /* Method: Fetch all product with it's category and have a specified limit */
        public function fetch_all_with_category_and_limit($limit) {
            $query = "SELECT products.*, categories.category
                        FROM products
                        LEFT JOIN categories
                        ON  products.category_id = categories.id
                        {$limit}";
            return $this->db->query($query)->result_array();
        }

        /* Method: Fetch product(s) by name */
        public function fetch_by_name($data) {
            return $this->db->query("SELECT * FROM products WHERE name LIKE '%".$this->security->xss_clean($data['search'])."%'")->result_array();
        }

        /* Method: Fetch product(s) by name with it's category */
        public function fetch_by_name_with_category($data) {
            $query = "SELECT products.*, categories.category
                        FROM products
                        LEFT JOIN categories
                        ON  products.category_id = categories.id
                        WHERE name LIKE '%".$this->security->xss_clean($data['search'])."%'";
            return $this->db->query($query)->result_array();
        }

        /* Method: Fetch product(s) by name with category and specified limit */
        public function fetch_by_name_with_category_and_limit($data, $limit) {
            $query = "SELECT products.*, categories.category
                        FROM products
                        LEFT JOIN categories
                        ON  products.category_id = categories.id
                        WHERE name LIKE '%".$this->security->xss_clean($data['search'])."%'
                        {$limit}";
            return $this->db->query($query)->result_array();
        }

        /* Method: Fetch product by id with it's category */
        public function fetch_by_id_with_category($id) {
            $query = "SELECT products.*, categories.category
                        FROM products
                        LEFT JOIN categories
                        ON  products.category_id = categories.id
                        WHERE products.id = ?";
            return $this->db->query($query, array($this->security->xss_clean($id)))->row_array();
        }

        /* Method: Fetch product by category id and it's category (name) */
        public function fetch_by_category_id_with_category($id) {
            $query = "SELECT products.*, categories.category
                        FROM products
                        LEFT JOIN categories
                        ON  products.category_id = categories.id
                        WHERE products.category_id = ?";
            return $this->db->query($query, array($this->security->xss_clean($id)))->result_array();
        }

        /* Method: Fetch product using a query builder. (Includes it's categories) */
        public function fetch_by_search_with_category($data_query, $values) {
            $query = "SELECT products.*, categories.category
                        FROM products
                        LEFT JOIN categories
                        ON  products.category_id = categories.id
                        {$data_query}";
            return $this->db->query($query, $values)->result_array();
        }

        /* Method: Fetch product using a query builder. (Includes it's categories and a specified limit) */
        public function fetch_by_search_with_category_and_limit($data_query, $values, $limit) {
            $query = "SELECT products.*, categories.category
                        FROM products
                        LEFT JOIN categories
                        ON  products.category_id = categories.id
                        {$data_query}
                        {$limit}";
            return $this->db->query($query, $values)->result_array();
        }

        /* Method: Add Query */
        public function add($data, $category_id) {
            $query = 'INSERT INTO products (category_id, name, description, price, stock, primary_img, secondary_imgs, created_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
            $values = array(
                $this->security->xss_clean($category_id),
                $this->security->xss_clean($data['name']),
                $this->security->xss_clean($data['description']),
                $this->security->xss_clean($data['price']),
                $this->security->xss_clean($data['stock']),
                $this->security->xss_clean($data['main_img']),
                $this->security->xss_clean($data['secondary_img']),
                date("Y-m-d H:i:s")
            );
            return $this->db->query($query, $values);
        }

        /* Method: Edit Query */
        public function edit($data, $category_id) {
            $query = "UPDATE products SET category_id = ?, name = ?, description = ?, price = ?, stock = ?, primary_img = ?, secondary_imgs = ?, updated_at = ? WHERE id = ?";
            $values = array(
                $this->security->xss_clean($category_id),
                $this->security->xss_clean($data['name']),
                $this->security->xss_clean($data['description']),
                $this->security->xss_clean($data['price']),
                $this->security->xss_clean($data['stock']),
                $this->security->xss_clean($data['main_img']),
                $this->security->xss_clean($data['secondary_img']),
                date("Y-m-d H:i:s"),
                $this->security->xss_clean($data['id']),
            );
            return $this->db->query($query, $values);
        }

        /* Method: Delete Query */
        public function delete($id) {
            return $this->db->query('DELETE FROM products Where id = ?', array($this->security->xss_clean($id)));
        }

        /* Method: Query Builder (WHERE ORDER BY) for products search */
        public function search_product_query_builder($data, $category_id) {
            $query = "";

            // WHERE QUERY CLAUSE
            $where = array();
            $values = array();

            if (isset($data['search']) && $data['search'] != NULL) {
                $where[] = 'name LIKE ?';
                $values[] = "%{$this->security->xss_clean($data['search'])}%";
            }
            if ($category_id != 0) {
                $where[] = 'category_id = ?';
                $values[] = $this->security->xss_clean($category_id);
            }

            if (count($where) >= 1) {
                $query .= "WHERE " . implode(" AND ", $where);
            }

            // ORDER BY QUERY CLAUSE
            if ($data['sort'] == 'popular') {
                $order_by = 'ORDER BY sold DESC';
            }
            if ($data['sort'] == 'highest_price') {
                $order_by = 'ORDER BY price DESC';
            }
            if ($data['sort'] == 'lowest_price') {
                $order_by = 'ORDER BY price ASC';
            }

            $query .= " " . $order_by;  // Concatinate strings (WHERE and ORDER BY)

            return array($query, $values);
        }

        /* Query Bulder: LIMIT -- Builds a string composed of query clause LIMIT base on the active page.
		To be used later when fetching the data using Select Query.
        */
        public function filter_limit($page, $limit) {
            $row_per_page = $limit;
            $limit_start = ($page * $row_per_page) - $row_per_page;
            $query = "LIMIT {$limit_start}, {$limit}";
            return $query;
        }

        /* Method: Create a string for all files uploaded. Used to insert into the database */
        public function image_query($data) {
            if (!isset($data['main_img'])){
                if (isset($data['secondary_img']) && count($data['secondary_img']) >= 1) {
                    $data['main_img'] = $data['secondary_img'][0];
                }
                else {
                    $data['main_img'] = 'sub_img.jpg';      // If no image set by the admin
                }
            }
            if (!isset($data['secondary_img'])) {
                $data['secondary_img'] = 'sub_img.jpg';      // If no image set by the admin
            }
            else  {
                foreach($data['secondary_img'] as $key => $file_name) {
                    $data['secondary_img'][$key] = str_replace(',', "-", $file_name);
                }

                $duplicate_pos = array_search($data['main_img'], $data['secondary_img']);
                unset($data['secondary_img'][$duplicate_pos]);

                if (count($data['secondary_img']) >= 1) {
                    $data['secondary_img'] = implode(', ', $data['secondary_img']);
                }
                else {
                    $data['secondary_img'] = 'sub_img.jpg';
                }
            }

            return array('main_img' => $data['main_img'], 'secondary_img' => $data['secondary_img']);
        }

        /* Function to save temp image to the temp image directory. Used when editing a file, to dispaly it's images on the modal */
        public function save_temp_image($dir_from, $dir_to, $folder_name, $item_arr) {
            /* Checks if target dir already exists. If not, create one. */
            if ($this->cl->checkFolderExist($dir_to, $folder_name) == false) {
                $this->cl->createDIR($dir_to, $folder_name);
            }

            /* Scans the item array if the same file alreay exists on the directory.
                If a file exists, affix random digits on the file name.
            */
            $dir = $dir_to . $folder_name;
            $new_file_name = array();
            foreach($item_arr as $key => $file_name) {
                $affix_num = 0;

                while (file_exists($dir . '/' . $file_name)) {
                    $file_str = explode('.', $file_name);
                    $affix_str = "_".rand(1000,9999);
                    $file_name = $file_str[0] . $affix_str . "." . $file_str[1];

                    $new_file_name[$item_arr[$key]] = $file_name;
                    $affix_num++;
                }
            }

            if (count($new_file_name) >= 1) {               // Run this codes if same file already exists on the dir
                foreach($new_file_name as $key => $file_name) {
                    rename (
                        $dir_from . $key,
                        $dir_to . $folder_name . '/' . $file_name
                    );
                }
            }
            else {                                          // Run this codes if doesn't still exists on the dir
                foreach($item_arr as $file_name) {
                    rename (
                        $dir_from . $file_name,
                        $dir_to . $folder_name . '/' . $file_name
                    );
                }
            }
        }

        /* Method: Process to upload the image. Saves files to specified dir. Uses custom library and
            codeigniter library to upload files.
        */
        public function upload_image($file) {
            if (isset($_FILES[$file]['name'])) {
                
                $config['upload_path'] = 'tmp_upload/';
                $config['allowed_types'] = 'jpg|jpeg|png|gif';

                $this->upload->initialize($config);
                if (!$this->upload->do_upload($file)) {
                    // Some codes when upload error occured
                }
                else {
                    return $this->upload->data();
                }
            }
        }

        /* Function to copy all products images into the temp image directory. Used to display the images
            while editing the product.
        */
        public function create_temp_image($id) {
            $product = $this->fetch_by_id($id);
            $img_array = array_merge((array) $product['primary_img'], explode(', ', $product['secondary_imgs']));
            $category = $this->Category->fetch_by_id($product['category_id']);

            // Copy all images of the product into the image temp dir
            foreach($img_array as $value) {
                $from = $this->cl->projectImgDir() . $category['category'] . '/' . $value;
                $to = $this->cl->projectImgTmpDir() . $value;

                if (file_exists($from))
                    copy($from, $to);
            }
        }
    }