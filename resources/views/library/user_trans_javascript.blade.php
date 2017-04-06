<script type="text/javascript">
    var trans = {
            'msg_emty_member': '{{ trans('public.msg.empty-member') }}',
            'msg_update_success': '{{ trans('public.msg.update-success') }}',
            'msg_delete_success': '{{ trans('public.msg.delete-success') }}',
            'msg_update_fail': '{{ trans('public.msg.update-fail') }}',
            'msg_delete_fail': '{{ trans('public.msg.delete-fail') }}',
            'msg_insert_fail': '{{ trans('public.msg.insert-fail') }}',
            'msg_comfirm_delete': '{{ trans('public.msg.delete-comfirm') }}',
            'msg_insert_success': '{{ trans('public.msg.insert-success') }}',
            'msg_export_success': '{{ trans('user.msg.export-success') }}',
            'msg_export_fail': '{{ trans('user.msg.export-fail') }}',
            'msg_add_skill_sucess': '{{ trans('user.msg.add-skill-sucess') }}',
            'msg_edit_skill_fail': '{{ trans('user.msg.edit-skill-fail') }}',
            'msg_delete_skill_fail': '{{ trans('user.msg.delete-skill-fail') }}',
            'msg_delete_skill_sucess': '{{ trans('user.msg.delete-skill-sucess') }}',
            'msg_fail': '{{ trans('user.msg.fail') }}',
        };

    var action = {
            'user_search': "{{ action('Admin\UserController@search') }}",
            'user_add_skill': "{{ action('Admin\UserController@addSkill') }}",
            'user_position_team': "{{ action('Admin\UserController@positionTeam') }}",
            'user_add_team': "{{ action('Admin\UserController@addTeam') }}",
            'user_get_skill': "{{ action('Admin\UserController@getSkill') }}",
            'user_delete_skill': "{{ action('Admin\UserController@deleteSkill') }}",
            'user_delete_team': "{{ action('Admin\UserController@deleteTeam') }}",
        };
</script>

