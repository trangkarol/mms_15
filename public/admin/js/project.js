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
        $('.team').prop('checked', false);
        $(this).prop('checked', true);

       var teamId = $(this).val();
       searchMember(teamId, 1);
    });

    //edit member
    $(document).on('click','.btn-edit-team',function(){
        var teamId = $(this).parents('tr').find('.teamMemberId').html().trim();
       searchMember(teamId, 0);
    });

    //delete member
    $(document).on('click','.btn-delete-team',function(event){
        var teamId = $(this).parents('tr').find('.teamMemberId').html().trim();
        $(this).parents('tr').addClass('current-team');
        bootbox.confirm('Are you want to delete?', function(result){
            if(result) {

                deleteMember(teamId, $(this));
            }
        });
    });

    // add tab
    $(document).on('click','#btn-add-member',function(){
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

    // project members
    $(document).on('click','#btn-search-member',function(){
       projectMembers();
    });

    // /import-file
    $(document).on('click', '#import-file', function(event) {
        // event.preventDefault();
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
    $(document).on('click', '#add-project',function(event) {
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

    url = '/admin/projects/search';
    if(page != 0){
        url = '/admin/projects/search?page='+page;
    }

    $.ajax({
        type: 'POST',
        url: url,
        dataType: 'json',
        data: {
            teamId: teamId,
            startDay: startDay,
            endDay: endDay
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
                bootbox.alert('Data empty!');
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
    // var level = $('.levels').val();

    $.ajax({
        type: 'POST',
        url: '/admin/projects/project-member',
        dataType: 'json',
        data: {
            teamId : teamId,
            positionTeam : positionTeam,
            skills : skills,
            level : level,
            projectId: projectId,
        },
        success:function(data){
            if(data.result) {
               $('#result-members').html();
               $('#result-members').html(data.html);
            }

        }
    });
}

function addMember(flag) {
    var projectId = $('#projectId').val();
    var teamId = $('#teamId-member').val();
    var userId = [];
    var leader = $('.leader').val();

    $('.add_user:checked').each(function() {
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
                    $.colorbox.close();
                    bootbox.alert('Insert successfuly!', function() {
                        location.reload();
                    });
                } else {
                    bootbox.alert('Update successfuly!', function() {
                        location.reload();
                    });
                }


            } else {
                if(flag == 1 ) {
                    bootbox.alert(trans['Insert fail!']);
                } else {
                    bootbox.alert(trans['Update fail']);
                }

                $.colorbox.close();
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
                bootbox.alert('Delete successfuly!');
                $.colorbox.close();
                location.reload();
                // searchMember();
            } else {
                bootbox.alert('Delete fail!');

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

function exportFile(type) {
    console.log($('#start-day').val());
    $('#teamId-export').attr('value', $('#team').val());
    $('#startDay-export').attr('value', $('#start-day').val());
    $('#endDay-export').attr('value', $('#end-day').val());
    $('#type-export').attr('value', type);

    $('#form-export-project').submit();
    $.colorbox.close();
    bootbox.alert('Export file succesfully!');
}
