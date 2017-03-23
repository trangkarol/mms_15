$(document).ready(function() {
    //click on menu
    $(document).on('click', '.menu-left-bar li', function() {
        //remove class active
        $('.menu-left-bar li').removeClass('active');
        // add class active
        $(this).addClass('active');
    });

    //click logout
    $(document).on('click', '#btn-logout', function() {
        event.preventDefault();
        $('#logout-form').submit();
    });
});
