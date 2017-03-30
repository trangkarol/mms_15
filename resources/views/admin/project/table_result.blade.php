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
        @if (!empty($projects))
            @php
                $index =0;
            @endphp
            @foreach ($projects as $project)
                @if ($project->projectTeams)
                    @foreach($project->projectTeams as $projectTeam)
                        @php
                            $index = $index+1;
                        @endphp
                        <tr>
                            <td class="text-center">{{ $index }}</td>
                            <td>{{ $project->name }}</td>
                            <td>{{ $project->short_name }}</td>
                            <td>{{ $project->start_day }}</td>
                            <td>{{ $project->end_day }}</td>
                            <td>@if ($projectTeam->teamUser->user) {{ $projectTeam->teamUser->user->name }} @endif</td>
                            <td>
                                @if ($projectTeam->teamUser->team) {{ $projectTeam->teamUser->team->name }} @endif
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
                            $index = $index+1;
                        @endphp
                     <tr>
                        <td class="text-center">{{ $index }}</td>
                        <td>{{ $project->name }}</td>
                        <td>{{ $project->short_name }}</td>
                        <td>{{ $project->start_day }}</td>
                        <td>{{ $project->end_day }}</td>
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
