$(document).ready(function() {
    //list member
    searchMember();
    // click on search
    $(document).on('click', '#btn-search',function() {
        search(0);
    });

    // click add member
    $(document).on('click', '#btn-add',function() {
        addMember(1);
    });

    // click update member
    $(document).on('click', '#btn-update',function() {
        addMember(0);
    });

    // click delete member
    $(document).on('click', '#btn-delete',function() {
        var userId = $(this).parents('tr').find('.userId').html().trim();
        deleteMember(userId);
    });

    // position team
    $(document).on('click', '.users',function() {
        // $(this).addClass('users-current');
        var userId = $(this).val();
        positionTeam(userId);

    });

    // position team edit
    $(document).on('click', '#btn-edit-member',function() {
        // $(this).addClass('users-current')
        var userId = $(this).parents('tr').find('.userId').html().trim();
        positionTeam(userId);

    });


    // change team
    $(document).on('change', '#teamId',function() {
       searchMember();
    });

    //handel pagination by ajax
    $(document).on('click', '.search.pagination a',function(event){
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        search(page);
    });
});

function search(page) {
    var teamId = $('#team').val();
    url = '/admin/teams/search';
    if(page != 0){
        url = '/admin/teams/search?page='+page;
    }

    var skills = [];
    $('.skills:checked').each(function() {
        skills.push($(this).val());
    });

    var teamId = $('#teamId').val();
    var levels = [];
    $('.levels:checked').each(function() {
        levels.push($(this).val());
    });

    $.ajax({
        type : 'POST',
        url : url,
        dataType : 'json',
        data : {
            skills : skills,
            levels : levels,
            teamId : teamId
        },
        success:function(data) {
            $('#result-member').html();
            if(data.result) {
                $('#result-member').html(data.html);
            }
        }
    });
}

function addMember(flag) {
    var positions = [];
    $('.position:checked').each(function() {
        positions.push($(this).val());
     });
    // console.log(positions);
    if(positions != []) {
        var teamId = $('#teamId-postion').val();
        var userId = $('#userId-postion').val();
        console.log(userId);
        $.ajax({
            type : 'POST',
            url : '/admin/teams/store-member',
            dataType : 'json',
            data : {
                teamId : teamId,
                userId : userId,
                positions : positions,
                flag :flag
            },
            success:function(data) {
                if(data.result) {
                    if(flag == 1 ) {
                        alert(trans['msg_insert_succes']);
                    } else {
                        alert(trans['msg_update_succes']);
                    }

                    $.colorbox.close();
                    searchMember();
                } else {
                    if(flag == 1 ) {
                        alert(trans['msg_insert_fail']);
                    } else {
                        alert(trans['msg_update_fail']);
                    }
                }
            }
        });
    } else {
        alert(trans['msg_positions_required']);
    }
}

function positionTeam(userId) {
    var teamId = $('#teamId').val();

    $.ajax({
        type : 'POST',
        url : '/admin/teams/position-team',
        dataType : 'json',
        data : {
            teamId : teamId,
            userId : userId,
        },
        success:function(data) {
            $.colorbox({html : data.html});
            $.colorbox.resize();
        }
    });
}

function searchMember() {
    var teamId = $('#teamId').val();

    $.ajax({
        type : 'POST',
        url : '/admin/teams/search-member',
        dataType : 'json',
        data : {
            teamId : teamId
        },
        success:function(data) {
            $('#result-list-member').html(data.html);
        }
    });
}

function deleteMember(userId) {
    var teamId = $('#teamId').val();
    $.ajax({
        type : 'POST',
        url : '/admin/teams/delete-member',
        dataType : 'json',
        data : {
            teamId : teamId,
            userId : userId,
        },
        success:function(data) {
            if(data.result) {
                alert(trans['msg_delete_succes']);
                $.colorbox.close();
                searchMember();
            } else {
                alert(trans['msg_delete_fail']);
            }
        }
    });
}
