<?php
defined('BASEPATH') OR exit('No direct script access allowed');

    class Main extends CI_Controller {
        
        /* Method: Redirects to product page which was set as the main page because a homepage isn't created yet */
        public function index() {
            redirect('products');
        }
    }