$(document).ready(function() {
    // //click on menu
    // $(document).on('click', '.menu-left-bar li', function() {
    //     //remove class active
    //     $('.menu-left-bar li').removeClass('active');
    //     // add class active
    //     $(this).addClass('active');
    // });
    jQuery(window).resize(function() {
            jQuery.colorbox.resize({width:"90%"});
        });
    //click logout
    $(document).on('click', '#btn-logout', function(event) {
        event.preventDefault();
        $('#logout-form').submit();
    });
});
