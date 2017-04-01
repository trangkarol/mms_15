$(document).ready(function() {

    jQuery(window).resize(function() {
            jQuery.colorbox.resize({width:"90%"});
        });
    //click logout
    $(document).on('click', '#btn-logout', function(event) {
        event.preventDefault();
        $('#logout-form').submit();
    });

     // delelete skill
    $(document).on('click', '.btn-delete-skill', function(event) {
        $(this).parents('.form-delete-skill').addClass('current');
        event.preventDefault();
        bootbox.confirm('Are you want to delete?', function(result){
            if(result) {
                $('.form-delete-skill.current').submit();
            }
        });
    });

    // delelete position
    $(document).on('click', '.btn-delete-position', function(event) {
        $(this).parents('.form-delete-position').addClass('current');
        event.preventDefault();
        bootbox.confirm('Are you want to delete?', function(result){
            if(result) {
                $('.form-delete-position.current').submit();
            }
        });
    });

    // delelete activity
    $(document).on('click', '.btn-delete-activity', function(event) {
        $(this).parents('.form-delete-activity').addClass('current');
        event.preventDefault();
        bootbox.confirm('Are you want to delete?', function(result){
            if(result) {
                $('.form-delete-activity.current').submit();
            }
        });
    });
});
