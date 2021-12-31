<?php
defined('BASEPATH') OR exit('No direct script access allowed');

    class Admin extends CI_Controller {

        /* Method: Identifies if the appropriate user has logged in on the page. Redirection depends on the validation
            of the login attempt
        */
        public function index() {
            if ($this->session->has_userdata('user_level') && $this->session->userdata('user_level') == 1) {
                redirect('dashboard/orders');
            }
            else if ($this->session->has_userdata('user_level') && $this->session->userdata('user_level') != 1) {
                redirect('logout');
            }
            redirect('admin/login');
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

            $this->load->view('admin/login_page', $data);
        }

        /* Method: Login process. Validates the input of the user who filled the login form. */
        public function loginProcess() {
            $formAction = "login";
            $postData = $this->input->post();

            if ($this->User->validate_post($formAction, $postData) != 'success') {
                $this->load->view('admin/login_page');
            }
            else {
                if ($this->User->fetch_by_email($postData['email']) == NULL) {
                    $this->session->set_flashdata('user_not_found', 'User Not Found!');
                    redirect('admin/login');
                }

                $user = $this->User->fetch_by_input_password($postData);
                if ($user == NULL) {
                    $this->session->set_flashdata('password_incorrect', 'Password is Incorrect!');
                    redirect('admin/login');
                }
                if ($user['is_admin'] != 1) {
                    $this->session->set_flashdata('unauthorize', 'Sorry, but that was an unauthorize login!');
                    redirect('admin/login');
                }
                $sess_data = array(
                    "user_id" => $user['id'],
                    "user_level" => $user['is_admin']
                );
                $this->session->set_userdata($sess_data);
                redirect('dashboard/orders');
            }
        }
        
        /* Method: Logout process. Redirects to login page and unset sessions. */
        public function logout() {
            $session_array = array('user_id', 'user_level');
            $this->session->unset_userdata($session_array);
            redirect('admin');
        }
    }