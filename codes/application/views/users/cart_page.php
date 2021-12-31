    <div class="container">
        <table>
            <thead>
                <th>Image</th>
                <th>Item</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
            </thead>
            <tbody>
            <?= form_open('checkout', 'id="form-checkout"')?>
<?php   if (isset($carts)) {
            $row = 1;
            foreach($carts as $cart) { 
                $row % 2 == 1 ? $row_class = "row-odd" : $row_class = "" ;?>
                <tr class="<?= $row_class?>">
                <!-- Change directory to access the sub-img(substitute image) file if no actual image was specified by the admin -->
<?php           if ($cart['primary_img'] != "sub_img.jpg") { ?>
                    <td><img class="image-1" src="/products_img/<?= $cart['category'] ?>/<?= $cart['primary_img']?>" alt="<?= $cart['primary_img']?>" title="<?= $cart['primary_img']?>"></td>
<?php           }
                else { ?>
                    <td><img class="image-1" src="/products_img/<?= $cart['primary_img']?>" alt="<?= $cart['primary_img']?>" title="<?= $cart['primary_img']?>"></td>
<?php           }?>
                    <td><?= $cart['product_name']?></td>
                    <td class="price" data-price="<?= $cart['product_price']?>">$<?= $cart['product_price']?></td>
                    <td class="quantity">
                        <span>
                            <span class="update-item"><?= $cart['quantity']?></span>
                            <input id="quantity-field" class="done" type="number" min="1" name="null" value="<?= $cart['quantity']?>" form="form-edit-cart" hidden>
                        </span>
                        <span>
                            <a class="update-item" href="<?= base_url()?>carts/update/<?= $cart['id']?>">update</a>
                            <a class="done" href="#" hidden>Done</a>
                        </span>
                        <span><a class="delete-item" href="<?= base_url()?>carts/delete/<?= $cart['id']?>"><img src="/assets/img/delete-icon.png" alt="Delete Icon/Button"></a></span>
                    </td>
                    <td class="product-total-price">
                        $<span class="item-total-price"><?= $cart['product_price'] * $cart['quantity']?></span>
                        <input class="check-item" type="checkbox" name="checked_products[]" data-price="<?= $cart['product_price'] * $cart['quantity']?>" value="<?= $cart['id']?>">
                    </td>
                </tr>
<?php           $row++;
            }
        } 
        else { ?>
                <tr class="row-odd">
                    <td>Cart is Empty</td>
                </tr>
<?php   } ?>
            </form>
            <?= form_open('carts/update', 'id="form-edit-cart"'); form_close()?>
            </tbody>
        </table>
        <div id="user-cart-total">
            <a class="hover-shadow" href="<?= base_url()?>products">Continue Shopping</a>
            <span>
                <!-- Total amount of items -->
                Cart Total Amount: $<span id="cart-total"><?= $total?></span>
                <input id="checkout-btn" class="hover-shadow" type="submit" name="checkout" value="Checkout ($0)" form="form-checkout" disabled>
            </span>
        </div>
    </div>
<script src="/assets/js/carts1.js"></script>
<script>
    document.title = '<?= "(Carts Page) Shopping Cart | Dojo eCommerce"?>';
    $('head').append('<link rel="stylesheet" type="text/css" href="/assets/css/carts2.css">');
</script>
</body>
</html>