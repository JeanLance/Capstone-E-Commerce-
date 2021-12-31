<!-- Deletion of category partial/confirmation message -->
<?php   if ($action == "delete_category_partial") { ?>
            <div id="delete-dialog-wrapper">
                <div id="delete-dialog">
                    <span id="delete-dialog-header"><span class="close-dialog">X</span></span>
                    <p>Do you want to delete category <span class="bold"><?= $category_name ?></span>?</p>
                    <a class="hover-shadow" id="delete-category" href="<?= base_url()?>categories/delete">Yes</a>
                    <a class="hover-shadow close-dialog" id="close-dialog">No</a>
                </div>
            </div>
<?php   } ?>

<!-- Upload Image partial. Used when an Ajax call is requested. Dispalys image details in a list -->
<?php   if ($action == "upload_image_partial") { ?>
            <li>
                <span class="img-sort-dragger"><img src="/assets/img/menu-icon.png" alt="Draggable Icon"></span>
                <span class="list-img-box" title="<?= $img_name?>"><img class="image-1" src="/<?= $img_path?>" alt="<?= $img_raw_name?>"> <?= $img_name?></span>
                <input type="hidden" name="secondary_img[]" value="<?= $img_name?>">
                <span class="delete-img-box" data-file-path="<?= $img_full_path?>" title="Delete Image"></span>
                <span class="main-img-box" title="Main Image"><input type="checkbox" name="main_img" value="<?= $img_name?>">main</span>
            </li>
<?php   } ?>

<!-- Upload Image partial. Used when editing a product. Broughts back all it's product to the edit product modal as a list -->
<?php   if ($action == "edit_product_image_partial") { 
            foreach($item_array as $item) { ?>
            <li>
                <span class="img-sort-dragger"><img src="/assets/img/menu-icon.png" alt="Draggable Icon"></span>
                <span class="list-img-box" title="<?= $item['img_name']?>"><img class="image-1" src="/<?= $item['img_name'] != "sub_img.jpg" ? $item['img_path'] : "products_img/" . $item['img_name']?>" alt="<?= $item['img_raw_name']?>"> <?= $item['img_name']?></span>
                <input type="hidden" name="secondary_img[]" value="<?= $item['img_name']?>">
                <span class="delete-img-box" data-file-path="<?= $item['img_full_path']?>" title="Delete Image"></span>
                <span class="main-img-box" title="Main Image"><input type="checkbox" name="main_img" value="<?= $item['img_name']?>">main</span>
            </li>
<?php       }
        } ?>