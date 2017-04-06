@extends('common.block.master')
<!-- title off page -->
@section('title')
    {{ trans('position.title-update-positions') }}
@endsection
<!-- css used for page -->
<!-- content of page -->
@section('content')
     <div class="">
        <!-- title -->
        <div class="page-title">
            <div class="title_left">
                <h3>{{ trans('position.title-positions') }}</h3>
            </div>
            <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group">
                    <div class="col-md-4">
                       <a href="{{ action('Admin\PositionController@index') }}" class="btn btn-primary"  data-toggle="tooltip" data-placement="top" title="List positions"><i class="fa fa-list " ></i></a>
                    </div>
                </div>
            </div>
        </div>
        <!-- end title -->
        <div class="clearfix"></div>
        <!-- form search -->
        @include('common.messages')
        <div class="row">
            <div class="x_content">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>{{ trans('position.title-insert-positions') }}</h2>
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                        </li>
                                    </ul>
                                <div class="clearfix"></div>
                            </div>
                            {!! Form::open(['action' => 'Admin\PositionController@update', 'class' => 'form-horizontal']) !!}
                                {{ Form::hidden('positionId', $position->id) }}
                                @include('admin.position.form_position')
                                <!-- button -->
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-8">
                                        {{ Form::reset(trans('admin.btn-reset'), ['class' => 'btn btn-success']) }}

                                        {{ Form::submit(trans('admin.btn-update'), ['class' => 'btn btn-success']) }}
                                    </div>
                                </div>
                            {{ Form::close() }}
                            </div>
                        </div>
                    </div>
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
