<?php
defined('BASEPATH') OR exit('No direct script access allowed');

    class Categories extends CI_Controller {
        
        /* Method: Opens up the category delete modal / confirmation box to be displayed using a Ajax */
        public function deleteModal($id = 0) {
            $category = $this->Category->fetch_by_id($id);
            $data = array(
                "action" => "delete_category_partial",
                "category_name" => $category['category']
            );
            $this->load->view('includes/dashboard_partials', $data);
        }

        /* Method: Edit. Passes form data to the model to process the update of the category */
        public function edit($id = 0) {
            $postData = $this->input->post();
            $this->Category->edit($id, $postData);
        }
    }