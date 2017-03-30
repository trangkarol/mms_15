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

    // delelete skill
    $(document).on('click', '#btn-delete-skill', function(event) {
        event.preventDefault();
        bootbox.confirm('Are you want to delete?', function(result){
            if(result) {
                $('#form-delete-skill').submit();
            }
        });
    });

    // delelete position
    $(document).on('click', '#btn-delete-position', function(event) {
        event.preventDefault();
        bootbox.confirm('Are you want to delete?', function(result){
            if(result) {
                $('#form-delete-position').submit();
            }
        });
    });

    // delelete activity
    $(document).on('click', '#btn-delete-activity', function(event) {
        event.preventDefault();
        bootbox.confirm('Are you want to delete?', function(result){
            if(result) {
                $('#form-delete-activity').submit();
            }
        });
    });

});
