    <div class="container">
        <div id="customer-details">
            <p>Order ID: <?= $id?></p>
            <ul>
                <p>Customer Shipping Info:</p>
                <li>Name: bob</li>
                <li>Address: 123 dojo way</li>
                <li>City: seatle</li>
                <li>State: wa</li>
                <li>Zip: 98133</li>
            </ul>
            <ul>
                <p>Customer Billing Info:</p>
                <li>Name: bob</li>
                <li>Address: 123 dojo way</li>
                <li>City: seatle</li>
                <li>State: wa</li>
                <li>Zip: 98133</li>
            </ul>
        </div>
        <div id="order-details">
            <table>
                <thead>
                    <th>ID</th>
                    <th>Item</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </thead>
                <tbody>
                    <tr class="row-odd">
                        <td>35</td>
                        <td>cup</td>
                        <td>$9.99</td>
                        <td>1</td>
                        <td>$9.99</td>
                    </tr>
                    <tr>
                        <td>32</td>
                        <td>cup</td>
                        <td>$5.99</td>
                        <td>2</td>
                        <td>$11.98</td>
                    </tr>
                </tbody>
            </table>
            <div id="status-tab">
                <span class="status in-process">Status: <?= 'shipped'?></span>
            </div>
            <div id="total-summary-tab">
                <span class="total">
                    <p>Sub total: $29.98</p>
                    <p>Shipping: $1.00</p>
                    <p>Total Price: $30.98</p>
                </span>
            </div>
        </div>
    </div>
</body>
</html>
<script>
    document.title = '<?= "(Dashboard Orders) - Admin"?>';
    $('title').attr('data-title-name', 'orders');
    $('head').append('<link rel="stylesheet" type="text/css" href="/assets/css/order_details.css">');
</script>