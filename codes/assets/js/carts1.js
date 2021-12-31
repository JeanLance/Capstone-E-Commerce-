$(document).ready(function() {
    /* Event (click) : clicking/checking a checkbox enables the checkout button. Otherwise, it disables it.
        Updates the prices indicated on the checkout button
    */
    $('.check-item').click(function() {
        if ($('.check-item').is(':checked')) {
            $('#checkout-btn').prop('disabled', false);
            $('#checkout-btn').css({'border': '2px solid #111', 'background-color': 'rgb(8, 155, 255)'});
        }
        else {
            $('#checkout-btn').prop('disabled', true);
            $('#checkout-btn').css({'border': '2px solid #888', 'background-color': 'rgb(145, 211, 255)', 'cursor': 'default'});
        }

        let checkout_total = 0;

        $(document).find('.check-item').each(function() {
            if ($(this).is(':checked')) {
                checkout_total += parseFloat($(this).attr('data-price'));
            }
        })
        $('#checkout-btn').val('Checkout ($' + checkout_total + ')');
    });

    /* Event (click) : Clicking the update button dislays a input field which the user can use to change the
        quantity of items they want to purchase
    */
    $(document).on('click', 'a.update-item', function() {
        $(document).find('.quantity').each(function() {
            $('.quantity').children().children('.done').hide();
            $('.quantity').children().children('.update-item').show();
        });

        $(this).hide();
        $(this).siblings('.done').show();

        let parent_sibling = $(this).parent().prev();

        parent_sibling.children('.update-item').hide();
        parent_sibling.children('.done').attr('name', 'quantity');
        parent_sibling.children('.done').show();

        $('#form-edit-cart').attr('action', $(this).attr('href'));
        return false;
    });

    /* Event (submit) : Submits the update request of the user using an Ajax call */
    $(document).on('submit', 'form#form-edit-cart', function() {
        /* Ajax Call */
        $.post($(this).attr('action'), $(this).serialize());
        return false;
    });

    /* Event (click) : Clicking the done button submits the form. Also hides the input field and display the updated
        quantity of the product
    */
    $(document).on('click', 'a.done', function() {
        $('form#form-edit-cart').submit();

        $(this).hide();
        $(this).siblings('.update-item').show();

        let parent_sibling = $(this).parent().prev();
        
        parent_sibling.children('.update-item').show();
        parent_sibling.children('.update-item').text(parent_sibling.children('.done').val());
        parent_sibling.children('.done').attr('name', 'null');
        parent_sibling.children('.done').hide();
        
        return false;
    });

    /* Event (change) : When the input field (name="quantity") is changed, it alters all the data
        of the product (price, total price, and the cart total price)
    */
    $(document).on('change', '#quantity-field', function() {
        let this_total_price = $(this).parent().parent().siblings('.product-total-price');
        let this_price = $(this).parent().parent().siblings('.price').attr('data-price');

        this_total_price.children('.item-total-price').text( ( parseFloat(this_price) * parseFloat($(this).val()) ).toFixed(2) );
        this_total_price.children('input').attr('data-price',  ( parseFloat(this_price) * parseFloat($(this).val()) ).toFixed(2) )

        let cart_total_price = 0;
        $(document).find('.item-total-price').each(function() {
            cart_total_price += parseFloat($(this).text());
        });

        $('#cart-total').text(cart_total_price.toFixed(2));
    });

    /* Event (click) : Runs a Ajax call on action Delete. Also dynamically updates page displayed (number of products displayed) */
    $(document).on('click', 'a.delete-item', function() {
        /* Ajax Call */
        $.ajax({url: $(this).attr('href')});
        $(this).parent().parent().parent('tr').remove();
        $(document).find('#cart-item-count').text( parseInt($('#cart-item-count').text()) - 1 );
        return false;
    });
});