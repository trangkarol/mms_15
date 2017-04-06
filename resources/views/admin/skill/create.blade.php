@extends('common.block.master')
<!-- title off page -->
@section('title')
    {{ trans('skill.title-insert-skills') }}
@endsection
<!-- css used for page -->
<!-- content of page -->
@section('content')
     <div class="">
        <!-- title -->
        <div class="page-title">
            <div class="title_left">
                <h3>{{ trans('skill.title-skills') }}</h3>
            </div>
            <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group">
                    <div class="col-md-4">
                       <a href="{{ action('Admin\SkillController@index') }}" class="btn btn-primary" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="List skills"><i class="fa fa-list " ></i></a>
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
                                <h2> {{ trans('skill.title-insert-skills') }} </h2>
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                        </li>
                                    </ul>
                                <div class="clearfix"></div>
                            </div>
                            {!! Form::open(['action' => 'Admin\SkillController@store', 'class' => 'form-horizontal']) !!}
                                @include('admin.skill.form_skill')
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-8">
                                        {{ Form::reset(trans('admin.btn-reset'), ['class' => 'btn btn-success']) }}
                                         {{ Form::submit(trans('admin.btn-insert'), ['class' => 'btn btn-success']) }}
                                    </div>
                                </div>
                            {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
