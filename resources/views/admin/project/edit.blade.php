@extends('common.block.master')
<!-- title off page -->
@section('title')
    {{ trans('project.title-update-projects') }}
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
                       <a href="{{ action('Admin\ProjectController@index') }}" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="List projects"><i class="fa fa-list " ></i></a>
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
                                <h2> {{ trans('project.title-update-projects') }} </h2>
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                        </li>
                                    </ul>
                                <div class="clearfix"></div>
                            </div>
                            {!! Form::open(['action' => 'Admin\ProjectController@update', 'class' => 'form-horizontal']) !!}
                                {{ Form::hidden('projectId', $project->id) }}
                                @include('admin.project.form_project')
                                <!-- button -->
                                <div class="form-group">
                                    <div class="col-md-5 col-md-offset-7">
                                        <div class="col-md-3">
                                            {{ Form::reset(trans('admin.btn-reset'), ['class' => 'btn btn-success']) }}
                                        </div>
                                        <div class="col-md-3">
                                            {{ Form::submit(trans('admin.btn-update'), ['class' => 'btn btn-success']) }}
                                        </div>
                                    </div>
                                </div>
                            {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @if(isset($project))
            <div class="row">
                <div class="x_content">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2> {{ trans('project.lbl-team') }}</h2>
                                        <ul class="nav navbar-right panel_toolbox">
                                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                            </li>
                                        </ul>
                                    <div class="clearfix"></div>
                                </div>
                               <div class="x_content">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th class="hidden"></th>
                                                <th >{{ trans('team.lbl-stt') }}</th>
                                                <th >{{ trans('team.lbl-team') }}</th>
                                                <th ></th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                        @if(isset($listTeams))
                                            @foreach ($listTeams as $listTeam)
                                                <tr>
                                                    <td class="hidden teamMemberId">{{ $listTeam->id}}</td>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>
                                                        @php $members = ''; @endphp
                                                        @foreach ($listTeam->users as $user)
                                                            @php $members = $members.$user->name.' | '; @endphp
                                                            {{ Form::hidden('members[]', $user->id, ['class' => 'form-control members']) }}
                                                        @endforeach
                                                        <a href="#" data-toggle="tooltip" data-placement="top" title="{{ rtrim($members, ' | ') }}">{{ $listTeam->name }}</a>

                                                    </td>
                                                    <td>
                                                        <div class="col-md-2">
                                                            {!! Form::button(trans('admin.lbl-edit'), ['class' => 'btn btn-primary btn-edit-team', 'id' => '']) !!}
                                                        </div>
                                                        <div class="col-md-2">
                                                            {!! Form::button(trans('admin.lbl-delete'), ['class' => 'btn btn-primary btn-delete-team', 'id' => '']) !!}
                                                        </div>
                                                    </td>
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
            @endif
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
