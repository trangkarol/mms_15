@extends('admin.block.main')
<!-- title off page -->
@section('title')
    {{ trans('user.title-users') }}
@endsection
<!-- css used for page -->
<!-- content of page -->
@section('content')
    <div class="row">
        <div class="col-md-3 sub-menu">
            <h4>{{trans('user.title-users')}}</h4>
        </div>

        <div class="col-md-4 col-md-offset-2 paddingtop">
            <div class="col-md-4">
                <a href="{{ action('Admin\UserController@create') }}" class="btn btn-primary"><i class="fa fa-user-plus " ></i></a>
            </div>

            <div class="col-md-4">
                <a href="#" class="btn btn-primary" id= "import-file"><i class="glyphicon glyphicon-import" ></i></a>
                {!! Form::open(['action' => 'Admin\UserController@importFile', 'class' => 'form-horizontal', 'id' => 'form-input-file', 'enctype' => 'multipart/form-data']) !!}
                    {{  Form::file('file', ['id' => 'file-csv', 'class' => 'hidden']) }}

                {!! Form::close() !!}
            </div>

            <div class="col-md-4">
                <a href="#" class="btn btn-primary" id= "export-file"><i class="glyphicon glyphicon-export" ></i></a>
                {!! Form::open(['action' => 'Admin\UserController@importFile', 'class' => 'form-horizontal', 'id' => 'form-input-file', 'enctype' => 'multipart/form-data']) !!}
                    {{  Form::file('file', ['id' => 'file-csv', 'class' => 'hidden']) }}

                {!! Form::close() !!}
            </div>

        </div>
    </div>
    <!-- content -->
    <div class="row">
        <div class="col-md-12 paddingtop">
            <div class="panel panel-primary ">
                @include('admin.user.search')
            </div>
            @include('common.messages')
            <div class="panel panel-primary ">
                <div class="panel-heading">
                    {{ trans('admin.lbl-result-search') }}
                </div>
                <!--  -->
                <div class="panel-body">
                    <div class="table-responsive" id ="result-users">
                        @include('admin.user.table_result')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<!-- js used for page -->
@section('contentJs')
    @parent
    {{ Html::script('/admin/js/user.js') }}
@endsection
