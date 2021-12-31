    <div class="container">
        <?= form_open('orders/ordersFilter', 'class="filter-tab"')?>
            <input type="search" name="search" placeholder="Search">
            <select name="status">
                <option value="all">Show All</option>
                <option value="in_process">Order in Process</option>
                <option value="shipped">Shipped</option>
                <option value="cancelled">Cancelled</option>
            </select>
        </form>
        <table>
            <thead>
                <th>Order ID</th>
                <th>Name</th>
                <th>Date</th>
                <th>Billing Address</th>
                <th>Total</th>
                <th>Status</th>
            </thead>
            <tbody>
                <tr class="row-odd">
                    <td><a href="<?= base_url()?>/orders/show/<?= '50'?>">50</a></td>
                    <td>User Name</td>
                    <td>12/31/2021</td>
                    <td>123 dojo way Bellevue WA 98005</td>
                    <td>$99.99</td>
                    <td>
                        <select name="status" form="edit-status">
                            <option value="in_process">Order in Process</option>
                            <option value="shipped">Shipped</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><a href="<?= base_url()?>/orders/show/<?= '100'?>">100</a></td>
                    <td>User Name</td>
                    <td>12/31/2021</td>
                    <td>123 dojo way Bellevue WA 98005</td>
                    <td>$99.99</td>
                    <td>
                        <select name="status" form="edit-status">
                            <option value="in_process">Order in Process</option>
                            <option value="shipped">Shipped</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </td>
                </tr>
            </tbody>
        </table>
        <?= form_open('orders/orderStatus', 'id="edit-status"')?></form>
        <div class="pagination-links" id="orders-page-link">
            <span>
<?php   for ($i = 1; $i <= 1; $i++) { ?>
                <a class="<?= $i == 1 ? 'active-anchor-link' : "" ?>" href="<?= base_url()?>products/<?=$i?>"><?= $i?></a>
<?php   } ?>
            </span>
        </div>
    </div>
</body>
</html>
<script>
    document.title = '<?= "(Dashboard Orders) - Admin"?>';
    $('title').attr('data-title-name', 'orders');
    $('head').append('<link rel="stylesheet" type="text/css" href="/assets/css/dashboard_orders1.css">');
</script>