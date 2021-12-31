<?php
defined('BASEPATH') OR exit('No direct script access allowed');

    class Carts extends CI_Controller {
        
        /* Method: Cart page. Redirects to cart page with data of the cart of users. */
        public function index() {
            $data = array("carts" => $this->Cart->fetch_all_with_product_category_info($_SESSION['user_id']));
            $total = 0;
            foreach($data['carts'] as $cart) {
                $total += $cart['product_price'] * $cart['quantity'];
            }
            $data['total'] = $total;

            $this->load->view('includes/header_partial');
            $this->load->view('users/cart_page', $data);
        }

        /* Method: Add. Passes form data to model which processes the add of cart. */
        public function add() {
            $postData = $this->input->post();
            $this->Cart->add($_SESSION['user_id'], $postData['id'], $postData['quantity']);
            $cart_count = count($this->Cart->fetch_all($_SESSION['user_id']));
            $_SESSION['cart_count'] = $cart_count;
            echo $cart_count;           // IMPORTANT: Used to display the appropriate nubmers of cart when adding an item dynamically (Ajax)
        }
        
        /* Method: Update. Passes form data to model which processes the update of cart. */
        public function update($id = 0) {
            $postData = $this->input->post();
            $this->Cart->edit($_SESSION['user_id'], $id, $postData['quantity']);
        }

        /* Method: Delete. Redirects some data to model to model to delete the particular item. */
        public function delete($id) {
            $this->Cart->delete($_SESSION['user_id'], $id);
            $this->session->set_userdata('cart_count', $this->session->userdata('cart_count') - 1);
        }
    }