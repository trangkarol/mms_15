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
                $('#delete-form-user').submit();
            }
        });
    });

    //handel pagination by ajax
    $(document).on('click','.search.pagination a',function(event){
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        search(page);
    });

    //handel pagination by ajax
    $(document).on('click','#btn-add-skill',function(event){
        addSkill($(this), 1);
    });

    //handel pagination by ajax
    $(document).on('click','#btn-edit-skill',function(event){
        addSkill($(this), 0);
    });

    // get skill
    $(document).on('click', '.skill',function(event) {
        // $(this).addClass('users-current');
        var skillId = $(this).val();
        getFormSkill(skillId, 1);
    });

    // edit skill
    $(document).on('click', '.btn-edit-skill',function(event) {
        // $(this).addClass('users-current');
        var skillId = $(this).parents('tr').find('.skillId').html().trim();
        getFormSkill(skillId, 0);
    });

    // delete skill
    $(document).on('click', '.btn-delete-skill-popup',function(event) {
        var skillId = $(this).parents('tr').find('.skillId').html().trim();
        bootbox.confirm('Are you want to delete?', function(result){
            if(result) {
                 deleteSkill(skillId);
            }
        });
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
        bootbox.confirm('Are you want to delete?', function(result){
            if(result) {
                deleteTeam(teamId, 2);
            }
        });
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
        deleteTeam(event);
    });

    //import-file
    $(document).on('click', '#import-file', function(event) {
        // event.preventDefault();
        $('#file-csv').click();
        $('#file-csv').change(function(event) {
            $('#form-input-file').submit();
            // event.preventDefault();
            // var file = $(this).files;
            // console.log(file);
            // importFile(file);
        });
    });

    $(document).on('click', '#cboxClose', function() {
        $('.skill').prop('checked',false);
        $('.team').prop('checked',false);
    });

    // save user
    $(document).on('click', '#add-user',function(event) {
        $('#form-save-user').submit();
    });

    // comfirm export
    $(document).on('click', '#export-file', function(event) {
        getComfirmExport();
    });

    // export file
    $(document).on('click', '#btn-add-export', function() {
        var type = $('.type_export').val();
        exportFile(type);
    });

});

function search(page) {
	var teamId = $('#team').val();
    var position = $('#position').val();
    var positionTeams = $('#positionTeams').val();

	url = '/admin/users/search';
	if(page != 0){
		url = '/admin/users/search?page='+page;
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
    var skillId = $('#skillId-skill').val();
    var userId = $('#userId-skill').val();
    var exeper = $('.exeper').val();
    var level = $('.level').val();

    $.ajax({
        type: 'POST',
        url: '/admin/users/add-skill',
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
                if (flag == 1) {
                     bootbox.alert('Add skill succesfully');
                } else {
                    if (flag == 0) {
                         bootbox.alert('Edit skill succesfully');
                    } else {
                         bootbox.alert('Delete skill succesfully');
                    }
                }

                $('.skill:checked').parent().remove();
            } else {
                     bootbox.alert('Fail!');
            }
        }
    });
}


function deleteSkill(skillId) {
    var userId = $('#userId').val();

    $.ajax({
        type: 'GET',
        url: '/admin/users/delete-skill/'+skillId+'/'+userId,
        dataType: 'json',
        success:function(data){
            if (data.result) {
                bootbox.alert('Delete skill succesfully', function() {
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
                        bootbox.alert('Insert succesfully!');
                    } else {
                        bootbox.alert('Update succesfully!');
                    }

                    $('#result-team').html();
                    $('#result-team').html(data.html);
                    $('.team:checked').parent().remove();

                } else {
                    if(flag == 1 ) {
                        bootbox.alert('Insert fail!');
                    } else {
                        bootbox.alert('Update fail!');
                    }
                }
                $.colorbox.close();
        }
    });
}

function deleteTeam(teamId) {
    var userId = $('#userId').val();

    $.ajax({
        type : 'GET',
        url : '/admin/users/delete-team/'+teamId+'/'+userId,
        dataType : 'json',
        success:function(data) {
            if(data.result) {
                    $.colorbox.close();
                    bootbox.alert('Delete succesfully', function() {
                        $('#result-team').html();
                        $('#result-team').html(data.html);
                    });
                } else {
                    bootbox.alert('Delete fail');
                }
        }
    });
}

/*skill*/
function  getFormSkill(skillId, flag) {
    var userId = $('#userId').val();

    $.ajax({
        type : 'POST',
        url : '/admin/users/get-skill',
        dataType : 'json',
        data : {
            skillId : skillId,
            userId : userId,
            flag : flag,
        },
        success:function(data) {
            $.colorbox({html : data.html});
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
    bootbox.alert('Export file succesfully!');
    //                 window.location = data.urlFile;
    //             });
    // $('#type-exxport').prop('value', type);
    // var teamId = $('#team').val();
    // var position = $('#position').val();
    // var positionTeams = $('#positionTeams').val();
    // var url = '/admin/users/export-file/'+type+'/'+teamId+'/'+position+'/'+positionTeams;
    // $.ajax({
    //     type: 'GET',
    //     url: url,
    //     loading: true,
    //     dataType: 'json',
    //     success:function(data){
    //         console.log(data);
    //         $.colorbox.close();
    //         if (data.result) {
    //             bootbox.alert('Export file succesfully!', function() {
    //                 window.location = data.urlFile;
    //             });
    //         } else {
    //                 bootbox.alert('Export file fail!');
    //         }
    //     }
    // });
}
