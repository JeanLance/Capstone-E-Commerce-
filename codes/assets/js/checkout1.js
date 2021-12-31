/* Checks empty field */
function checkEmpty(element) {
    return element.val() == null || element.val() == "";
}

/* Checks if input is numeric */
function checkNumeric(element) {
    return $.isNumeric(element.val());
}

/* Checks check if input has white space (space) */
function hasWhiteSpace(element) {
    return element.val().indexOf(' ') >= 0;
}

$(document).ready(function() {
    /* Event (click) : Clicking/Checking the checkbox copies all information of shipping info to billing info */
    $('#auto-fill-bill').click(function() {
        if($(this).prop('checked')) {
            $('#b_first_name').val($('#s_first_name').val());
            $('#b_last_name').val($('#s_last_name').val());
            $('#b_address').val($('#s_address').val());
            $('#b_address_2').val($('#s_address_2').val());
            $('#b_city').val($('#s_city').val());
            $('#b_state').val($('#s_state').val());
            $('#b_zipcode').val($('#s_zipcode').val());
        }
    });

    /* Events (blur, change, keyup) : Runs a field validatipn */
    $(document).on('blur change keyup', 'input', function(){
        checkEmpty($(this)) ? $(this).addClass('error') : $(this).removeClass('error');
    })

    /* Events (blur, change, keyup) : Runs a field validatipn */
    $(document).on('blur change keyup', 'input#card-code', function() {
        if ($(this).val().match(/[^0-9 ]/g)) {
            $(this).val($(this).val().replace(/[^0-9 ]/g, ''));
        }
        checkNumeric($(this)) ? $(this).removeClass('error') : $(this).addClass('error');
        hasWhiteSpace($(this)) ? $(this).removeClass('error') : "";
    });

    /* Events (blur, change, keyup) : Runs a field validatipn */
    $(document).on('blur change keyup', 'input#card-mm, input#card-yyyy', function() {
        if ($(this).attr('id') == "card-mm" && $(this).val().length != 2) {
            $(this).addClass('error')
        }
        else if ($(this).attr('id') == "card-yyyy" && $(this).val().length != 4) {
            $(this).addClass('error')
        }
        else {
            $(this).removeClass('error')
        }
        
        checkNumeric($(this)) ? $(this).removeClass('error') : $(this).addClass('error');
    });
});