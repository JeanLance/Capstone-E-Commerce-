var modal = document.getElementById('modal-container');

/* 
    c-select - Custom Select Class (Attached on the default select field)
    ns-field - New Select Field
    ns-options - New Select Options
*/

/* Hide the default select field element and create a new element that replaces the select element */
function customSelect(element) {
    element.hide();

    let select_html = '<div class="n-select">';
    select_html += '<span class="ns-field unselectable">' + element.val() + '</span>';
    select_html += '<ul class="ns-options">';
    $(element).find('option').each(function(){
        select_html += '<li id="c-option-id-' + $(this).attr('data-id') + '" class="unselectable" data-id="' + $(this).attr('data-id') + '" data-value="' + $(this).attr('value') + '" data-text="' + $(this).text() + '">' + $(this).text() + '</li>';
    });
    select_html += '</ul></div>';

    if ($('.n-select').length == 0) { 
        $(element).parent().append(select_html);
    }

    $('.ns-options').hide();
    customOptionToggle('.ns-field');
}

/* Updates the properties of the elements */
function customOption(element) {
    $('.ns-field').text($(element).attr('data-text'));
    $('.ns-field').click();
    $('.c-select').val($(element).attr('data-value'));
}

/* Displays custom options upon clicking the custom select field. (Event/s: "click") */
function customOptionToggle(element) {
    $(modal).on('click', element, function(event){
        event.stopPropagation();
        $('.ns-options').toggle();
    });
}

/* Call backs executed on every change the mutation observer is observerving (modal) child list */
function observeDOMCallbacks() {
    customSelect($('.c-select'));
    customOptionToggle('.ns-field');

    $('.sortable-list').sortable({
        containment: "parent",
        handle: ".img-sort-dragger"
    });

    $( "#delete-dialog" ).draggable({
        handle: '#delete-dialog-header',
        cursorAt: {left: 0, top: -50}
    });
}

/* Request a Delete confirmation box/dialog partial from the server using an Ajax Call */
function getDeleteConfirmBox(element) {
    /* Ajax Call */
    $.get(element.attr('data-href'), function(res){
        $(modal).append(res);
    });
    
    return false;
}

/* Usable function for running an Ajax Call with or without expecting results */
function ajaxPostForm(element) {
    /* Ajax Call */
    $.post(element.attr('action'), element.serialize(), function(res){
        // Codes here if expecting a result from server
    });
}

/* Request partial elements to be attached on the modal. (Image list of products) */
function product_img(id) {
    /* Ajax Call */
    $.ajax({
        url: '/dashboard/getProductImagePartial/' + id,
        success: function(res) {
            $('#img-list').append(res);
        }
    });
}

/* Document is Ready Functions */
$(document).ready(function() {

    /* (Event (click) : Ajax call to Create Modal for Adding Or Editing of a Product  */
    $(document).on('click', "td.action a, #add-product", function() {
        if ($(this).attr('id') == 'add-product') {
            /* Ajax Call */
            $.ajax({
                url: $(this).attr('href'),
                success: function(res) {
                    $(modal).html(res);
                }
            });
        }
        else {
            /* Ajax Call */
            $.get($(this).attr('href'), function(res) {
                $(modal).html(res);
            });
    
            setTimeout(product_img, 500, $(this).attr('data-id'));
        }
        $('form#form-filter-tab').submit();
        return false;
    });

    /* Event (submit) : Submits the form filter/search to retrieve list of search products/items */
    $(document).on('submit', 'form#form-filter-tab', function() {
        /* Ajax Call */
        $.post($(this).attr('action'), $(this).serialize(), function(res) {
            $('#tbody-contents').html(res);
        });
        return false;
    });

    $('form#form-filter-tab').submit();

    /* Events (change, keyup, search) : Submits form for every change of the value of searcf field */
    $(document).on('change keyup search', 'form#form-filter-tab input', function() {
        $('form#form-filter-tab').submit();
    });

    /* Event (submit) : submits the form of the modal */
    $(document).on('submit', 'form#edit-add-form', function() {
        if ($(this).attr('target') == null) {
            $.post($(this).attr('action'), $(this).serialize(), function(res){
                alert(res); // IMPORTANT : displays the message if edit/update or add of product is successful
            });
            $('form#form-filter-tab').submit();
            return false;
        }
    });

    /* Event (click) : Submits the form whem "Update" or "Add" button is click. (Modal buttons) 
        Makes an Ajax call.
    */
    $(document).on('click', '#form-action-update', function() {
        $('form#edit-add-form').submit();
    });

    /* Default URL, used when changing the url string when changing page (pagination links) when using an Ajax call */
    let default_search_action = $('form#form-filter-tab').attr('action');

    $(document).on('click', 'div#orders-page-link span a', function() {
        $('#form-filter-tab').attr('action', default_search_action.slice(0, -1) + $(this).text());
        $('form#form-filter-tab').submit();
        return false;
    });

    /*======================================================================================*/

    /* Observe the specified DOM to apply event handlers when new elements are created/loaded */
    const observe_modal = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.addedNodes.length) {
                observeDOMCallbacks();
            }
        })
    });

    observe_modal.observe(modal, {
        childList: true,
    });

    /* Change close button(s) element property on hover or mouseenter/mouseleave (Event/s: "mouseenter, mouseleave, click") */
    $(modal).on('mouseenter', '#close-modal', function(e) {
        $(this).css({'transition-duration': '0.2s', 'box-shadow': '3px 3px 3px #111', 'background-color': '#333', 'color': '#fff'});
    }).on('mouseleave', '#close-modal', function() {
        $(this).css({'box-shadow': '', 'background-color': '', 'color': '#000'});
    }).on('click', '#close-modal', function() {
        $.ajax({url: '/dashboard/deleteTempFile'});
        $('.modal-wrapper').remove();
    });


    /*=== CUSTOM SELECT AND CUSTOM OPTIONS SECTION ===*/

    /* Clicking the modal wrapper or the modal while custom options are displayed will close it.  (Event/s: "click") */
    $(modal).on('click', '.modal-wrapper, .modal', function(event) {
        event.stopPropagation();
        if ($('.ns-options').is(':visible')) {
            $('.ns-field').click();
        }
    });

    /* Clicking custom select field displays custom option. (Event/s: "click")
        Displays edit and delete of category buttons when hovering on a custom option  (Event/s: "mouseenter, mouseleave")
    */
    $(modal).on('click', 'ul.ns-options li', function(event) {
        event.stopPropagation();
        customOption($(this));
    }).on('mouseenter', 'ul.ns-options li', function() {
        let action_btns = '<span class="action-btns">';
        action_btns += '<img data-action="edit" data-href="/categories/edit/' + $(this).attr('data-id') + '" src="/assets/img/edit-icon.png" alt="Edit Category Icon">';
        action_btns += '<img data-action="delete" data-href="/categories/deleteModal/' + $(this).attr('data-id') + '" src="/assets/img/delete-icon.png" alt="Delete Category">';
        action_btns += '</span>';
        $(this).append(action_btns);
    }).on('mouseleave', 'ul.ns-options li', function() {
        $(this).find('span.action-btns').remove();
    });


    /* Clicking one of the image(buttons) hovered in the custom option field will run the following actions:
        Delete - Turns on a ajax function to get a custom confirm box
        Edit - Creates a form and input field inside the option field, enabling to edit the custom option
        (Event/s: "click")
    */
    $(modal).on('click', 'span.action-btns img, ul.ns-options li input', function(event) {
        event.stopPropagation();
        if ($(this).attr('data-action') == "delete") {
            getDeleteConfirmBox($(this));
        }
        else if ($(this).attr('data-action') == "edit") {
            let edit_html = '<form class="form-edit-category" action="' + $(this).attr('data-href') + '" method="post">';
            edit_html += '<input type="text" name="edit_category"></form>';
            $(this).parent().parent().text('').prepend(edit_html);
        }
    });

    /* Closes(remove node element) the confirmation box. (Event/s: "click") */
    $(modal).on('click', '.close-dialog', function() {
        $('#delete-dialog-wrapper').remove();
    });

    /* Upon submitting the form for editing a category, runs a ajax function to submit its content to the server. (Event/s: "submit") */
    $(modal).on('submit', 'form.form-edit-category', function(){
        ajaxPostForm($(this));
        return false;
    });

    /* Everytime a user changes the content of input form field (for editing category), it will run a ajax function
        to submit the form and apply changes on the database. (Event/s: "change, keyup")

        When user hovers-out or removes the focus on the input field, functions will run to update/change the properties
        and values of its respective default option field (Event/s: "mouseleave blur")
    */
    $(modal).on('change keyup', 'form.form-edit-category input', function() {
        $(document).ajaxStart(function() {
            $( "#loading-buffer" ).show();
        });

        $(this).parent().submit();
    }).on('mouseleave blur', 'form.form-edit-category input', function() {
        $(document).ajaxStart(function() {
            $( "#loading-buffer" ).show();
        });
        
        if ($(this).val().length == 0) {
            $(this).parent().text($(this).parent().parent().attr('data-text'));
        }
        else {
            let element_option = $(this).parent().parent().attr('id');
            
            $('#'+element_option).attr('data-value', ($(this).val()));
            $('#'+element_option).attr('data-text', ($(this).val()));
            $(this).parent().text($(this).val());

            $(modal).find('.c-select option').each(function() {
                if ($(this).attr('data-id') == $('#'+element_option).attr('data-id')) {
                    $(this).attr('value', $('#' + element_option).attr('data-value'));
                    $(this).text($('#' + element_option).attr('data-value'));
                }
            });
        }
    });

    /* Clicking one of the buttons; Add/Create new Category and Select existing category will hide the element
        and displays the other (Event/s: "click")
    */
    $(modal).on('click', '#add-category-field, #select-category-field', function() {
        if ($(this).attr('id') == "add-category-field") {
            $(this).parent().html('<input id="new-category" type="text" name="category">');
            $('.n-select').parent().append('<input class="field-btn hover-shadow" id="select-category-field" type="button" value="Select Existing Instead">');
            $('.n-select').remove();
        }
        else {
            customSelect($('.c-select'));
            customOptionToggle('.ns-field');
            $('#new-category').parent().html('<input class="field-btn hover-shadow" id="add-category-field" type="button" value="Create">');
            $(this).remove();
        }
    });

    /*=== IMAGE SECTION ===*/

    /* Events (mouseenter, mouseleave) : Displays the edit and delete icon button */
    $(modal).on('mouseenter', '#img-list li', function() {
        $(this).children('.delete-img-box').html('<a data-img-path="' + $(this).children('.delete-img-box').attr('data-file-path') + '" href="#"><img src="/assets/img/delete-icon.png" alt="Delete Image Icon"></a>');
    }).on('mouseleave', '#img-list li', function(){
        $(this).children('.delete-img-box').children().remove();
    });

    /* Events (mouseover, click) : Display the image clicked in an image overlay */
    $(modal).on('mouseover', '.image-1', function() {
        $(this).css({'cursor': 'pointer'});
    }).on('click', '.image-1', function(){
        singleImageOverlay($(this));
    });

    /* Event (click) : Unchecks other items and checkes the clicked checkbox. 
        Used to indicate the main image of the product
    */
    $(modal).on('click', '.main-img-box input', function() {
        $('.main-img-box input').prop('checked', false);
        $(this).prop('checked', true);
    });

    /* Event (click) : Deletes the specified image from the list. Makes an Ajax Call to delete the uploade file */
    $(modal).on('click', '.delete-img-box a', function() {
        $.post('/dashboard/deleteImg', {filePath: $(this).attr('data-img-path')});
        $(this).parent().parent().remove();
    });

    /* Event (click) : Shows a dialog message to confirm if the user really want to close modal */
    $(modal).on('click', '#form-action-cancel', function() {
        let confirm_cancel = confirm('Are you sure you want to cancel the edit/add of product?');
        if (confirm_cancel == true) {
            $('#close-modal').click();
        }
    });

    /* Event (click) : Triggers the click event for the input file type using the custom upload image button */
    $(modal).on('click', '#upload-btn', function() {
        $('#upload-img-field').click();
    });

    /* Event (change) : Every time the user changes the value of the input type file field (uploads an image),
        event handler is called and removes the value of the field so a new image can be uploaded again
    */
    $(modal).on('change', '#upload-img-field', function(e) {
        $('#upload-img').submit();
        $(this).val("");
    })

    /* Event (submit) : Makes an Ajax Call to dynamically upload an image. And receives results which then be 
        append on the image list
    */
    $(modal).on('submit', 'form#upload-img', function() {
        $.ajax({
            url: $(this).attr('action'),
            method: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(res) {
                $('#img-list').append(res);
            }
        });
        return false;
    });

    /* Event (click) : Alters the modal form property to open a new instead of using the same tab when previewing the
        procduts details
    */
    $(modal).on('click', '#form-action-preview', function() {
        let default_action = $('#edit-add-form').attr('action');
        let new_action = "previewProduct";

        $('#edit-add-form').attr({
            'action': new_action,
            'target': '_blank'
        });

        $('#edit-add-form').submit();

        function revertFormAttr() {
            $('#edit-add-form').attr({'action': default_action}).prop('target', null);
            $('#edit-add-form').removeAttr('target');
        }
        
        setTimeout(revertFormAttr, 0);
    });
});