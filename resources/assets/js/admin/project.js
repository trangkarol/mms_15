$(document).ready(function() {
    // click on search
    $(document).on('click', '#btn-search',function() {
        // when event search is firstly
        search(0);
    });

    // delelete
    $(document).on('click', '#btn-delete', function(event) {
        event.preventDefault();
        bootbox.confirm(trans['msg_comfirm_delete'], function(result) {
            if (result) {
                $('#form-delete-project').submit();
            }
        });

    });
    // click on search
    $(document).on('click', '.team', function() {
        $('.team').prop('checked', false);
        $(this).prop('checked', true);
        var teamId = $(this).val();
        //value 1 is event add a team
        searchMember(teamId, 1);
    });

    //edit member
    $(document).on('click', '.btn-edit-team',function() {
        var teamId = $(this).parents('tr').find('.teamMemberId').html().trim();
        //value 0 is event edit a team
        searchMember(teamId, 0);
    });

    //delete member
    $(document).on('click', '.btn-delete-team', function(event) {
        var teamId = $(this).parents('tr').find('.teamMemberId').html().trim();
        $(this).parents('tr').addClass('current-team');
        bootbox.confirm(trans['msg_comfirm_delete'], function(result){
            if (result) {
                deleteMember(teamId, $(this));
            }
        });
    });

    // add member
    $(document).on('click', '#btn-add-member', function() {
        addMember(1);
    });

    // edit member
    $(document).on('click', '#btn-update', function() {
        addMember(0);
    });

    //handel pagination by ajax
    $(document).on('click', '.search.pagination a', function(event) {
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        search(page);
    });

    // project members
    $(document).on('click', '#btn-search-member', function() {
        projectMembers();
    });

    // /import-file
    $(document).on('click', '#import-file', function(event) {
        $('#file-csv').click();
        $('#file-csv').change(function(event) {
            $('#form-input-file').submit();
        });
    });

    // comfirm export
    $(document).on('click', '#export-file', function(event) {
        getComfirmExport();
    });

     // save project
    $(document).on('click', '#add-project', function(event) {
        $('#form-save-project').submit();
    });

    // export file
    $(document).on('click', '#btn-add-export', function() {
        var type = $('.type_export:checked').val();
        exportFile(type);
    });
});

function search(page) {
    var teamId = $('#team').val();
    var startDay = $('#start-day').val();
    var endDay = $('#end-day').val();
    var url = action['project_search'];
    if (!page) {
        url += '?page=' + page;
    }

    $.ajax({
        type: 'POST',
        url: url,
        dataType: 'json',
        data: {
            teamId: teamId,
            startDay: startDay,
            endDay: endDay,
        },
        success:function(data) {
            $('#result-projects').html();
            $('#result-projects').html(data.html);
            $('.pagination').addClass('search');
            if (page) {
                location.hash = '?page=' + page;
            }
        }
    });
}

function searchMember(teamId, flag) {
    var projectId = $('#projectId').val();

    $.ajax({
        type: 'POST',
        url: action['project_search_member'],
        dataType: 'json',
        data: {
            teamId: teamId,
            projectId: projectId,
            flag: flag,
        },
        success:function(data) {
            if (data.html) {
                $.colorbox({ html : data.html });
            } else {
                bootbox.alert(trans['msg_emty_member']);
            }

        }
    });
}

function projectMembers() {
    var projectId = $('#projectId').val();
    var teamId = $('#teamId-member').val();
    var positionTeam = $('#position-team').val();
    var skills = [];
    $('.skills:checked').each(function() {
        skills.push($(this).val());
    });

    var level = [];
    $('.levels:checked').each(function() {
        level.push($(this).val());
    });

    $.ajax({
        type: 'POST',
        url: action['project_member'],
        dataType: 'json',
        data: {
            teamId: teamId,
            positionTeam: positionTeam,
            skills: skills,
            level: level,
            projectId: projectId,
        },
        success:function(data) {
            if (data.result) {
               $('#result-members').html();
               $('#result-members').html(data.html);
            }
        }
    });
}

function addMember(flag) {
    var projectId = $('#projectId').val();
    var teamId = $('#teamId-member').val();
    var leader = $('.leader').val();
    var userId = [];

    $('.add_user:checked').each(function() {
        userId.push($(this).val());
    });

    $.ajax({
        type: 'POST',
        url: action['project_add_member'],
        dataType: 'json',
        data: {
            projectId: projectId,
            userId: userId,
            leader: leader,
            teamId: teamId,
            flag :flag,
        },
        success:function(data) {
            $.colorbox.close();
            var messages;
            if (data.result) {
                messages = trans['msg_update_success'];
                if (data.flag) {
                    messages = trans['msg_insert_success'];
                }
                bootbox.alert(messages, function() {
                        location.reload();
                    });
            } else {
                messages = trans['msg_insert_fail'];
                if (data.flag) {
                    messages = trans['msg_update_fail'];
                }
                bootbox.alert(trans['msg_insert_fail']);
            }
        }
    });
}

function deleteMember(teamId, event) {
    var projectId = $('#projectId').val();
    var members = [];

    $('.current-team').find('.members').each(function() {
        members.push($(this).val());
    });

    $('tr').removeClass('.current-team');

    $.ajax({
        type: 'POST',
        url: action['project_delete_member'],
        dataType: 'json',
        data: {
            projectId: projectId,
            members: members,
            teamId: teamId,
        },
        success:function(data) {
            $.colorbox.close();
            if (data.result) {
                bootbox.alert(trans['msg_delete_success']);
                location.reload();
            } else {
                bootbox.alert(trans['msg_delete_fail']);
            }
        }
    });
}

function exportFile(type) {
    $('#teamId-export').attr('value', $('#team').val());
    $('#startDay-export').attr('value', $('#start-day').val());
    $('#endDay-export').attr('value', $('#end-day').val());
    $('#type-export').attr('value', type);
    $('#form-export-project').submit();

    $.colorbox.close();
    bootbox.alert(trans['msg_export_success']);
}
