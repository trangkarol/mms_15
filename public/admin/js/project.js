$(document).ready(function(){
    // click on search
    $(document).on('click','#btn-search',function(){
        search(0);
    });

    // delelete
    $(document).on('click', '#btn-delete', function(event) {
        event.preventDefault();
        bootbox.confirm('Are you want to delete?', function(result){
            if(result) {
                $('#form-delete-project').submit();
            }
        });

    });
    // click on search
    $(document).on('click','.team',function(){
       var teamId = $(this).val();
       searchMember(teamId, 1);
    });

    //edit member
    $(document).on('click','.btn-edit-team',function(){
        var teamId = $(this).parents('tr').find('.teamMemberId').html().trim();
       searchMember(teamId, 0);
    });

    //delete member
    $(document).on('click','.btn-delete-team',function(){
        var teamId = $(this).parents('tr').find('.teamMemberId').html().trim();
        deleteMember(teamId, $(this));
    });

    // add tab
    $(document).on('click','#btn-add',function(){
       addMember(1);
    });

    // edit tab
    $(document).on('click','#btn-update',function(){
       addMember(0);
    });

    //handel pagination by ajax
    $(document).on('click','.search.pagination a',function(event){
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        search(page);
    });


});

function search(page) {
    var teamId = $('#team').val();
    url = '/admin/projects/search';
    if(page != 0){
        url = '/admin/projects/search?page='+page;
    }

    $.ajax({
        type: 'POST',
        url: url,
        dataType: 'json',
        data: {
            teamId:teamId
        },
        success:function(data){
            $('#result-projects').html();
            $('#result-projects').html(data.html);
            $('.pagination').addClass('search');
            if(page != 0){
                location.hash='?page='+page;
            }
        }
    });
}

function searchMember(teamId, flag) {
    var projectId = $('#projectId').val();
    url = '/admin/projects/search-member';

    $.ajax({
        type: 'POST',
        url: '/admin/projects/search-member',
        dataType: 'json',
        data: {
            teamId : teamId,
            projectId : projectId,
            flag : flag,
        },
        success:function(data){
            if(data.html != '') {
                $.colorbox({html : data.html});
            } else {
                bootbox.alert(trans['msg_empty_member']);
            }

        }
    });
}


function addMember(flag) {
    var projectId = $('#projectId-member').val();
    var teamId = $('#teamId-member').val();
    var userId = [];
    var leader = $('#leader').val();

    $('.users:checked').each(function() {
        userId.push($(this).val());
    });

    $.ajax({
        type: 'POST',
        url: '/admin/projects/add-member',
        dataType: 'json',
        data: {
            projectId : projectId,
            userId : userId,
            leader : leader,
            teamId : teamId,
            flag : flag,
        },
        success:function(data){
            if(data.result) {
                if(flag == 1 ) {
                    bootbox.alert(trans['msg_insert_success']);
                } else {
                    bootbox.alert(trans['msg_update_success']);
                }

                $.colorbox.close();
                location.reload();
            } else {
                if(flag == 1 ) {
                    bootbox.alert(trans['msg_insert_fail']);
                } else {
                    bootbox.alert(trans['msg_update_fail']);
                }

                $.colorbox.close();
            }

        }
    });
}

function deleteMember(teamId, event) {
    var projectId = $('#projectId').val();
    var members = [];

    event.parents('tr').find('.members').each(function() {
        members.push($(this).val());
    });
    console.log(members);

    $.ajax({
        type: 'POST',
        url: '/admin/projects/delete-member',
        dataType: 'json',
        data: {
            projectId : projectId,
            members : members,
            teamId : teamId,
        },
        success:function(data){
            if(data.result) {
                bootbox.alert(trans['msg_delete_success']);
                $.colorbox.close();
                location.reload();
                // searchMember();
            } else {
                bootbox.alert(trans['msg_delete_fail']);

                $.colorbox.close();
            }

        }
    });
}


function addTab() {

    $.ajax({
        type: 'GET',
        url: '/admin/projects/add-tab',
        dataType: 'json',
        success:function(data){
            var index = $('#index').val();
            var menu_tab = '<li class=""><a data-toggle="tab" href="#team'+index+'"></a></li>';
            var content_tab = ' <div id="team'+index+'" class="tab-pane fade in">';
            $('.menu-tab').prepend(menu_tab);
            $('.content-tab').prepend(content_tab+data.html+'</div>');
            //remove active
            $('.menu-tab').removeClass('active');
            $('.content-tab').removeClass('active');
            $('#team'+index).addClass('active');
            index = parseInt(index) + 1;
            $('#index').val(index);

        }
    });
}
