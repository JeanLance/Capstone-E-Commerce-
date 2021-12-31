<?php
defined('BASEPATH') OR exit('No direct script access allowed');

    class Orders extends CI_Controller {

        /* Method: Dashboard Orders page. Displays the details of a specified order */
        public function show($id = 1) {
            $data = array(
                "id" => $id
            );
            $this->load->view('includes/header_partial');
            $this->load->view('admin/order_details', $data);
        }

        public function ordersFilter() {
            // Some Codes
        }

        public function orderStatus() {
            // Some Codes
        }
    }