<?php
defined('BASEPATH') OR exit('No direct script access allowed');

    class Category extends CI_Model {
        
        /* Method: Fetch all category */
        public function fetch_all() {
            return $this->db->query('SELECT * FROM categories')->result_array();
        }

        /* Method: Fetch all data by user id (SESSION) */
        public function fetch_all_with_product_count() {
            $query = 'SELECT categories.id, categories.category, COUNT(products.id) as category_count
                        FROM categories
                        LEFT JOIN products
                            ON categories.id = products.category_id
                        GROUP BY categories.category;';
            return $this->db->query($query)->result_array();
        }

        /* Method: Fetch all category data with specified row count, used on pagination */
        public function fetch_specified_row($row_count) {
            return $this->db->query('SELECT * FROM categories LIMIT ?', array((int)$this->security->xss_clean($row_count)))->result_array();
        }

        /* Method: Fetch all category and products data with specified row count, used on pagination */
        public function fetch_specified_row_with_product_count($row_count) {
            $query = 'SELECT categories.id, categories.category, COUNT(products.id) as category_count
                        FROM categories
                        LEFT JOIN products
                            ON categories.id = products.category_id
                        GROUP BY categories.category
                        LIMIT ?;';
            $value = array((int)$this->security->xss_clean($row_count));
            return $this->db->query($query, $value)->result_array();
        }

        /* Method: Fetch all category by id */
        public function fetch_by_id($id) {
            return $this->db->query('SELECT * FROM categories WHERE id = ?', array($this->security->xss_clean($id)))->row_array();
        }

        /* Method: Fetch all category by name */
        public function fetch_by_name($category_name) {
            return $this->db->query('SELECT * FROM categories WHERE category = ?', array($this->security->xss_clean($category_name)))->row_array();
        }

        /* Method: Query Add */
        public function add($category) {
            return $this->db->query('INSERT INTO categories (category, created_at) VALUES (?, ?)', array(ucwords($this->security->xss_clean($category)), date("Y-m-d H:i:s")));
        }

        /* Method: Query Edit */
        public function edit($id, $post_data) {
            $query = 'UPDATE categories SET category = ?, updated_at = ? WHERE id = ?';
            $values = array(
                $this->security->xss_clean($post_data['edit_category']),
                date("Y-m-d H:i:s"),
                $id);
            return $this->db->query($query, $values);
        }

        /* Method: Checks if category exists */
        public function category_exists($category_name) {
            $category = $this->fetch_by_name($category_name);
            if ($category == NULL) {
                $this->add($category_name);
            }
            return $this->fetch_by_name($category_name);
        }
    }