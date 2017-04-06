<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>{{ trans('project.lbl-stt') }}</th>
            <th>{{ trans('project.lbl-name') }}</th>
            <th>{{ trans('project.lbl-short-name') }}</th>
            <th>{{ trans('project.lbl-start-day') }}</th>
            <th>{{ trans('project.lbl-end-day') }}</th>
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
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $project->name }}</td>
                    <td>{{ $project->short_name }}</td>
                    <td>{{ $project->start_day }}</td>
                    <td>{{ $project->end_day }}</td>
                    <td>
                        @if ($project->projectTeams)
                            @foreach($project->projectTeams as $projectTeam)
                                <a href="#" data-toggle="tooltip" data-placement="top" title="{{ $projectTeam->teamUser->user->name }}">{{ $projectTeam->teamUser->team->name.'| ' }}</a>
                            @endforeach
                        @endif
                    </td>
                    <td>
                        <div class="col-md-6">
                            <a href ="{{ action('Admin\ProjectController@edit', $project->id ) }}" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Edit project"><i class="fa fa-pencil-square-o"></i></a>
                        </div>

                        <div class="col-md-6">
                            {{ Form::open(['action' => 'Admin\ProjectController@destroy', 'method' => 'POST']) }}

                            {{ Form::hidden('projectId',$project->id) }}
                            {!! Form::button(trans('admin.lbl-delete'), ['class' => 'btn btn-primary', 'id' => 'updateFeature', 'type' => 'submit', 'data-toggle' => 'tooltip', 'title' => 'Delete project']) !!}
                            {{ Form::close() }}
                        </div>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
@if (isset($projects))
    {{ $projects->links() }}
@endif
