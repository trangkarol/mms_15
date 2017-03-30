@extends('admin.block.main')
<!-- title off page -->
@section('title')
    {{ trans('team.title-members-teams') }}
@endsection
<!-- css used for page -->
<!-- content of page -->
@section('content')
    <div class="row">
        <div class="col-md-3 sub-menu">
            <h4>{{trans('team.title-teams')}}</h4>
        </div>
        <div class="col-md-4 col-md-offset-3 paddingtop">
            <a href="{{ action('Admin\TeamController@index') }}" class="btn btn-primary"><i class="fa fa-list " ></i></a>
        </div>
    </div>
    <!-- content -->
    <div class="row">
        <div class="col-md-12 paddingtop">
            <div class="panel panel-primary ">
                <div class="panel-heading">
                    {{ trans('admin.lbl-search') }}
                </div>
                <!--     -->
                <div class="panel-body">
                    <div class="row">
                        {{ Form::label('skill', trans('team.lbl-skill'), ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-6 table-result">
                            @foreach ($skills as $key => $skill)
                                <div class="col-md-6">
                                    {{ Form::checkbox('skills[]', $key, null, ['class' => 'skills' ]) }} {{ $skill }}
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="row div-level">
                        {{ Form::label('levels', trans('team.lbl-levels'), ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-6">
                            <div class="col-md-5">
                                {{ Form::checkbox('levels[]', config('setting.level.junior'), null, ['class' => 'levels']) }} {{ trans('team.lbl-junior') }}
                            </div>

                            <div class="col-md-5">
                                {{ Form::checkbox('levels[]', config('setting.level.senior'), null, ['class' => 'levels'] ) }} {{ trans('team.lbl-senior') }}
                            </div>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 col-md-offset-8">
                            {{ Form::button(trans('admin.lbl-search'), ['class' => 'btn btn-primary', 'id' => 'btn-search']) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 paddingtop">
            <div class="panel panel-primary ">
                <div class="panel-heading">
                    {{ trans('team.title-members-teams') }}
                </div>
                <!--  -->
                <div class="panel-body">
                    <div class="col-md-5">
                        {{ Form::select('teamId', $teams, null, ['class' => 'form-control', 'id' => 'teamId']) }}
                    </div>
                </div>
                <!--  -->
                <div class="panel-body" id="result-member">
                    @if(isset($users))
                        @include('admin.team.search_user')
                    @endif
                </div>

            </div>
        </div>
        <!-- list member in teams -->
         <div class="col-md-12 paddingtop">
            <div class="panel panel-primary ">
                <div class="panel-heading">
                    {{ trans('team.title-list-member') }}
                </div>
                <!--  -->
                <div class="panel-body" id="result-list-member">
                    @if(isset($members))
                        @include('admin.team.list_member')
                    @endif
                </div>

            </div>
        </div>
    </div>
@endsection
<!-- js used for page -->
@section('contentJs')
    @parent
      <!-- message -->
    <script type="text/javascript">
        var trans = {
                'msg_emty_member' : '{{ trans('public.msg.empty-member') }}',
                'msg_update_success' : '{{ trans('public.msg.update-success') }}',
                'msg_delete_success' : '{{ trans('public.msg.delete-success') }}',
                'msg_update_fail' : '{{ trans('public.msg.update-fail') }}',
                'msg_delete_fail' : '{{ trans('public.msg.delete-fail') }}',
                'msg_insert_fail' : '{{ trans('public.msg.insert-fail') }}',
                'msg_insert_success' : '{{ trans('public.msg.insert-success') }}',
            }
    </script>
    {{ Html::script('/admin/js/team.js') }}

@endsection
