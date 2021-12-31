    <div class="container">
        <a href="<?= base_url() ?>products">Go Back</a>
        <h2><?= isset($product_name) && $product_name != NULL ? $product_name : "Product Name not specified";?></h2>
        <h5><?= isset($category) && $category != NULL ? $category : "Category not specified";?></h5>
        <div id="item-details">
            <div class="item-images">
                <span id="main-img-box">
<?php           if (isset($main_img) && isset($item_preview)) { ?>
                    <img class="image-1" src="/tmp_upload/<?= $main_img?>" alt="Primary Image" title="<?= $main_img?>">
<?php           }
                else if (isset($main_img)) { ?>
                    <img class="image-1" src="/products_img/<?= $category?>/<?= $main_img?>" alt="Primary Image" title="<?= $main_img?>">
<?php           }
                else { ?>                                               <!-- Display substitute image if no image was set -->
                    <img class="image-1" src="/assets/img/dummy_img.jpg" alt="Substitue Primary Image">
<?php           } ?>
                </span>
                <span id="item-img-collection">
<?php           if (isset($secondary_imgs) && isset($item_preview)) { 
                    foreach($secondary_imgs as $img) { ?>
                        <img class="image-1" src="/tmp_upload/<?= $img?>" alt="Secondary Image" title="<?= $img?>">
<?php               }
                }
                else if (isset($secondary_imgs)) {
                    foreach($secondary_imgs as $img) { ?>
                        <img class="image-1" src="/products_img/<?= $category?>/<?= $img?>" alt="Secondary Image" title="<?= $img?>">
<?php               }
                }
                else { ?>                                               <!-- Display substitute image if no image was set -->
                    <img class="image-1" src="/assets/img/dummy_img.jpg" alt="Substitue Secondary Image">
<?php           } ?>
                </span>
            </div>
            <div class="item-description">
                <?= isset($description) && $description != NULL ? $description : "Description not specified.";?>
            </div>
        </div>
        <!-- Add to Cart Actions -->
        <div id="user-action-form">
            <?= form_open('carts/add', 'id="user-action"')?>
                <span>
                    <input type="hidden" name="id" value="<?= isset($id) ? $id : "";?>">
                    <select id="quantity" name="quantity">
                        <option data-price="<?= isset($price) && $price != NULL ? $price : "0";?>" value="1">1 <?= isset($price) && $price != NULL ? "($" . $price . ")" : "($19.99)";?></option>
                    </select>
<?php               if (isset($_SESSION['user_id'])) { ?>
                        <input class="hover-shadow" type="submit" name="add-cart" value="Add to Cart">
<?php               } ?>
                </span>
            </form>
        </div>
        <!-- Similar items displayed if a user has visited the site. 
            (Means that when admin is previewing this page, it won't display the similar items) 
        -->
<?php   if (!isset($item_preview) && isset($similar_products)) { ?>
        <div id="similar-items">
            <h3>Similar Items</h3>
<?php       foreach($similar_products as $product) { ?>
                <span class="sim-item">
                    <a href="<?= base_url()?>products/show/<?= $product['id']?>">
                    <div class="img-box">
                        <!-- <img src="/assets/img/dummy_img.jpg" alt="Dummy Image"> -->
                        <img src="/products_img/<?= $product['category']?>/<?= $product['primary_img']?>" alt="Secondary Image" title="<?= $product['primary_img']?>">
                        <span class="item-price">$<?= $product['price']?></span>
                    </div>
                    <span class="item-name"><?= $product['name']?></span>
                    </a>
                </span>
<?php       } ?>
        </div>
<?php   } ?>
    </div>
    <div id="add-msg">
        <p>Item added to cart</p>
    </div>
</body>
</html>
<script src="/assets/js/items2.js"></script>
<script>
    document.title = '<?= "(Products Page) *Item* | Dojo eCommerce"?>';
    $('head').append('<link rel="stylesheet" type="text/css" href="/assets/css/items1.css">');
</script>