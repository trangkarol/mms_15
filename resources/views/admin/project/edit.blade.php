@extends('admin.block.main')
<!-- title off page -->
@section('title')
    {{trans('project.title-update-projects')}}
@endsection
<!-- css used for page -->
<!-- content of page -->
@section('content')
    <div class="row">
        <div class="col-md-3 sub-menu">
            <h4>{{ trans('project.title-projects') }}</h4>
        </div>

        <div class="col-md-4 col-md-offset-3 paddingtop">
            <a href="{{ action('Admin\ProjectController@index') }}" class="btn btn-primary"><i class="fa fa-list " ></i></a>
        </div>
    </div>

    <!-- content -->
    <div class="row">
        <div class="col-md-12 paddingtop">
            @include('common.messages')
            <div class="panel panel-primary ">
                <div class="panel-heading">
                    {{ trans('project.title-update-projects') }}
                </div>
                <!--  -->
                <div class="panel-body">
                    {!! Form::open(['action' => 'Admin\ProjectController@update', 'class' => 'form-horizontal']) !!}

                        @include('admin.project.form_project')
                        <!-- button -->
                       <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                {{ Form::reset(trans('admin.btn-reset'), ['class' => 'btn btn-primary']) }}

                                 {{ Form::submit(trans('admin.btn-update'), ['class' => 'btn btn-primary']) }}
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
                <!-- Pagination -->

            </div>
        </div>
    </div>
@endsection
<!-- js used for page -->
@section('contentJs')
    @parent
    {{ Html::script('admin/js/project.js') }}
      <script type="text/javascript">
        var trans = {
                'msg_emty_member' : '{{ trans('project.msg.empty-member') }}',
                'msg_update_success' : '{{ trans('project.msg.update-success') }}',
                'msg_delete_success' : '{{ trans('project.msg.delete-success') }}',
                'msg_update_fail' : '{{ trans('project.msg.update-fail') }}',
                'msg_delete_fail' : '{{ trans('project.msg.delete-fail') }}',
                'msg_insert_fail' : '{{ trans('project.msg.insert-fail') }}',
                'msg_insert_success' : '{{ trans('project.msg.insert-success') }}',
            }
    </script>
@endsection
