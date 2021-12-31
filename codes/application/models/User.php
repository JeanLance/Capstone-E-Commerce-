<?php
defined('BASEPATH') OR exit('No direct script access allowed');

    class User extends CI_Model {

        /* Custom validation error message */
        public function __construct() {
            parent::__construct();
            $this->form_validation->set_message('is_unique', '"{field}" is already used by a user. Please use another "{field}".');
            $this->form_validation->set_message('required', '"{field}" field cannot be empty.');
            $this->form_validation->set_message('matches', '"{field}" field does not match "{param}" field.');
            $this->form_validation->set_message('min_length', '"{field}" field must contain atleast {param} characters.');
        }

        /* Method: Fetch all users */
        public function fetch_all() {
            return $this->db->query('SELECT * FROM users')->result_array();
        }

        /* Method: Fetch user by id */
        public function fetch_by_id($id) {
            return $this->db->query('SELECT * FROM users WHERE id = ?', array($this->security->xss_clean($id)))->row_array();
        }

        /* Method: Fetch user by email */
        public function fetch_by_email($email) {
            return $this->db->query('SELECT * FROM users WHERE email = ?', array($this->security->xss_clean($email)))->row_array();
        }

        /* Method: Fetch user by contact number */
        public function fetch_by_cont_num($contact_number) {
            return $this->db->query('SELECT * FROM users WHERE contact_number = ?', array($this->security->xss_clean($contact_number)))->row_array();
        }

        /* Method: Fetch user by password. Used for access validation */
        public function fetch_by_input_password($data) {
            $query = 'SELECT * FROM users WHERE email = ? AND password = ?';
            $values = array(
                $this->security->xss_clean($data['email']),
                md5($this->security->xss_clean($data['password']))
            );
            return $this->db->query($query, $values)->row_array();
        }
        
        /* Method: Validate post input on login and register process */
        public function validate_post($form_action, $data) {
            if ($data[$form_action] == NULL) {
                redirect($form_action);
            }
            
            if ($form_action == 'register') {
                $this->form_validation->set_rules('first_name', 'First Name', 'trim|required|alpha_numeric_spaces');
                $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|alpha_numeric_spaces');
                $this->form_validation->set_rules('email', 'Email', 'trim|required|is_unique[users.email]');
                $this->form_validation->set_rules('contact_number', 'Contact No.', 'trim|required|numeric|min_length[11]|is_unique[users.contact_number]|callback_valid_number');
                $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
                $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|min_length[6]|matches[password]');
            }
            else {
                $this->form_validation->set_rules('email', 'Email', 'trim|required');
                $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
            }

            $validation = "invalid";
            if ($this->form_validation->run())
            {
                $validation = 'success';
            }
            return $validation;
        }

        /* Method: Process to register the user and returns their ID */
        public function register($data) {
            $user_count = $this->fetch_all();
            $user_level = 0;
            if (count($user_count) == 0) {
                $user_level = 1;
            }

            $query = "INSERT INTO users (first_name, last_name, contact_number, email, password, is_admin, created_at)
                        VALUES (?, ?, ?, ?, ?, ?, ?)";
            $values = array(
                ucwords($this->security->xss_clean($data['first_name'])),
                ucwords($this->security->xss_clean($data['last_name'])),
                $this->security->xss_clean($data['contact_number']),
                $this->security->xss_clean($data['email']),
                md5($this->security->xss_clean($data['password'])),
                $user_level,
                date("Y-m-d H:i:s")
            );

            $this->db->query($query, $values);

            return $this->db->insert_id();
        }
    }