@extends('admin.block.main')
<!-- title off page -->
@section('title')
    {{trans('languages.title-update-users')}}
@endsection
<!-- css used for page -->
<!-- content of page -->
@section('content')
    <div class="row">
        <div class="col-md-3 sub-menu">
            <h4>{{ trans('user.title-users') }}</h4>
        </div>

        <div class="col-md-4 col-md-offset-3 paddingtop">
            <a href="{{ action('Admin\UserController@index') }}" class="btn btn-primary"><i class="fa fa-list " ></i></a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 paddingtop">
            @include('common.messages')
            <div class="panel panel-primary ">
                <div class="panel-heading">
                    {{ trans('user.title-update-users') }}
                </div>
                <!--  -->
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ action('Admin\UserController@update', $user->id) }}">
                        {{ csrf_field() }}
                        {{ Form::hidden('userId', $user->id, ['id' => 'userId']) }}

                        @include('admin.user.form_user')
                        <!-- button -->
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="reset" class="btn btn-primary">
                                    {{ trans('admin.btn-reset') }}
                                </button>

                                <button type="submit" class="btn btn-primary">
                                    {{ trans('admin.btn-update') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- Pagination -->

            </div>
        </div>
    </div>
@endsection
<!-- js used for page -->
@section('contentJs')
    @parent
    {{ Html::script('admin/js/user.js') }}

    <!-- message -->
    <script type="text/javascript">
        var trans = {
                'msg_emty_member' : '{{ trans('user.msg.empty-member') }}',
                'msg_update_success' : '{{ trans('team.msg.update-success') }}',
                'msg_delete_success' : '{{ trans('team.msg.delete-success') }}',
                'msg_update_fail' : '{{ trans('team.msg.update-fail') }}',
                'msg_delete_fail' : '{{ trans('team.msg.delete-fail') }}',
                'msg_insert_fail' : '{{ trans('team.msg.insert-fail') }}',
                'msg_insert_success' : '{{ trans('team.msg.insert-success') }}',
                'msg_add_skill_sucess' : '{{ trans('user.msg.add-skill-sucess') }}',
                'msg_edit_skill_sucess' : '{{ trans('user.msg.edit-skill-sucess') }}',
                'msg_delete_skill_sucess' : '{{ trans('user.msg.delete-skill-sucess') }}',
                'msg_fail' : '{{ trans('user.msg.fail') }}',
            }
    </script>
    <!-- content -->
@endsection
