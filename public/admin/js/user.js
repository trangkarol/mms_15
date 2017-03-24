$(document).ready(function(){
	// click on search
    $(document).on('click','#btn-search',function(){
        search(0);
    });
    //handel pagination by ajax
    $(document).on('click','.search.pagination a',function(event){
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        search(page);
    });

    //handel pagination by ajax
    $(document).on('click','.btn-add-skill',function(event){
        addSkill($(this), 1);
    });

    //handel pagination by ajax
    $(document).on('click','.btn-edit-skill',function(event){
        addSkill($(this), 0);
    });

    //handel pagination by ajax
    $(document).on('click','.btn-delete-skill',function(event){
        addSkill($(this), 2);
    });

    // position team
    $(document).on('click', '.team',function(event) {
        // $(this).addClass('users-current');
        var teamId = $(this).val();
        positionTeam(teamId, 1);

    });

    // position team
    $(document).on('click', '.btn-edit-team',function(event) {
        // $(this).addClass('users-current');
        var teamId = $(this).parents('tr').find('.teamId').html().trim();
        positionTeam(teamId, 0);

    });

    // position team
    $(document).on('click', '.btn-delete-team',function(event) {
        var teamId = $(this).parents('tr').find('.teamId').html().trim();
        positionTeam(teamId, 2);
    });

    // position team
    $(document).on('click', '#btn-add-team',function(event) {
        addTeam(event, 1);
    });

    // position team
    $(document).on('click', '#btn-update-team',function(event) {
        addTeam(event, 0);
    });

    // position team
    $(document).on('click', '#btn-delete-team',function(event) {

        console.log('ddd');
        deleteTeam(event);
    });

});

function search(page) {
	var teamId = $('#team').val();
	url = '/admin/users/search';
	if(page != 0){
		url = '/admin/users/search?page='+page;
	}

	$.ajax({
        type: 'POST',
        url: url,
        dataType: 'json',
        data: {
        	teamId:teamId
        },
       	success:function(data){
          	$('#result-users').html();
          	$('#result-users').html(data.html);
          	$('.pagination').addClass('search');
          	if(page != 0){
          		location.hash='?page='+page;
          	}
        }
    });
}

function addSkill(event, flag) {
    var skill = event.parents('tr').find('.skillId').html().trim();
    var exeper = event.parents('tr').find('.exeper').val();
    var level = event.parents('tr').find('.level').val();
    var userId = $('#userId').val();

    $.ajax({
        type: 'POST',
        url: '/admin/users/add-skill',
        dataType: 'json',
        data: {
            skill : skill,
            exeper : exeper,
            level : level,
            userId : userId,
            flag : flag,
        },
        success:function(data){
            $('#result-skill').html();
            $('#result-skill').html(data.html);

            if(flag == 1) {
                event.parents('tr').remove();
            }
        }
    });
}

function positionTeam(teamId, flag) {
    var userId = $('#userId').val();

    $.ajax({
        type : 'POST',
        url : '/admin/users/position-team',
        dataType : 'json',
        data : {
            teamId : teamId,
            userId : userId,
            flag : flag,
        },
        success:function(data) {
            $.colorbox({html : data.html});
        }
    });
}

function addTeam(event,flag) {
    var teamId = $('#teamId-postion').val();
    var userId = $('#userId-postion').val();

    var positions = [];
    $('.position:checked').each(function() {
        positions.push($(this).val());
    });

    $.ajax({
        type : 'POST',
        url : '/admin/users/add-team',
        dataType : 'json',
        data : {
            teamId : teamId,
            userId : userId,
            positions : positions,
            flag : flag,
        },
        success:function(data) {
            if(data.result) {
                    if(flag == 1 ) {
                        alert(trans['msg_insert_succes']);
                    } else {
                        alert(trans['msg_update_succes']);
                    }

                    $('#result-team').html();
                    $('#result-team').html(data.html);
                    //remove team curren
                    // event.parents('div').remove();
                } else {
                    if(flag == 1 ) {
                        alert(trans['msg_insert_fail']);
                    } else {
                        alert(trans['msg_update_fail']);
                    }
                }
                $.colorbox.close();

        }
    });
}

function deleteTeam(event) {
    var teamId = $('#teamId-postion').val();
    var userId = $('#userId-postion').val();

    var positions = [];
    $('.position:checked').each(function() {
        positions.push($(this).val());
    });

    $.ajax({
        type : 'POST',
        url : '/admin/users/delete-team',
        dataType : 'json',
        data : {
            teamId : teamId,
            userId : userId,
            positions : positions,
        },
        success:function(data) {
            console.log('trang');
            if(data.result) {
                    alert(trans['msg_delete_succes']);

                    $.colorbox.close();

                    $('#result-team').html();
                    $('#result-team').html(data.html);
                    //remove team curren
                    event.remove;
                } else {
                    alert(trans['msg_delete_fail']);
                }
        }
    });
}
