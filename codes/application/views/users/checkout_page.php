    <div class="container">
        <?= form_open('checkout/order')?>
            <div id="form-tab">
                <div id="shipping-billing-info">
                    <!-- Shipping Information -->
                    <span class="shipping-info">
                        <h3>Shipping Information</h3>
                        <div></div>
                        <label>First Name: <input id="s_first_name" type="text" name="s_first_name"></label>
                        <label>Last Name: <input id="s_last_name" type="text" name="s_last_name"></label>
                        <label>Address: <input id="s_address" type="text" name="s_address"></label>
                        <label>Address 2: <input id="s_address_2" type="text" name="s_address_2"></label>
                        <label>City: <input id="s_city" type="text" name="s_city"></label>
                        <label>State: <input id="s_state" type="text" name="s_state"></label>
                        <label>Zipcode: <input id="s_zipcode" type="text" name="s_zipcode"></label>
                    </span>
                    <span class="billing-info">
                        <!-- Billing Information -->
                        <h3>Billing Information</h3>
                        <div><input id="auto-fill-bill" type="checkbox"> Same as Shipping</div>

                        <label>First Name: <input id="b_first_name" type="text" name="b_first_name"></label>
                        <label>Last Name: <input id="b_last_name" type="text" name="b_last_name"></label>
                        <label>Address: <input id="b_address" type="text" name="b_address"></label>
                        <label>Address 2: <input id="b_address_2" type="text" name="b_address_2"></label>
                        <label>City: <input id="b_city" type="text" name="b_city"></label>
                        <label>State: <input id="b_state" type="text" name="b_state"></label>
                        <label>Zipcode: <input id="b_zipcode" type="text" name="b_zipcode"></label>
                    </span>
                </div>
                <span class="divider-segment"></span>
                <div id="payment-method">
                    <!-- Card Information -->
                    <span class="card-details">
                        <h3>Payment Method</h3>
                        <label>Card: <input id="card" type="text" name="card"></label>
                        <label>Security Code: <input id="card-code" type="text" name="card_pin" placeholder="0000 0000 0000 0000"></label>
                        <label class="expiration">Expiration: 
                            <span class="card-expiry-date">
                                <input id="card-mm" type="text" name="month" maxlength="2" placeholder="mm"> / 
                                <input id="card-yyyy" type="text" name="year" maxlength="4" placeholder="yyyy">
                            </span>
                        </label>
                    </span>
                </div>
            </div>
            <section id="item-tab">
                <h3>Review Your Order</h3>
                <div id="items">
                    <span class="item">
                        <img src="/assets/img/dummy_img" alt="Dummy Image">
                        <div>
                            <p>Item name</p>
                            <input type="text" name="product_id" value="" hidden>
                            <label>Quantity: 1 <input type="number" min="0" name="quantity" value="2" hidden><a href="#">Edit</a></label>
                            <label>Price: $12.12</label>
                            <label>Total Amount: $12.12</label>
                            <input class="remove-item hover-shadow" type="button" name="remove_item" value="Remove">
                        </div>
                    </span>
                    <span class="item">
                        <img src="/assets/img/dummy_img" alt="Dummy Image">
                        <div>
                            <p>Item name</p>
                            <input type="text" name="product_id" value="" hidden>
                            <label>Quantity: 2 <input type="number" min="0" name="quantity" value="2" hidden><a href="#">Edit</a></label>
                            <label>Price: $10.00</label>
                            <label>Total Amount: $20.00</label>
                            <input class="remove-item hover-shadow" type="button" name="remove_item" value="Remove">
                        </div>
                    </span>
                </div>
                <div class="action-buttons">
                    <p>Grand Total: $32.12</p>
                    <input class="hover-shadow" type="submit" name="checkout" value="Place Order">
                </div>
            </section>
        </form>
    </div>
</body>
</html>
<script src="/assets/js/checkout1.js"></script>
<script>
    document.title = '<?= "(Checkout Page) Shopping Cart | Dojo eCommerce"?>';
    $('head').append('<link rel="stylesheet" type="text/css" href="/assets/css/checkout1.css">');
</script>