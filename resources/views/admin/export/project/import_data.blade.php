@extends('common.block.master')
<!-- title off page -->
@section('title')
    {{ trans('project.title-projects') }}
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
                     <div class="col-md-6">
                        <a href="#" class="btn btn-primary" id="add-project" data-toggle="tooltip" data-placement="top" title="Add projects"><i class="fa fa-user-plus " ></i></a>
                        {{ Form::open(['action' => 'Admin\ProjectController@saveImport', 'id' => 'form-save-project']) }}

                            {{ Form::hidden('nameFile',$nameFile) }}
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
        <!-- end title -->
        <div class="clearfix"></div>
        @include ('common.messages')
        <div class="row">
            <div class="x_content">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>{{ trans('user.lbl-data-import') }}</h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>{{ trans('project.lbl-stt') }}</th>
                                                <th>{{ trans('project.lbl-name') }}</th>
                                                <th>{{ trans('project.lbl-short-name') }}</th>
                                                <th>{{ trans('project.lbl-start-day') }}</th>
                                                <th>{{ trans('project.lbl-end-day') }}</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @if (isset($projects))
                                                @foreach ($projects as $project)
                                                    <tr>
                                                        <td class="text-center">{{ $loop->iteration }}</td>
                                                        <td>{{ $project->name }}</td>
                                                        <td>{{ $project->short_name }}</td>
                                                        <td>{{ $project->startday }}</td>
                                                        <td>{{ $project->enday }}</td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
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
