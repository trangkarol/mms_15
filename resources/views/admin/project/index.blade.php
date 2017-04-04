@extends('admin.block.main')
<!-- title off page -->
@section('title')
    {{ trans('project.title-project') }}
@endsection
<!-- css used for page -->
<!-- content of page -->
@section('content')
    <div class="row">
        <div class="col-md-3 sub-menu">
            <h4>{{trans('project.title-projects')}}</h4>
        </div>

        <div class="col-md-4 col-md-offset-3 paddingtop">

             <div class="col-md-4">
               <a href="{{ action('Admin\ProjectController@create') }}" class="btn btn-primary"><i class="fa fa-plus " ></i></a>
            </div>

            <div class="col-md-4">
                <a href="#" class="btn btn-primary" id= "import-file"><i class="glyphicon glyphicon-import" ></i></a>
                {!! Form::open(['action' => 'Admin\ProjectController@importFile', 'class' => 'form-horizontal', 'id' => 'form-input-file', 'enctype' => 'multipart/form-data']) !!}
                    {{  Form::file('file', ['id' => 'file-csv', 'class' => 'hidden']) }}

                {!! Form::close() !!}
            </div>

            <div class="col-md-4">
                <a href="#" class="btn btn-primary" id= "export-file"><i class="glyphicon glyphicon-export" ></i></a>
                {!! Form::open(['action' => 'Admin\ProjectController@exportFile', 'class' => 'form-horizontal', 'id' => 'form-export-project', 'enctype' => 'multipart/form-data']) !!}
                    {{ Form::hidden('teamId',null, ['id' => 'teamId-export']) }}
                    {{ Form::hidden('startDay',null, ['id' => 'startDay-export']) }}
                    {{ Form::hidden('endDay',null, ['id' => 'endDay-export']) }}
                    {{ Form::hidden('type',null, ['id' => 'type-export']) }}

                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <!-- content -->
    <div class="row">
        <div class="col-md-12 paddingtop">
            <div class="panel panel-primary ">
                @include('admin.project.search')
            </div>
            @include('common.messages')
            <div class="panel panel-primary ">
                <div class="panel-heading">
                    {{ trans('admin.lbl-result-search') }}
                </div>
                <!--  -->
                <div class="panel-body">
                    <div class="table-responsive" id ="result-projects">
                        @include('admin.project.table_result')
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

