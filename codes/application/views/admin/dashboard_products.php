    <div class="container">
        <?= form_open('products/productsFilter/1', 'id="form-filter-tab" class="filter-tab"')?>
            <input type="search" name="search" placeholder="Search">
            <a class="hover-shadow" id="add-product" href="<?= base_url()?>dashboard/productModal/Add">Add new product</a>
        </form>
        <!-- Container for table and page links -->
        <table>
            <thead>
                <th>Displayed Image</th>
                <th>ID</th>
                <th>Category</th>
                <th>Name</th>
                <th>Price</th>
                <th>Inventory Count</th>
                <th>Quality Sold</th>
                <th>Action</th>
            </thead>
            <tbody id="tbody-contents">
            </tbody>
        </table>
        <div class="pagination-links" id="orders-page-link">
            <span>
<?php   for ($i = 1; $i <= $page_count; $i++) { ?>
                <a class="<?= $i == 1 ? 'active-anchor-link' : "" ?>" href="<?= base_url()?>products/<?=$i?>"><?= $i?></a>
<?php   } ?>
            </span>
        </div>
    </div>
    <!-- Container for modal of adding or editing of product -->
    <div id="modal-container"></div>
    <span id="error-msgs"><?= isset($errors) ? $errors : "";?></span>
    <!--------------------------------------------------------->
<script src="/assets/js/dashboard_products.js"></script>
<script>
    document.title = '<?= "(Dashboard Products) - Admin"?>';
    $('title').attr('data-title-name', 'products');
    $('head').append('<link rel="stylesheet" type="text/css" href="/assets/css/dashboard_products.css">');
</script>
</body>
</html>