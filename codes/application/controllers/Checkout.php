<?php
defined('BASEPATH') OR exit('No direct script access allowed');

    class Checkout extends CI_Controller {
        
        /* Method: Checkout page. Displays the checkout page which includes the shipping and billing information form
            and also the stripe payment method form.
        */
        public function index() {
            $this->load->view('includes/header_partial');
            $this->load->view('users/checkout_page');
        }
    }