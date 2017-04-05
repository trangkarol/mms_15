<script type="text/javascript">
    var trans = {
            'msg_emty_member': '{{ trans('public.msg.empty-member') }}',
            'msg_update_success': '{{ trans('public.msg.update-success') }}',
            'msg_delete_success': '{{ trans('public.msg.delete-success') }}',
            'msg_update_fail': '{{ trans('public.msg.update-fail') }}',
            'msg_delete_fail': '{{ trans('public.msg.delete-fail') }}',
            'msg_insert_fail': '{{ trans('public.msg.insert-fail') }}',
            'msg_comfirm_delete': '{{ trans('public.msg.comfirm-delete') }}',
            'msg_insert_success': '{{ trans('public.msg.insert-success') }}',
            'msg_export_success': '{{ trans('team.msg.export-success') }}',
        };

    var action = {
            'team_search': "{{ action('Admin\TeamController@search') }}",
            'team_store_member': "{{ action('Admin\TeamController@storeMember') }}",
            'team_position_member': "{{ action('Admin\TeamController@positionTeam') }}",
            'team_search_member': "{{ action('Admin\TeamController@searchMember') }}",
            'team_delete_member': "{{ action('Admin\TeamController@deleteMember') }}",
        };
</script>
