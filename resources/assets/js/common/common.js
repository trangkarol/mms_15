$(document).ready(function() {
    $('select.search').prepend('<option value= "0" selected>All</option>');
    jQuery(window).resize(function() {
            jQuery.colorbox.resize({width:"90%"});
        });

    $('#avatar').change(function (event) {
        //lấy path của ảnh tại client
        $(this).parent().addClass('img-current')
        var tmppath = URL.createObjectURL(event.target.files[0]);
        $('.img-current').find("img").fadeIn("fast").attr('src', URL.createObjectURL(event.target.files[0]));
        $(this).parent().removeClass('img-current')

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

function getComfirmExport() {
    $.ajax({
        type : 'GET',
        url : '/admin/common/comfirm-export',
        dataType : 'json',
        success:function(data) {
            if(data.result) {
                $.colorbox({ html : data.html });
            }
        }
    });
}
