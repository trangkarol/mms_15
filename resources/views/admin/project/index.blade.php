@extends('common.block.master')
<!-- title off page -->
@section('title')
    {{ trans('project.title-project') }}
@endsection
<!-- css used for page -->
<!-- content of page -->
@section('content')
    <div class="">
        <!-- title -->
        <div class="page-title">
            <div class="title_left">
                <h3>{{ trans('project.title-projects') }}</h3>
            </div>
            <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group">
                    <div class="col-md-4">
                       <a href="{{ action('Admin\ProjectController@create') }}" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Create project"><i class="fa fa-plus " ></i></a>
                    </div>

                    <div class="col-md-4">
                        <a href="#" class="btn btn-primary" id= "import-file" data-toggle="tooltip" data-placement="top" title="Import file"><i class="glyphicon glyphicon-import" ></i></a>
                        {!! Form::open(['action' => 'Admin\ProjectController@importFile', 'class' => 'form-horizontal', 'id' => 'form-input-file', 'enctype' => 'multipart/form-data']) !!}
                            {{  Form::file('file', ['id' => 'file-csv', 'class' => 'hidden']) }}

                        {!! Form::close() !!}
                    </div>

                    <div class="col-md-4">
                        <a href="#" class="btn btn-primary" id= "export-file" data-toggle="tooltip" data-placement="top" title="Export file"><i class="glyphicon glyphicon-export" ></i></a>
                        {!! Form::open(['action' => 'Admin\ProjectController@exportFile', 'class' => 'form-horizontal', 'id' => 'form-export-project', 'enctype' => 'multipart/form-data']) !!}
                            {{ Form::hidden('teamId',null, ['id' => 'teamId-export']) }}
                            {{ Form::hidden('startDay',null, ['id' => 'startDay-export']) }}
                            {{ Form::hidden('endDay',null, ['id' => 'endDay-export']) }}
                            {{ Form::hidden('type',null, ['id' => 'type-export']) }}

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
        <!-- end title -->
        <div class="clearfix"></div>
        <!-- form search -->
        <div class="row">
            @include('admin.project.search')
        </div>
        @include('common.messages')
        <div class="row">
            <div class="x_content">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2> {{ trans('admin.lbl-result-search') }} </h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content" id="result-projects">
                                @include('admin.project.table_result')
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
    {{ Html::script('admin/js/project.js') }}
    <!-- add trans and action used in file ptoject.js -->
    @include('library.project_trans_javascript')
@endsection
