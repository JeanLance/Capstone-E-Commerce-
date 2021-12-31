/* Alters the form action function call */
function alterFormActionByPage(element) {
    let form_action = $('#form-products-search').attr('action');
    let action_arr = form_action.split('/');

    /* Alter the form action attribute to add the page number by identifying if its the first page to be clicked
        or not
    */
    if (action_arr[action_arr.length - 2] == "category") {
        $('#form-products-search').attr('action', form_action + "/" + element.attr('href'));
    }
    else if (action_arr[action_arr.length - 3] == "category") {
        $('#form-products-search').attr('action', form_action.slice(0, -1) + element.attr('href'));
    }
    $('form#form-products-search').submit();
}

/* Change the preview page value */
function prevPage(element) {
    if (element.text() == 1) {
        $('#prev-page').attr('href', 1)
    }
    else {
        $('#prev-page').attr('href', parseInt(element.attr('href')) - 1)
    }
}

/* Change the next page value */
function nextPage(element) {
    let page_count = element.parent().find('a').length;
    if (element.attr('href') == page_count) {
        $('a#next-page').attr('href', page_count);
    }
    else {
        $('a#next-page').attr('href', parseInt(element.attr('href')) + 1);
    }
}

$(document).ready(function() {
    /* EVent (submit) : Submit the product search form and alters the URL */
    $(document).on('submit', 'form#form-products-search', function() {
        /* Ajax Call */
        $.post($(this).attr('action'), $(this).serialize(), function(res){
            $('#items-and-page-link').html(res);
        });
        
        // Change the url every time the form us submitted to dispaly the category id and page number (based on form action)
        let url = $(this).attr('action').replace('http://localhost:80/', '');
        window.history.pushState("object or string", "Title", "/" + url);

        return false;
    });

    $('form#form-products-search').submit();

    /* Events (change, keyup, search) : Submits the form every time the search input field is updated
        or being updated
    */
    $(document).on('change keyup search', 'input#search, select#sort-field', function(){
        $('form#form-products-search').submit();
    });

    /* Default URL, used when changing the url string when changing category and page when using an Ajax call */
    let default_search_action = $('#form-products-search').attr('action');

    /* Event (click) : Clicking a category (link) changes the form action and submit's it to make a request 
        with it's id (category id)
    */
    $(document).on('click', 'a.categories-link', function(){
        $('#form-products-search').attr('action', default_search_action.slice(0, -1) + $(this).attr('href'));
        $('a#current-page').text(1);
        $('#page-category').text($(this).attr('title'));
        $('span#category-current-page').text(1);
        $('form#form-products-search').submit();
        return false;
    });

    /* Event (click) : Request a partial file from the service using an Ajax call, containing all categories */
    $(document).on('click', 'a#show-all-categories', function(){
        /* Ajax Call */
        $.get($(this).attr('href'), function(res){
            $('#categories').html(res);
        });
        return false;
    });

    /* Event (click) : Navigates to the specified page clicked by the user, displaying list of products */
    $(document).on('click', '#items-page-link span a', function() {
        prevPage($(this));
        $('a#current-page').text($(this).text());
        $('span.category-current-page').text($(this).text());
        nextPage($(this));

        alterFormActionByPage($(this));
        return false;
    });

    /* Event (click) : Display's the very first list of products on the page pagination */
    $('a#first-page').click(function() {
        $('#items-page-link span a').first().click();
        return false;
    });

    /* Event (click) : Display's the previous list of products on the page pagination */
    $('a#prev-page').click(function() {
        $('#items-page-link').find('a.active-anchor-link').prev().click();
        return false;
    });

    /* Event (click) : Display's the next list of products on the page pagination */
    $('a#next-page').click(function() {
        $('#items-page-link').find('a.active-anchor-link').next().click();
        return false;
    });
});