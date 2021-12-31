<?php
defined('BASEPATH') OR exit('No direct script access allowed');

    class Cart extends CI_Model {

        /* Method: Fetch all data */
        public function fetch_all($user_id) {
            return $this->db->query('SELECT * FROM carts WHERE user_id = ?', array($this->security->xss_clean($user_id)))->result_array();
        }

        /* Method: Fetch products on the cart with category */
        public function fetch_all_with_product_category_info($user_id) {
            $query = 'SELECT carts.*, products.name AS product_name, products.price AS product_price, products.primary_img, categories.category
                        FROM carts
                        LEFT JOIN products
                            ON carts.product_id = products.id
                        LEFT JOIN categories
                            ON products.category_id = categories.id
                        WHERE carts.user_id = ?;';
            return $this->db->query($query, array($this->security->xss_clean($user_id)))->result_array();
        }

        /* Method: Add Query */
        public function add($user_id, $id, $quantity) {
            $query = 'INSERT INTO carts (user_id, product_id, quantity, created_at) VALUES (?, ?, ?, ?);';
            $values = array(
                $this->security->xss_clean($user_id),
                $this->security->xss_clean($id),
                $this->security->xss_clean($quantity),
                date("Y-m-d H:i:s")
            );
            return $this->db->query($query, $values);
        }

        /* Method: Edit Query */
        public function edit($user_id, $id, $quantity) {
            $query = 'UPDATE carts SET quantity = ?, updated_at = ? WHERE id = ? AND user_id = ?;';
            $values = array(
                $this->security->xss_clean($quantity),
                date("Y-m-d H:i:s"),
                $this->security->xss_clean($id),
                $this->security->xss_clean($user_id)
            );
            return $this->db->query($query, $values);
        }

        /* Method: Delete Query */
        public function delete($user_id, $id) {
            return $this->db->query('DELETE FROM carts WHERE id = ? AND user_id = ?', array($this->security->xss_clean($id), $this->security->xss_clean($user_id)));
        }
    }