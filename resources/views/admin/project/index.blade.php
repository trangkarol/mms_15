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
            <a href="{{ action('Admin\ProjectController@create') }}" class="btn btn-primary"><i class="fa fa-plus " ></i></a>
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
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>{{ trans('project.lbl-stt') }}</th>
                                    <th>{{ trans('project.lbl-name') }}</th>
                                    <th>{{ trans('project.lbl-short-name') }}</th>
                                    <th>{{ trans('project.lbl-start-day') }}</th>
                                    <th>{{ trans('project.lbl-end-day') }}</th>
                                    <th>{{ trans('project.lbl-leader') }}</th>
                                    <th>{{ trans('project.lbl-team') }}</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($projects))
                                    @php
                                        $index = 0;
                                    @endphp
                                    @foreach ($projects as $project)
                                            @if($project->teamUsers)
                                                @foreach ($project->teamUsers as $teamUser)
                                                    @php
                                                        $index = $index + 1;
                                                    @endphp
                                                    <tr>
                                                        <td class="text-center">{{ $index }}</td>
                                                        <td>{{ $project->name }}</a></td>
                                                        <td>{{ $project->short_name }}</a></td>
                                                        <td>{{ $project->start_day }}</a></td>
                                                        <td>{{ $project->end_day }}</a></td>
                                                        <td>{{ $teamUser->user->name }}</a></td>
                                                        <td>
                                                            {{ $teamUser->team->name }}
                                                        </td>
                                                        <td>
                                                            <div class="col-md-6">
                                                                <a href ="{{ action('Admin\ProjectController@edit', $project->id ) }}" class="btn btn-primary"><i class="fa fa-pencil-square-o"></i></a>
                                                            </div>

                                                            <div class="col-md-6">
                                                                {{ Form::open(['action' => 'Admin\ProjectController@destroy', 'method' => 'POST']) }}

                                                                {{ Form::hidden('projectId',$project->id) }}
                                                                {!! Form::button(trans('admin.lbl-delete'), ['class' => 'btn btn-primary', 'id' => 'updateFeature', 'type' => 'submit']) !!}
                                                                {{ Form::close() }}
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                @php
                                                    $index = $index + 1;
                                                @endphp
                                                <tr>
                                                    <td class="text-center">{{ $index  }}</td>
                                                    <td>{{ $project->name }}</a></td>
                                                    <td>{{ $project->short_name }}</a></td>
                                                    <td>{{ $project->start_day }}</a></td>
                                                    <td>{{ $project->end_day }}</a></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td>
                                                        <div class="col-md-6">
                                                            <a href ="{{ action('Admin\ProjectController@edit', $project->id ) }}" class="btn btn-primary"><i class="fa fa-pencil-square-o"></i></a>
                                                        </div>

                                                        <div class="col-md-6">
                                                            {{ Form::open(['action' => 'Admin\ProjectController@destroy', 'method' => 'POST']) }}

                                                            {{ Form::hidden('projectId',$project->id) }}
                                                            {!! Form::button(trans('admin.lbl-delete'), ['class' => 'btn btn-primary', 'id' => 'updateFeature', 'type' => 'submit']) !!}
                                                            {{ Form::close() }}
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        @if (isset($projects))
                            {{ $projects->links() }}
                        @endif
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
@endsection

