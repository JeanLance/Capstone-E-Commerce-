<?php
defined('BASEPATH') OR exit('No direct script access allowed');

    class Products extends CI_Controller {

        /* Method: Redirects to products category page (main page) */
        public function index() {
            redirect('products/category');
        }

        /* Method: Opens up the item page file. Dispalying product details (name, description, category, etc.) */
        public function show($id = 1) {
            $products = $this->Product->fetch_by_id_with_category($id);
            if ($products == NULL)
                redirect('products');

            $similiar_products = $this->Product->fetch_by_category_id_with_category($products['category_id']);

            // Remove the showcased product/item to the fetched similar products/items
            foreach($similiar_products as $key => $value) {
                if ($value['id'] == $id) {
                    unset($similiar_products[$key]);
                }
            }

            $data = array(
                "id" => $products['id'],
                "product_name" => $products['name'],
                "description" => $products['description'],
                "category" => $products['category'],
                "price" => $products['price'],
                "main_img" => $products['primary_img'],
                "secondary_imgs" => explode(", ", $products['secondary_imgs']),
                "similar_products" => $similiar_products
            );

            $this->load->view('includes/header_partial');
            $this->load->view('users/item_page', $data);
        }

        /* Method: Passes data to a partial file. Used to display all categories on the product page */
        public function showAllCategories() {
            $data = array(
                "action" => 'show_all_categories',
                "categories" => $this->Category->fetch_all_with_product_count()
            );
            $this->load->view('includes/user_side_partials.php', $data);
        }

        /* Method: Displays all the product. If no category is selected. It will automatically display all products instead.
            When form is submitted (contains the information of the category, name, and page a user has specified)
        */
        public function category($category_id = 0, $page = 1) {
            $postData = $this->input->post();
            $data = array("action" => 'products-tab', "page" => $page);         // Action of which item is requested from the partial file
            $limit_per_page = 10;                                               // Limit per page
            $limit = $this->Product->filter_limit($page, $limit_per_page);		// Creates a string query for LIMIT clause

            if (!isset($postData['search'])) {
                $data['categories'] = $this->Category->fetch_specified_row_with_product_count(5);                                           // Display default number of categories displayed

                $this->load->view('includes/header_partial');
                $this->load->view('users/products_page', $data);
            }
            else {
                $query_value = $this->Product->search_product_query_builder($postData, $category_id);
                $data['products'] = $this->Product->fetch_by_search_with_category_and_limit($query_value[0], $query_value[1], $limit);      // Products displayed. With limit every page
                
                $products = $this->Product->fetch_by_search_with_category($query_value[0], $query_value[1]);
                $data['page_count'] = ceil(count($products) / $limit_per_page);
                
                $this->load->view('includes/user_side_partials.php', $data);
            }
        }

        /* Used mostly on admin side (Dashboard) */
        /* Method: Uses to display products in a table on the product dashboard page */
        public function productsFilter($page = 1) {
            $postData = $this->input->post();
            $data = array("categories" => $this->Category->fetch_all());

            $limit = $this->Product->filter_limit($page, 5);									// Creates a string query for LIMIT clause
            
            if ($postData['search'] == NULL) {
                $data['products'] = $this->Product->fetch_all_with_category_and_limit($limit);
            }
            else {
                $data['products'] = $this->Product->fetch_by_name_with_category_and_limit($postData, $limit);
            }

            $this->load->view('includes/dashboard_products_partial.php', $data);
        }

        /* Method: Process to manipulate/pass the images uploaded on the temp dir. Images are passed to the products image dir.
            Passses data to the the model to process the addition of product details into the database.
        */
        public function productAdd() {
            $postData = $this->input->post();
            $category = $this->Category->category_exists($postData['category']);
            $imgArray = $this->Product->image_query($postData);

            $postData['main_img'] = $imgArray['main_img'];
            $postData['secondary_img'] = $imgArray['secondary_img'];

            
            $img_dir = $this->cl->projectImgDir();
            $tmp_upload_dir = $this->cl->projectImgTmpDir();
            $folder_name = $category['category'];
            $img_file = array_merge((array)$postData['main_img'], explode(', ', $postData['secondary_img']));
            
            $this->Product->save_temp_image($tmp_upload_dir, $img_dir, $folder_name, $img_file);

            $this->Product->add($postData, $category['id']);
            echo "Add Success";         // IMPORTANT: Used to display a message indicating that product add was successful
        }

        /* Method: Process to manipulate/pass the images uploaded on the temp dir. Images are passed to the products image dir.
            Passses data to the the model to process the update of product details into the database.
        */
        public function productEdit() {
            $postData = $this->input->post();
            $category = $this->Category->category_exists($postData['category']);
            $imgArray = $this->Product->image_query($postData);

            $postData['main_img'] = $imgArray['main_img'];
            $postData['secondary_img'] = $imgArray['secondary_img'];

            $img_dir = $this->cl->projectImgDir();
            $tmp_upload_dir = $this->cl->projectImgTmpDir();
            $folder_name = $category['category'];
            $img_file = array_merge((array)$postData['main_img'], explode(', ', $postData['secondary_img']));
            
            $this->Product->save_temp_image($tmp_upload_dir, $img_dir, $folder_name, $img_file);

            $this->Product->edit($postData, $category['id']);
            $this->cl->deleteTempFiles();

            echo "Edit Success!";       // IMPORTANT: Used to display a message indicating that product update was successful
        }

        /* Method: Process to delete all images of the product indicated to be delete.
            Passes data to model which is used to delete the specifed product
        */
        public function productDelete($category = null, $id = 0) {
            $path = $this->cl->projectImgDir();
            $product = $this->Product->fetch_by_id($id);
            $img_file = array_merge((array)$product['primary_img'], explode(', ', $product['secondary_imgs']));

            $this->cl->deleteImageFiles($path . $category, $img_file);
            $this->Product->delete($id);
        }
    }