@extends('admin.block.main')
<!-- title off page -->
@section('title')
    {{trans('project.title-insert-projects')}}
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
                    {{ trans('project.title-insert-projects') }}
                </div>
                <!--  -->
                <div class="panel-body">
                    {!! Form::open(['action' => 'Admin\ProjectController@store', 'method' => 'POST', 'class' => 'form-horizontal']) !!}

                        @include('admin.project.form_project')
                        <!-- button -->
                       <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                {{ Form::reset(trans('admin.btn-reset'), ['class' => 'btn btn-primary']) }}

                                 {{ Form::submit(trans('admin.btn-insert'), ['class' => 'btn btn-primary']) }}
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
    <!-- add trans and action used in file ptoject.js -->
    @include('library.project_trans_javascript')
@endsection
