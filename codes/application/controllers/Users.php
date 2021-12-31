<?php
defined('BASEPATH') OR exit('No direct script access allowed');

    class Users extends CI_Controller {

        /* Method: Redirects to login page. */
        public function index() {
            redirect('login');
        }

        /* Method: Login page. Includes some of the validation errors for the form. */
        public function login() {
            $data = array();

            if ($this->session->flashdata('user_not_found') != NULL) {
                $data['user_not_found'] = $this->session->flashdata('user_not_found');
            }
            if ($this->session->flashdata('password_incorrect') != NULL) {
                $data['password_incorrect'] = $this->session->flashdata('password_incorrect');
            }
            if ($this->session->flashdata('unauthorize') != NULL) {
                $data['unauthorize'] = $this->session->flashdata('unauthorize');
            }

            $this->load->view('users/login_page', $data);
        }

        /* Method: Login process. Validates the input of the user who filled the login form. */
        public function loginProcess() {
            $formAction = "login";
            $postData = $this->input->post();

            if ($this->User->validate_post($formAction, $postData) != 'success') {
                $this->load->view('users/login_page');
            }
            else {
                if ($this->User->fetch_by_email($postData['email']) == NULL) {
                    $this->session->set_flashdata('user_not_found', 'User Not Found!');
                    redirect('login');
                }

                $user = $this->User->fetch_by_input_password($postData);
                if ($user == NULL) {
                    $this->session->set_flashdata('password_incorrect', 'Password is Incorrect!');
                    redirect('login');
                }
                if ($user['is_admin'] == 1) {
                    $this->session->set_flashdata('unauthorize', 'Sorry, but that was an unauthorize login!');
                    redirect('login');
                }
                $sess_data = array(
                    "user_id" => $user['id'],
                    "user_level" => $user['is_admin'],
                    "user_fn" => $user['first_name'],
                    "user_ln" => $user['last_name'],
                    "cart_count" => count($this->Cart->fetch_all($user['id']))
                );
                $this->session->set_userdata($sess_data);
                redirect('products');
            }
        }

        /* Method: Register page. */
        public function register() {
            $this->load->view('users/register_page');
        }

        /* Method: Register process. Validates the input of the user who filled the registration form. */
        public function registerProcess() {
            $formAction = "register";
            $postData = $this->input->post();

            if ($this->User->validate_post($formAction, $postData) != 'success') {
                $this->load->view('users/register_page');
            }
            else {
                $user_id = $this->User->register($postData);
                $user = $this->User->fetch_by_id($user_id);
                $data = array("email" => $user['email']);
                $this->load->view('users/register_success', $data);
            }
        }

        /* Method: Logout process. Redirects to login page and unset sessions. */
        public function logout() {
            $session_array = array('user_id', 'user_level', 'user_fn', 'user_ln', 'cart_count');
            $this->session->unset_userdata($session_array);
            redirect('users');
        }

        /* Custom valiations for Phone Number. Used on the model User */
        public function valid_number($str){   
            if($str[0] != 0 || $str[1] != 9) {
                $this->form_validation->set_message('valid_number', 'Please follow the correct format. (e.g. 09xxxxxxxxx)');
                return false;
            }   
            return true;
        }
    }