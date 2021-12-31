<?php
defined('BASEPATH') OR exit('No direct script access allowed');

    class Dashboard extends CI_Controller {

        /* Method: Redirects to orders page(dashboard) */
        public function index() {
            redirect('dashboard/orders');
        }

        /* Method: Orders page (Dashboard). Displays view file of orders dashboard */
        public function orders($page = 1) {
            $this->load->view('includes/header_partial');
            $this->load->view('admin/dashboard_orders');
        }

        /* Method: Products page (Dashboard). Displays view file of product dashboard */
        public function products($page = 1) {
            $data = array(
                "categories" => $this->Category->fetch_all(),
                "products" => $this->Product->fetch_all_with_category()
            );

            $data['page_count'] = ceil(count($data['products']) / 5);   // Used for page pagination
            
            $this->load->view('includes/header_partial');
            $this->load->view('admin/dashboard_products', $data);
        }

        /* Method: Creates a modal from a partial file (dashboard_products_modal.php) which is requested from the
            products dashboard page. Modal is altered by the action of the admin. Add Product or Edit Product
        */
        public function productModal($action, $id = 0) {
            $data = array(
                "action" => $action,        // 'Add' or 'Edit'
                "id" => $id,
                "categories" => $this->Category->fetch_all()
            );

            if ($action == "Edit") {
                $this->Product->create_temp_image($id);
                $product = $this->Product->fetch_by_id($id);
                $data['name'] = $product['name'];
                $data['description'] = $product['description'];
                $data['price'] = $product['price'];
                $data['stock'] = $product['stock'];
            }

            $this->load->view('includes/dashboard_products_modal', $data);
        }

        /* Method: Passes form data to the model to process the upload of the image */
        public function uploadImagePartial() {
            $uploadResult = $this->Product->upload_image('file');
            if ($uploadResult != NULL) {
                $path = explode("/", $uploadResult['full_path']);
                $data = array(
                    "action" => "upload_image_partial",
                    "img_file" => $_FILES,
                    "img_name" => $uploadResult['file_name'],
                    "img_raw_name" => $uploadResult['raw_name'],
                    "img_path" => $path[ count($path) - 2 ] . "/" . $path[ count($path) - 1 ],
                    "img_full_path" => $uploadResult['full_path']
                );
                $this->load->view('includes/dashboard_partials', $data);
            }
        }

        /* Method: Creates a partial which will be reuested from the client side of the website when the admin
            want's the edit a specified product.
        */
        public function getProductImagePartial($id = 0) {
            if ($id != 0) {
                $product = $this->Product->fetch_by_id($id);
                $img_array = array_merge((array) $product['primary_img'], explode(', ', $product['secondary_imgs']));
                $list_array = array();
                $temp_dir = $this->cl->projectImgTmpDir();
    
                foreach($img_array as $key => $value) {
                    $without_ext = $this->cl->removeExt($value);
                    $list_array[$key] = array(
                            "img_name" => $value,
                            "img_raw_name" => $without_ext,
                            "img_path" => 'tmp_upload/' . $value,
                            "img_full_path" => $temp_dir . $value
                    );
                }
    
                $data = array(
                    "action" => "edit_product_image_partial",
                    "item_array" => $list_array
                );
    
                $this->load->view('includes/dashboard_partials', $data);
            }
        }

        /* Method: Deletes specified image via path/dir */
        public function deleteImg() {
            unlink($this->input->post('filePath'));
        }
        
        /* Method: Deletes all temp files uploaded. Uses custom library */
        public function deleteTempFile() {
            $this->cl->deleteTempFiles();
        }

        /* Method: Opens new tab to display the preview of image being edited or added */
        public function previewProduct() {
            $postData = $this->input->post();
            $data = array(
                "product_name" => $postData['name'],
                "description" => $postData['description'],
                "category" => $postData['category'],
                "price" => $postData['price'],
                "item_preview" => true
            );

            if (isset($postData['main_img']))
                $data["main_img"] = $postData['main_img'];

            if (isset($postData['secondary_img'])) {
                foreach($postData['secondary_img'] as $secondary_imgs) {
                    if (isset($postData['main_img']) && $secondary_imgs != $postData['main_img']) {
                        $data["secondary_imgs"][] = $secondary_imgs;
                    }
                    else if (!isset($postData['main_img'])){            // Set the main/primary image as the first secondary image if main image isn't specified
                        $data["secondary_imgs"][] = $secondary_imgs;
                    }
                }
            }

            $this->load->view('includes/header_partial');
            $this->load->view('users/item_page', $data);
        }
    }