<!-- Show all categories. Used when "Show All" categories was requested from an Ajax call -->
<?php   if ($action == "show_all_categories") { ?>
                <li><a class="categories-link" href="0">All Products</a></li>
<?php       foreach($categories as $category) { ?>
                <li><a class="categories-link" href="<?= $category['id']?>" title="<?= $category['category']?>"><?= $category['category'] ?> (<?= $category['category_count']?>)</a></li>
<?php       }
        } ?>

<!-- Partial for all items on the products page. Dyncamically created elements/nodes -->
<?php   if ($action == "products-tab" && isset($products)) { ?>
            <div id="items">
<?php       foreach($products as $product) { ?>
                <span class="item">
                    <a href="<?= base_url()?>products/show/<?= $product['id']?>">
                        <div class="img-box">
                            <img src="/products_img/<?= $product['category']?>/<?= $product['primary_img']?>" alt="<?= $product['primary_img']?>" title="<?= $product['primary_img']?>">
                            <span class="item-price">$<?= $product['price']?></span>
                        </div>
                        <span class="item-name"><?= $product['name']?></span>
                    </a>
                </span>
<?php       } ?>
            </div>
            <div class="pagination-links" id="items-page-link">
                <span>
<?php           for ($i = 1; $i <= $page_count; $i++) { ?>
                    <a class="<?= $i == $page ? 'active-anchor-link' : "" ?>" href="<?=$i?>"><?= $i?></a>
<?php           } ?>
                </span>
            </div>
<?php   } ?>