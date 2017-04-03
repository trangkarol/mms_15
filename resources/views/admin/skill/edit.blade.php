@extends('admin.block.main')
<!-- title off page -->
@section('title')
    {{ trans('skill.title-update-skills') }}
@endsection
<!-- css used for page -->
<!-- content of page -->
@section('content')
    <div class="row">
        <div class="col-md-3 sub-menu">
            <h4>{{trans('skill.title-skills')}}</h4>
        </div>
        <div class="col-md-4 col-md-offset-3 paddingtop">
            <a href="{{ action('Admin\SkillController@index') }}" class="btn btn-primary"><i class="fa fa-list " ></i></a>
        </div>
    </div>
    <!-- content -->
    <div class="row">
         <div class="col-md-12 paddingtop">
            @include('common.messages')
            <div class="panel panel-primary ">
                <div class="panel-heading">
                    {{ trans('skill.title-update-skills') }}
                </div>
                <!--  -->
                <div class="panel-body">
                {!! Form::open(['action' => 'Admin\SkillController@update', 'class' => 'form-horizontal']) !!}
                    {{ Form::hidden('skillId', $skill->id) }}
                    @include('admin.skill.form_skill')
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
