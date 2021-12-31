/* Dynamically updates the position of the laoding buffer to append it next the mouse cursor */
function positionLoadingBuffer() {
    document.onmousemove = function(e) {
        $('img#loading-buffer').css({
            'position': 'fixed',
            'top': e.pageY + "px",
            'left': (e.pageX + 10) + "px",
            'z-index': '2'
        });
    }
}

/* Displays a single image in an overlay */
function singleImageOverlay(obj) {
    var element = '<div id="view-image"><span>';
    element += '<a href="#">X</a>'
    element += '<img src="' + obj.attr('src') + '" alt="' + obj.attr('alt') + '">'
    element += '</span></div>';
    $('#image-overlayer').html(element);
}

/* Removes overlay (image) */
function removeImageOverlay(obj) {
    $(obj).remove();
}

/* Highlights the active navigation tab (clicked nav tab) */
function highlightActiveNav(obj) {
    var page_name = obj.attr('data-title-name');
    $('nav').find('ul li a').each(function() {
        if ($(this).attr('id') == page_name) {
            $(this).addClass('active-link');
        }
    });
}

$(document).ready(function(){
    
    /* Removes/Unbind the event listener ajaxStart on ajaxStop */
    $(document).ajaxStop(function() {
        $( "#loading-buffer" ).hide();
        $(document).unbind('ajaxStart');
    });

    /* Events (mosueover, click) : changes cursor into a pointer when pointing on an image that uses the function
        image overlay.
        Clicking the iamge runs the function single image overlay. Displaying it in an overlay
    */
    $(document).on('mouseover', '.image-1', function() {
        $(this).css({'cursor': 'pointer'});
    }).on('click', '.image-1', function(){
        singleImageOverlay($(this));
    });

    /* Event (click) : Removes the image overlay upon clicking the overlay itself */
    $(document).on('click', '#view-image', function() {
        removeImageOverlay($(this));
    });

    /* Event (mosueenter, mouseleave) : change the css of the element/node with the specified class */
    $(document).on('mouseenter', '.hover-shadow', function() {
        $(this).css({
            'transition-duration': '0.3s',
            'box-shadow': '3px 3px 3px #111',
            'cursor': 'pointer'
        });
    }).on('mouseleave', '.hover-shadow', function() {
        $(this).css({'box-shadow': ''});
    });
    
    /* Event (mouseover) : change the css of the element/node with the specified class */
    $('.pagination-links').find('a').on('mouseover', function() {
        $(this).css({'color': 'rgb(25, 25, 134)'});
    }).on('mouseleave', function() {
        $(this).css({'color': 'blue'});
    });

    /* Event (click) : clicking a page link (pagination) link adds a class to it. Indicating it's the active page */
    $(document).on('click', '.pagination-links span a', function(){
        $('.pagination-links span a').removeClass('active-anchor-link');
        $(this).addClass('active-anchor-link');
    });

    highlightActiveNav($('title'));
    positionLoadingBuffer();
});