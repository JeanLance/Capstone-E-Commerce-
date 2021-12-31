$(document).ready(function() {
    /* Event (submit) : Clickin th add to cart button displays a pop up message saying "Item Add to Cart" */
    $(document).on('submit', 'form#user-action', function() {
        /* Ajax Call */
        $.post($(this).attr('action'), $(this).serialize(), function(res) {
            $('#cart-item-count').text(res);
        });
        if ($('#add-msg').is(':visible') == false) {
            $('#add-msg').slideToggle('fast', function() {
                $(this).delay(2000).fadeToggle();
            });
        }
        return false;
    });

    /* Creates 4 additonal option on the select field.
        first option was set to '2' because select field already has it's first option
    */
    $(document).find('select#quantity').each(function() {
        let product_price = parseFloat($(this).children().first().attr('data-price'));
        for(let i = 2; i <= 5; i++) {
            $(this).append('<option value="' + i + '">' + i + ' ($' + (product_price * i).toFixed(2) + ')</option>')
        }
    });
});