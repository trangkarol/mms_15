$(document).ready(function() {
	// click on search
    $(document).on('click', '#btn-search', function(){
        search(0);
    });

    // delelete
    $(document).on('click', '#btn-delete', function(event) {
        event.preventDefault();
        bootbox.confirm('Are you want to delete?', function(result) {
            if (result) {
                $('#delete-form-user').submit();
            }
        });
    });

    //handel pagination by ajax
    $(document).on('click', '.search.pagination a', function(event) {
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        search(page);
    });

    //handel pagination by ajax
    $(document).on('click', '#btn-add-skill', function(event) {
        addSkill($(this), 1);
    });

    //handel pagination by ajax
    $(document).on('click', '#btn-edit-skill', function(event) {
        addSkill($(this), 0);
    });

    // get skill
    $(document).on('click', '.skill', function(event) {
        // $(this).addClass('users-current');
        var skillId = $(this).val();
        getFormSkill(skillId, 1);
    });

    // edit skill
    $(document).on('click', '.btn-edit-skill', function(event) {
        // $(this).addClass('users-current');
        var skillId = $(this).parents('tr').find('.skillId').html().trim();
        getFormSkill(skillId, 0);
    });

    // delete skill
    $(document).on('click', '.btn-delete-skill-popup', function(event) {
        var skillId = $(this).parents('tr').find('.skillId').html().trim();
        bootbox.confirm(trans['msg_comfirm_delete'], function(result){
            if(result) {
                 deleteSkill(skillId);
            }
        });
    });

    // position team
    $(document).on('click', '.team', function(event) {
        // $(this).addClass('users-current');
        var teamId = $(this).val();
        positionTeam(teamId, 1);
    });

    // position team
    $(document).on('click', '.btn-edit-team', function(event) {
        // $(this).addClass('users-current');
        var teamId = $(this).parents('tr').find('.teamId').html().trim();
        positionTeam(teamId, 0);
    });

    // position team
    $(document).on('click', '.btn-delete-team', function(event) {
        var teamId = $(this).parents('tr').find('.teamId').html().trim();
        bootbox.confirm(trans['msg_comfirm_delete'], function(result){
            if(result) {
                deleteTeam(teamId, 2);
            }
        });
    });


    // position team
    $(document).on('click', '#btn-add-team', function(event) {
        addTeam(event, 1);
    });

    // position team
    $(document).on('click', '#btn-update-team', function(event) {
        addTeam(event, 0);
    });

    // position team
    $(document).on('click', '#btn-delete-team', function(event) {
        deleteTeam(event);
    });

    //import-file
    $(document).on('click', '#import-file', function(event) {
        // event.preventDefault();
        $('#file-csv').click();
        $('#file-csv').change(function(event) {
            $('#form-input-file').submit();
        });
    });

    $(document).on('click', '#cboxClose', function() {
        $('.skill').prop('checked',false);
        $('.team').prop('checked',false);
    });

    // save user
    $(document).on('click', '#add-user', function(event) {
        $('#form-save-user').submit();
    });

    // comfirm export
    $(document).on('click', '#export-file', function(event) {
        getComfirmExport();
    });

    // export file
    $(document).on('click', '#btn-add-export', function() {
        var type = $('.type_export:checked').val();
        exportFile(type);
    });

});

function search(page) {
	var teamId = $('#team').val();
    var position = $('#position').val();
    var positionTeams = $('#positionTeams').val();

	url = action['user_search'];
	if (page) {
		url += '?page=' + page;
	}

	$.ajax({
        type: 'POST',
        url: url,
        dataType: 'json',
        data: {
        	teamId: teamId,
            position: position,
            positionTeams: positionTeams,
        },
       	success:function(data) {
          	$('#result-users').html();
          	$('#result-users').html(data.html);
          	$('.pagination').addClass('search');
          	if (page){
          		location.hash='?page='+page;
          	}
        }
    });
}

function addSkill(event, flag) {
    var skillId = $('#skillId-skill').val();
    var userId = $('#userId-skill').val();
    var exeper = $('.exeper').val();
    var level = $('.level').val();

    $.ajax({
        type: 'POST',
        url: action['user_add_skill'],
        dataType: 'json',
        data: {
            skillId : skillId,
            exeper : exeper,
            level : level,
            userId : userId,
            flag : flag,
        },
        success:function(data){
            if (data.result) {
                $('#result-skill').html();
                $('#result-skill').html(data.html);
                $.colorbox.close();
                var messages = trans['msg_add_skill_sucess'];
                if (flag == 1) {
                    messages = trans['msg_edit_skill_sucess'];
                }

                bootbox.alert(messages);
                $('.skill:checked').parent().remove();
            } else {
                bootbox.alert(trans['msg_fail']);
            }
        }
    });
}


function deleteSkill(skillId) {
    var userId = $('#userId').val();

    $.ajax({
        type: 'GET',
        url: action['user_delete_skill'] + skillId + '/' + userId,
        dataType: 'json',
        success:function(data) {
            if (data.result) {
                bootbox.alert(trans['msg_delete_skill_sucess'], function() {
                    $('#result-skill').html();
                    $('#result-skill').html(data.html);
                });

            } else {
                bootbox.alert('Fail!');
            }
        }
    });
}

function positionTeam(teamId, flag) {
    var userId = $('#userId').val();

    $.ajax({
        type : 'POST',
        url : action['user_position_team'],
        dataType : 'json',
        data : {
            teamId : teamId,
            userId : userId,
            flag : flag,
        },
        success:function(data) {
            $.colorbox({ html: data.html });
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
        url : action['user_add_team'],
        dataType : 'json',
        data : {
            teamId : teamId,
            userId : userId,
            positions : positions,
            flag : flag,
        },
        success:function(data) {
            $.colorbox.close();
            if (data.result) {
                var messages = trans['msg_update_success'];
                if (data.flag) {
                    messages = trans['msg_insert_success'];
                }

                bootbox.alert(messages);
                $('#result-team').html();
                $('#result-team').html(data.html);
                $('.team:checked').parent().remove();

            } else {
                var messages = trans['msg_update_fail'];
                if (data.flag) {
                    messages = trans['msg_insert_fail'];
                }

                bootbox.alert(messages);
            }
        }
    });
}

function deleteTeam(teamId) {
    var userId = $('#userId').val();

    $.ajax({
        type : 'GET',
        url : action['user_delete_team'] + teamId + '/' + userId,
        dataType : 'json',
        success:function(data) {
            if (data.result) {
                    $.colorbox.close();
                    bootbox.alert(trans['msg_delete_success'], function() {
                        $('#result-team').html();
                        $('#result-team').html(data.html);
                    });
                } else {
                    bootbox.alert(trans['msg_delete_fail']);
                }
            }
    });
}

/*skill*/
function  getFormSkill(skillId, flag) {
    var userId = $('#userId').val();

    $.ajax({
        type : 'POST',
        url : action['user_get_skill'],
        dataType : 'json',
        data : {
            skillId : skillId,
            userId : userId,
            flag : flag,
        },
        success:function(data) {
            $.colorbox({ html: data.html });
        }
    });
}

function exportFile(type) {
    $('#teamId-export').attr('value', $('#team').val());
    $('#position-export').attr('value', $('#position').val());
    $('#positionTeam-export').attr('value', $('#positionTeams').val());
    $('#type-export').attr('value', type);

    $('#form-export-user').submit();
    $.colorbox.close();
}
