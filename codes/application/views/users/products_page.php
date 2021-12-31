    <div class="container">
        <div id="filter-tab">
            <?= form_open('products/category/0', 'id="form-products-search"')?>
                <input id="search" type="search" name="search">
                <span id="search-btn" class="search-button"><img src="/assets/img/search-button-bg.png" alt="Search Button Image"></span>
            </form>
            <p>Categories</p>
            <ul id="categories">
                <li><a class="categories-link" href="0" title="All Products">All Products</a></li>
<?php       foreach($categories as $category) { ?>
                <li><a class="categories-link" href="<?= $category['id']?>" title="<?= $category['category']?>"><?= $category['category'] ?> (<?= $category['category_count']?>)</a></li>
<?php       } ?>
                <li><a id="show-all-categories" class="italic" href="<?=base_url()?>products/showAllCategories">Show All</a></li>
            </ul>
        </div>
        <div id="products-tab">
            <div class="items-link">
                <h2><span id="page-category">All Products</span> (<span class="category-current-page">1</span>)</h2>
                <ul id="short-page-links" class="pagination-links">
                    <li><a id="first-page" href="1">first</a></li>
                    <li><a id="prev-page" href="1">prev</a></li>
                    <li><a id="current-page" href="#">1</a></li>
                    <li><a id="next-page" href="2">next</a></li>
                </ul>
            </div>
            <form id="form-sort" method="post">
                <span id="sort">Sorted by 
                    <select id="sort-field" name="sort" form="form-products-search">
                        <option value="popular">Most Popular</option>
                        <option value="highest_price">Highest to Lowest Price</option>
                        <option value="lowest_price">Lowest to Lowest Price</option>
                    </select>
                </span>
            </form>
            <!-- Container for dynamically added nodes of products/items -->
            <div id="items-and-page-link">
            </div>
        </div>
    </div>
<script src="/assets/js/products.js"></script>
<script>
    document.title = '<?= "(Products Page)"?>';
    $('head').append('<link rel="stylesheet" type="text/css" href="/assets/css/products1.css">');
</script>
</body>
</html>