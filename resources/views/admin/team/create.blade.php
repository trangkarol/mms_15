@extends('admin.block.main')
<!-- title off page -->
@section('title')
    {{ trans('team.title-insert-teams') }}
@endsection
<!-- css used for page -->
<!-- content of page -->
@section('content')
    <div class="row">
        <div class="col-md-3 sub-menu">
            <h4>{{ trans('team.title-teams') }}</h4>
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
                    {{ trans('team.title-insert-teams') }}
                </div>

                <div class="panel-body">
                {!! Form::open(['action' => 'Admin\TeamController@store', 'class' => 'form-horizontal']) !!}
                    @include('admin.team.form_team')
                    <!-- button -->
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            {{ Form::reset(trans('admin.btn-reset'), ['class' => 'btn btn-primary']) }}
                            {{ Form::submit(trans('admin.btn-insert'), ['class' => 'btn btn-primary']) }}
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
    <!-- add trans and action used in file team.js -->
    @include('library.team_trans_javascript')
@endsection
