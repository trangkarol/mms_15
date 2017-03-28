@extends('admin.block.main')
<!-- title off page -->
@section('title')
    {{ trans('team.title-update-teams') }}
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
            @include('common.messages')
            <div class="panel panel-primary ">
                <div class="panel-heading">
                    {{ trans('team.title-update-teams') }}
                </div>
                <!--  -->
                <div class="panel-body">
                {!! Form::open(['action' => 'Admin\TeamController@update', 'class' => 'form-horizontal']) !!}

                    {{ Form::hidden('teamId', $team->id) }}
                    @include('admin.team.form_team')
                    <!-- button -->
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            {{ Form::reset(trans('admin.btn-reset'), ['class' => 'btn btn-primary']) }}

                            {{ Form::submit(trans('admin.btn-update'), ['class' => 'btn btn-primary']) }}
                        </div>
                    </div>
                {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection
<!-- js used for page -->
@section('contentJs')
    @parent
    {{ Html::script('admin/js/team.js') }}
@endsection
