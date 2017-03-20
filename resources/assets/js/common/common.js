$(document).ready(function() {
    //click on menu
    $(document).on('click', '.menu-left-bar li', function() {
        //remove class active
        $('.menu-left-bar li').removeClass('active');
        // add class active
        $(this).addClass('active');
    });
});
